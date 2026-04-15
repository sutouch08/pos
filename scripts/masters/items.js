let click = 0;

const inputCode = document.getElementById("code");
const inputName = document.getElementById("name");
const inputBarcode = document.getElementById("barcode");
const inputCost = document.getElementById("cost");
const inputPrice = document.getElementById("price");
const regex = /[^a-zA-Z0-9-_.@\/]+/gi;

if (inputCode) {
  inputCode.addEventListener("input", () => validInput(inputCode, regex));
  inputCode.addEventListener("blur", () => validateCode());
}

if(inputName) {  
  inputName.addEventListener("blur", () => validateName());
}

if(inputBarcode) {
  inputBarcode.addEventListener("blur", () => validateBarcode());
}

if(inputCost) {
  inputCost.addEventListener("blur", () => {
    value = parseDefaultFloat(removeCommas(inputCost.value.trim()), 0);
    inputCost.value = addCommas(value);
  });

  inputCost.addEventListener("focus", () => {
    const value = inputCost.value;
    inputCost.value = "";
    setTimeout(() => inputCost.value = value, 10);    
  });
}

if(inputPrice) {
  inputPrice.addEventListener("blur", () => {
    value = parseDefaultFloat(removeCommas(inputPrice.value.trim()), 0);
    inputPrice.value = addCommas(value);
  });

  inputPrice.addEventListener("focus", () => {
    const value = inputPrice.value;
    inputPrice.value = "";
    setTimeout(() => inputPrice.value = value, 10);    
  });
}


const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}


const viewDetail = (id) => {
  const url = `${HOME}view_detail/${id}`;
  const width = 800;
  const height = 900;
  const left = (window.screen.width / 2) - (width / 2);
  const top = 30;
  window.open(url, '_blank', `width=${width},height=${height},left=${left},top=${top}`);
}


async function validateCode() {
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const value = inputCode.value.trim();

  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    return false;
  }

  //--- check duplicated  
  const url = `${HOME}is_exists_code`;
  const res = await validateRemote(url, { code: value });

  if (res === 'exists') {
    setError(inputCode, codeError, 'Code already exists');
    return false;
  }

  clearError(inputCode, codeError);
  return true;
}


async function validateName(id = null) {
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const value = inputName.value.trim();

  if (!value) {
    setError(inputName, nameError, "Name is Required");
    return false;
  }

  //--- check duplicated  
  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: value, id: id });

  if (res === 'exists') {
    setError(inputName, nameError, 'Name already exists');
    return false;
  }

  clearError(inputName, nameError);
  return true;
}


async function validateBarcode(id = null) {
  const inputBarcode = document.getElementById('barcode');
  const barcodeError = document.getElementById('barcode-error');
  const value = inputBarcode.value.trim();

  if(value) {
    //--- check duplicated
    const url = `${HOME}is_exists_barcode`;
    const res = await validateRemote(url, { barcode: value, id: id });

    if (res === 'exists') {
      setError(inputBarcode, barcodeError, 'Barcode already exists');
      return false;
    }

    clearError(inputBarcode, barcodeError);
    return true;
  }

  clearError(inputBarcode, barcodeError);
  return true;
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (!await validateCode()) {
    click = 0;
    return false;
  }

  if (!await validateName()) {
    click = 0;
    return false;
  }

  const selectUnit = document.getElementById('unit');
  const unitError = document.getElementById('unit-error');
  clearError(selectUnit, unitError);

  if (!selectUnit.value) {
    setError(selectUnit, unitError, 'Unit is Required');
    click = 0;
    return false;
  }

  const puVat = document.getElementById('purchase-vat-code');
  const saVat = document.getElementById('sale-vat-code');

  const data = {
    code: document.getElementById('code').value.trim(),
    name: document.getElementById('name').value.trim(),
    style: document.getElementById('style').value.trim(),    
    barcode: document.getElementById('barcode').value.trim(),
    cost: parseDefaultFloat(removeCommas(document.getElementById('cost').value.trim()), 0),
    price: parseDefaultFloat(removeCommas(document.getElementById('price').value.trim()), 0),
    unit_group: document.getElementById('unit-group').value.trim(),
    unit: document.getElementById('unit').value.trim(),
    purchase_vat_code: puVat.value.trim(),
    purchase_vat_rate: parseDefaultFloat(puVat.options[puVat.selectedIndex].getAttribute('data-rate'), 0),
    sale_vat_code: saVat.value.trim(),
    sale_vat_rate: parseDefaultFloat(saVat.options[saVat.selectedIndex].getAttribute('data-rate'), 0),
    count_stock: document.getElementById('count-stock').checked ? 1 : 0,
    can_sell: document.getElementById('can-sell').checked ? 1 : 0,
    active: document.querySelector('input[name="active"]:checked').value,
    color: document.getElementById('color').value.trim(),
    size: document.getElementById('size').value.trim(),
    main_group: document.getElementById('main-group').value.trim(),
    group: document.getElementById('group').value.trim(),
    gender: document.getElementById('gender').value.trim(),
    category: document.getElementById('category').value.trim(),
    kind: document.getElementById('kind').value.trim(),
    type: document.getElementById('type').value.trim(),
    brand: document.getElementById('brand').value.trim(),
    year: document.getElementById('year').value.trim()
  };

  loadIn();

  try {
    const url = `${HOME}add`;
    const response = await postData(url, data);
    const res = await response.text();

    loadOut();

    if(isJson(res)) {
      const ds = JSON.parse(res);

      if(ds.status === 'success') {
        swal({
          title: 'Success',
          text: 'Item has been added successfully<br/>Do you want to add new item ?',
          type: 'success',
          html: true,
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }, function (isConfirm) {
          if (isConfirm) {
            window.location.href = `${HOME}add_new`;
          }
          else {
            window.location.href = `${HOME}`;
          }
        });
      }
      else {
        showError(ds.message);
      }
    }
    else {
      showError(res);
    }

    click = 0;
  }
  catch (error) {    
    showError(error);
    click = 0;
  } 
}


$('#style').autocomplete({
  source: `${BASE_URL}auto_complete/get_style_code_and_name`,
  autoFocus: true,
  close: function () {
    const arr = $(this).val().trim().split(' | ');

    if(arr.length === 2) {
      const code = arr[0];
      $(this).val(code);
    }
    else {
      $(this).val('');
    }   
  }
});


async function genUnitSelection() {
  const groupId = $('#unit-group').val();
  const unitId = $('#unit').val();
  
  if (!groupId) {
    $('#unit').select2('destroy');
    $('#unit').html('<option value="">เลือก</option>');
    $('#unit').select2();
    return false;
  }

  const url = `${HOME}get_units_by_group`;
  const data = { group_id: groupId, unit_id: unitId };
  const response = await postData(url, data);
  const res = await response.json();

  if(res.status === 'success') {
    $('#unit').select2('destroy');
    $('#unit').html(res.options);
    $('#unit').select2();    
  }
  else {
    $('#unit').select2('destroy');
    $('#unit').html('<option value="">เลือก</option>');
    $('#unit').select2();
  }
}
    