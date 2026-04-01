let click = 0;
let validCode = true;
let validName = true;

const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');
const regex = /[^a-zA-Z0-9-_.@]+/gi;

if (inputCode) {
  inputCode.addEventListener('keyup', () => validInput(inputCode, regex));
  inputCode.addEventListener('focusout', () => validateCode());
}

if (inputName) {
  inputName.addEventListener('focusout', () => validateName());
}

function addNew() {
  window.location.href = `${HOME}add_new`;
}


function edit(id) {
  window.location.href = `${HOME}edit/${id}`;
}


function viewDetail(id) {
  window.location.href = `${HOME}view_detail/${id}`;
}

function changeURL(id, tab, page = 'edit') {
  const url = `${HOME}${page}/${id}/${tab}`;
  const stObj = { stage: 'stage' };
  window.history.pushState(stObj, 'customers', url);
}


async function validateCode() {
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const value = inputCode.value.trim();

  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    validCode = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const result = await validateRemote(url, { code: value });

  if (result === 'exists') {
    setError(inputCode, codeError, 'Code already exists');
    validCode = false;
    return false;
  }

  clearError(inputCode, codeError);
  validCode = true;
  return true;
}


async function validateName() {
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const value = inputName.value.trim();

  if (!value) {
    setError(inputName, nameError, 'Name is required');
    validName = false;
    return false;
  }

  clearError(inputName, nameError);
  validName = true;
  return true;
}


async function genCustomerCode() {
  const prefix = document.getElementById('prefix');
  const errorBox = document.getElementById('prefix-error');
  const code = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const value = prefix.value;

  if (!value) {
    setError(prefix, errorBox, 'Please select prefix !');
    return false;
  }

  clearError(prefix, errorBox);

  const url = `${HOME}gen_new_code`;
  const data = { prefix: value };

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const text = await response.text();

    if (isJson(text)) {
      const ds = JSON.parse(text);

      if (ds.status === 'success') {
        code.value = ds.code;
        validateCode();
        //clearError(code, codeError);
        document.getElementById('name').focus();
      }
      else {
        showError(ds.message);
      }
    }
    else {
      showError(text);
    }
  }
  catch (error) {
    console.log(error);
    showError(error);
  }
}


function clearInputCode() {
  const inputCode = document.getElementById('code');
  const errorBox = document.getElementById('code-error');

  inputCode.value = "";
  clearError(inputCode, errorBox);
  inputCode.focus();
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (!validCode || !validName) {
    click = 0;
    return false;
  }

  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const codeError = document.getElementById('code-error');
  const nameError = document.getElementById('name-error');
  const tax = document.getElementById('tax-id');
  const group = document.getElementById('group');
  const grade = document.getElementById('grade');
  const kind = document.getElementById('kind');
  const type = document.getElementById('type');
  const area = document.getElementById('area');
  const sale = document.getElementById('sale');
  const active = document.querySelector('input[name="active"]:checked').value;

  clearError(inputCode, codeError);
  clearError(inputName, nameError);

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    taxId: tax.value.trim(),
    group: group.value,
    grade: grade.value,
    kind: kind.value,
    type: type.value,
    area: area.value,
    saleId: sale.value,
    active: active
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const text = await response.text();

    setTimeout(() => {
      loadOut();

      if (text.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { addNew() }, 1200);
      }
      else {
        showError(text);
      }
    }, 500);

    click = 0;
  }
  catch (err) {
    click = 0;
    console.log(err);
    showError(err);
  }
}


async function update() {
  if (click != 0) {
    return false;
  }

  click = 1;

  if (!validName) {
    click = 0;
    return false;
  }

  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');

  clearError(inputName, nameError);

  const url = `${HOME}update`;
  const data = {
    id: document.getElementById('id').value,
    name: inputName.value.trim(),
    taxId: document.getElementById('tax-id').value.trim(),
    group: document.getElementById('group').value,
    grade: document.getElementById('grade').value,
    kind: document.getElementById('kind').value,
    type: document.getElementById('type').value,
    area: document.getElementById('area').value,
    saleId: document.getElementById('sale').value,
    active: document.querySelector('input[name="active"]:checked').value
  };

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const text = await response.text();

    if (text.trim() == 'success') {
      swal({
        title: 'Success',
        type: 'success',
        timer: 1000
      });
    }
    else {
      click = 0;
      showError(text);
    }
  }
  catch (err) {
    click = 0;
    showError(err);
  }
}



