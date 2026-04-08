let click = 0;
let validCode = false;
let validName = false;

const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');

if (inputCode) {  
  inputCode.addEventListener('focusout', () => validateCode());
}

if (inputName) {
  inputName.addEventListener('focusout', () => validateName());
}

const addNew = () => {
  window.location.href = `${HOME}add_new`;
}

const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}

const viewDetail = (id) => {
  window.location.href = `${HOME}view_detail/${id}`;
}

async function validateCode() {
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const id = document.getElementById('id') ? document.getElementById('id').value : null;
  const value = inputCode.value.trim(); 
  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    validCode = false;
    return false;
  }
  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const result = await validateRemote(url, {id:id, code: value });
  if (result.exists) {
    setError(inputCode, codeError, "Code already exists");
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
    setError(inputName, nameError, "Name is Required");
    validName = false;
    return false;
  }
  clearError(inputName, nameError);
  validName = true;
  return true;
}

async function validateBaseUnit() {
  const baseUnit = document.getElementById('unit');
  const unitError = document.getElementById('unit-error');
  if (baseUnit.value === '') {
    setError(baseUnit, unitError, "Base Unit is Required");
    return false;
  }
  clearError(baseUnit, unitError);
  return true;
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;  

  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const codeError = document.getElementById('code-error');
  const nameError = document.getElementById('name-error');
  const baseUnit = document.getElementById('unit');
  const unitError = document.getElementById('unit-error'); 
  clearError(inputCode, codeError);
  clearError(inputName, nameError);
  clearError(baseUnit, unitError);

  if( ! await validateCode() || ! await validateName() || ! await validateBaseUnit()) {
    click = 0;
    return false;
  } 
   
  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    baseUnit: baseUnit.value
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method:'POST',
      headers:{'Content-Type': 'application/json'},
      body:JSON.stringify(data)
    });

    const result = await response.text();

    setTimeout(() => {
      loadOut();

      if (result === 'success') {
        swal({
          title: 'Success',
          type:'success',
          timer: 1000
        });

        setTimeout(() => { addNew(); }, 1200);
      }
      else {
        showError(result)
      }

      click = 0;
    }, 500);
  }
  catch (error) {
    click = 0;
    showError(error.message);
  }
}



async function update() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const id = document.getElementById('id').value;
  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const codeError = document.getElementById('code-error');
  const nameError = document.getElementById('name-error');
  const baseUnit = document.getElementById('unit');
  const unitError = document.getElementById('unit-error');
  clearError(inputCode, codeError);
  clearError(inputName, nameError);
  clearError(baseUnit, unitError);

  if (! await validateCode() || ! await validateName() || ! await validateBaseUnit()) {
    click = 0;
    return false;
  } 

  const url = `${HOME}update`;
  const data = {
    id: id,
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    baseUnit: baseUnit.value
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method:'POST',
      headers:{'Content-Type': 'application/json'},
      body:JSON.stringify(data)
    });

    const result = await response.text();

    setTimeout(() => {
      loadOut();

      if (result === 'success') {
        swal({
          title: 'Success',
          type:'success',
          timer: 1000
        }); 

        setTimeout(() => { edit(id); }, 1200);       
      }
      else {
        showError(result)
      }

      click = 0;
    }, 500);
  }
  catch (error) {
    click = 0;
    showError(error.message);
  }
}


async function addUnit() {
  let id = $('#id').val();
  let altQty = parseDefaultFloat($('#new-alt-qty').val(), 0);
  let altUnit = $('#new-alt-unit').val();
  let baseQty = parseDefaultFloat($('#new-base-qty').val(), 0);
  let baseUnit = $('#new-base-unit').val();

  if(altQty == 0) {
    $('#new-alt-qty').hasError();
    return false;
  }

  if(altUnit == '') {
    $('#new-alt-unit').hasError();
    return false;
  }

  if(baseQty == 0) {
    $('#new-base-qty').hasError();
    return false;
  }

  if(baseUnit == '') {
    $('#new-base-unit').hasError();
    return false;
  }

  let data = {
    id: id,
    altQty: altQty,
    altUnit: altUnit,
    baseQty: baseQty,
    baseUnit: baseUnit
  };

  $.ajax({
    url: `${HOME}add_detail`,
    type:'POST',
    cache:false,
    data: {
      data: JSON.stringify(data)
    },
    success: function(rs) { 
      if(isJson(rs)) {
        let ds = JSON.parse(rs);

        if(ds.status === 'success') {
          let source = $('#unit-template').html();
          let output = $('#unit-table');

          renderAppend(source, ds.data, output);
          
          $('#new-alt-unit').val('').change();
          $('#new-base-qty').val('');

          reIndex();  
        }
        else {
          showError(ds.message);
        }
      }
      else {
        showError(rs);
      }
    },
    error:function(rs) {
      showError(rs);
    }
  });
}


function removeUnit(id) {
  swal({
    title: 'Are you sure?',
    text: 'This unit will be removed from the group',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, remove it!',
    cancelButtonText: 'No, cancel it!',
    closeOnConfirm: true
  }, function(isConfirm) {
    if (isConfirm) {
      loadIn();

      $.ajax({
        url: `${HOME}delete_detail`,
        type: 'POST',
        cache: false,
        data: {
          id: id
        },
        success: function(rs) {
          setTimeout(() => {
            loadOut();
            if (rs.trim() === 'success') {
              $(`#unit-row-${id}`).remove();
              reIndex();
            }
            else {
              showError(rs);
            }
          }, 500);
        },
        error: function(rs) {          
          showError(rs);
        }
      });      
    }
  });
}


function confirmDelete(id, code, name) {
  swal({
    title: 'ARE YOU SURE ?',
    text: `Do you want to delete ${code} : ${name} ?`,
    type: 'warning',
    showCancelButton: true, 
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, I am sure!',
    cancelButtonText: 'No, cancel it!',
    closeOnConfirm: true
  }, function(isConfirm) {
    if (isConfirm) {
      loadIn();
      deleteUnit(id);
    }
  });
}


async function deleteUnit(id) {
  const url = `${HOME}delete`;
  const data = { id };
  
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await response.text();

    setTimeout(() => {
      loadOut();

      if (result === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        $(`#row-${id}`).remove();

        reIndex();
      }
      else {
        showError(result);
      }
    }, 500);
  }
  catch (error) {
    showError(error.message);
  }
}


$('#new-alt-unit').change(function() {
  $('#new-base-qty').focus();
});


$('#new-base-qty').keyup(function(e) {
  if (e.key === 'Enter' || e.keyCode === 13) {
    addUnit();
  }
});
