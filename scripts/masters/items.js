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

if (inputName) {
  inputName.addEventListener("blur", () => validateName());
}

if (inputBarcode) {
  inputBarcode.addEventListener("blur", () => validateBarcode());
}

if (inputCost) {
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

if (inputPrice) {
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


async function duplicate(id) {
  const url = `${HOME}get_item_data/${id}`;

  loadIn();

  try {
    const response = await fetch(url);
    const res = await response.json();

    if (res.status === 'success') {
      const item = res.item;
      $('#code').val(item.code);
      $('#name').val(item.name);
      $('#style').val(item.style_code);
      $('#barcode').val(item.barcode);
      $('#cost').val(addCommas(item.cost));
      $('#price').val(addCommas(item.price));
      $('#unit-group').val(item.unit_group_id).trigger('change');
      setTimeout(() => {
        $('#unit').val(item.unit_id).trigger('change');
      }, 500);
      $('#purchase-vat-group').val(item.purchase_vat_code).trigger('change');
      $('#sale-vat-group').val(item.sale_vat_code).trigger('change');
      $('#count-stock').prop('checked', item.count_stock);
      $('#can-sell').prop('checked', item.can_sell);
      $(`input[name="active"][value="${item.active}"]`).prop('checked', true);
      $('#color').val(item.color_id ? item.color_id : '').trigger('change');
      $('#size').val(item.size_id ? item.size_id : '').trigger('change');
      $('#main-group').val(item.main_group_id ? item.main_group_id : '').trigger('change');
      $('#group').val(item.group_id ? item.group_id : '').trigger('change');
      $('#gender').val(item.gender_id ? item.gender_id : '').trigger('change');
      $('#category').val(item.category_id ? item.category_id : '').trigger('change');
      $('#kind').val(item.kind_id ? item.kind_id : '').trigger('change');
      $('#type').val(item.type_id ? item.type_id : '').trigger('change');
      $('#brand').val(item.brand_id ? item.brand_id : '').trigger('change');
      $('#year').val(item.year ? item.year : '').trigger('change');

      $('#duplicate-modal').modal('show');
    }
    else {
      showError(res.message);
    }
  } 
  catch (error) {
    showError('An error occurred while fetching item data');
  } 
  finally {
    loadOut();
  }
}


const viewDetail = (id) => {
  const url = `${HOME}view_detail/${id}?nomenu`;
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
  if(id === null) {
    id = document.getElementById('item-id') ? document.getElementById('item-id').value : null;
  }

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
    if(id === null) {
    id = document.getElementById('item-id') ? document.getElementById('item-id').value : null;
  }

  const inputBarcode = document.getElementById('barcode');
  const barcodeError = document.getElementById('barcode-error');
  const value = inputBarcode.value.trim();

  if (value) {
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

  const puVat = document.getElementById('purchase-vat-group');
  const saVat = document.getElementById('sale-vat-group');

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

    if (res.trim() === 'success') {
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
      showError(res);
    }

    click = 0;
  }
  catch (error) {
    showError(error);
    click = 0;
  }
}



async function update() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const id = document.getElementById('item-id').value;

  if (! await validateName(id)) {
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

  const puVat = document.getElementById('purchase-vat-group');
  const saVat = document.getElementById('sale-vat-group');

  const data = {
    id: id,
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
    const url = `${HOME}update`;
    const response = await postData(url, data);
    const res = await response.text();

    setTimeout(() => {
      loadOut();

      if (res.trim() === 'success') {
        swal({
          title: 'Success',
          text: 'Item has been updated successfully',
          type: 'success',
          timer: 1000
        });
      }
      else {
        showError(res);
      }
    }, 500);

    click = 0;
  }
  catch (error) {
    showError(error);
    click = 0;
  }
}


async function addDuplicate() {
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

  const puVat = document.getElementById('purchase-vat-group');
  const saVat = document.getElementById('sale-vat-group');

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

    $('#duplicate-modal').modal('hide');

    setTimeout(() => {
      loadOut();

      if (res.trim() === 'success') {
        swal({
          title: 'Success',
          text: 'Item has been added successfully',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => {
          window.location.href = `${HOME}`;
        }, 1200);
      }
      else {
        showError(res);
      }
    }, 500);    

    click = 0;
  }
  catch (error) {
    showError(error);
    click = 0;
  }
}


function confirmDelete(id, name) {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to delete item <b>${name}</b> ?`,
    type: 'warning',
    html: true,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No',
    closeOnConfirm: true
  }, function (isConfirm) {
    if (isConfirm) {
      deleteItem(id);
    }
  });
}


async function deleteItem(id) {
  loadIn();

  try {
    const url = `${HOME}delete`;
    const response = await postData(url, { id: id });
    const res = await response.text();

    setTimeout(() => {
      loadOut();

      if (res.trim() === 'success') {
        swal({
          title: 'Deleted',
          text: 'Item has been deleted successfully',
          type: 'success',
          timer: 1000
        });

        $(`#row-${id}`).remove();
        reIndex();
      }
      else {
        showError(res);
      }
    }, 500);
  }
  catch (error) {
    showError(error);
  }
}


$('#style').autocomplete({
  source: `${BASE_URL}auto_complete/get_style_code_and_name`,
  autoFocus: true,
  close: function () {
    const arr = $(this).val().trim().split(' | ');

    if (arr.length === 2) {
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

  if (res.status === 'success') {
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