function getDelete(code, name) {
  swal({
    title: 'Are sure ?',
    text: 'ต้องการลบ ' + name + ' หรือไม่ ?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FA5858',
    confirmButtonText: 'ใช่, ฉันต้องการลบ',
    cancelButtonText: 'ยกเลิก',
    closeOnConfirm: false
  }, function () {
    window.location.href = BASE_URL + 'masters/customers/delete/' + code;
  })
}


function clearAttributeFields() {
  $('#attribute-modal-title').text('');
  $('#attribute-type').val('');
  $('#attribute-code').val('');
  $('#attribute-name').val('');
}


function newGroup() {
  clearAttributeFields();
  $('#attribute-modal-title').text('สร้างกลุ่มลูกค้าใหม่');
  $('#attribute-type').val('group');
  $('#attribute-modal').modal('show');
}


function newGrade() {
  clearAttributeFields();
  $('#attribute-modal-title').text('สร้างเกรดลูกค้าใหม่');
  $('#attribute-type').val('grade');
  $('#attribute-modal').modal('show');
}


function newKind() {
  clearAttributeFields();
  $('#attribute-modal-title').text('สร้างประเภทลูกค้าใหม่');
  $('#attribute-type').val('kind');
  $('#attribute-modal').modal('show');
}


function newType() {
  clearAttributeFields();
  $('#attribute-modal-title').text('สร้างชนิดลูกค้าใหม่');
  $('#attribute-type').val('type');
  $('#attribute-modal').modal('show');
}


function newArea() {
  clearAttributeFields();
  $('#attribute-modal-title').text('สร้างพื้นที่ขายใหม่');
  $('#attribute-type').val('area');
  $('#attribute-modal').modal('show');
}


$('#attribute-modal').on('shown.bs.modal', function () {
  $('#attribute-code').focus();
});


function saveAttribute() {
  const type = $('#attribute-type').val();
  const code = $('#attribute-code').val().trim();
  const name = $('#attribute-name').val().trim();

  if (!code) {
    $('#attribute-code').hasError().focus();
    return false;
  }

  if (!name) {
    $('#attribute-name').hasError().focus();
    return false;
  }

  $.ajax({
    url: BASE_URL + 'masters/customers/add_attribute',
    type: 'POST',
    cache: false,
    data: {
      type: type,
      code: code,
      name: name
    },
    success: function (rs) {
      $('#attribute-modal').modal('hide');
      if (rs === 'success') {
        let option = new Option(`${code} | ${name}`, code, true, true);
        $(`#${type}`).append(option).trigger('change');
      }
      else {
        showError(rs);
      }
    },
    error: function (xhr, status, error) {
      console.log(error);
      showError(error);
    }
  });
}


$('#date').datepicker();


function syncData() {
  load_in();
  $.ajax({
    url: BASE_URL + 'masters/customers/syncData',
    type: 'POST',
    cache: false,
    success: function (rs) {
      load_out();
      setTimeout(function () {
        goBack();
      }, 500);
    }
  });
}



function syncAllData() {
  load_in();
  $.ajax({
    url: BASE_URL + 'masters/customers/syncAllData',
    type: 'POST',
    cache: false,
    success: function (rs) {
      load_out();
      setTimeout(function () {
        goBack();
      }, 500);
    }
  });
}


function doExport() {
  var code = $('#customers_code').val();
  load_in();
  $.ajax({
    url: BASE_URL + 'masters/customers/export_customer/' + code,
    type: 'POST',
    cache: false,
    success: function (rs) {
      load_out();
      if (rs === 'success') {
        swal({
          title: 'Success',
          text: 'ส่งข้อมูลไป SAP เรียบร้อยแล้ว',
          type: 'success',
          timer: 1000
        });
      } else {
        swal({
          title: 'Error!',
          text: rs,
          type: 'error'
        });
      }
    }
  })
}
