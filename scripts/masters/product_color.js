let click = 0;
const inputCode = document.getElementById('code');
const regex = /[^a-zA-Z0-9\/.\-_@]+/gi; // อนุญาตเฉพาะ a-z, A-Z, /, ., -, _, @

if (inputCode) {
  inputCode.addEventListener('input', () => validInput(inputCode, regex));
}


async function validateCode(id = null) {  
  const inputCode = id === null ? document.getElementById('code') : document.getElementById(`code-${id}`);
  const codeError = id === null ? document.getElementById('code-error') : document.getElementById(`error-${id}`);
  const value = inputCode.value.trim();

  if (!value) {
    setError(inputCode, codeError, "Code is Required");    
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const res = await validateRemote(url, { code: value, id: id });

  if (res === 'exists') {
    setError(inputCode, codeError, 'Code already exists');    
    return false;
  }

  clearError(inputCode, codeError);  
  return true;
}


async function validateName(id = null) {  
  const inputName = id === null ? document.getElementById('name') : document.getElementById(`name-${id}`);
  const nameError = id === null ? document.getElementById('name-error') : document.getElementById(`error-${id}`);
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


async function validateColorGroup() {
  const inputGroupName = document.getElementById('group-name');
  const groupNameError = document.getElementById('group-name-error');
  const value = inputGroupName.value.trim();
  if (!value) {
    setError(inputGroupName, groupNameError, "Group name is required");
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_color_group`;
  const res = await validateRemote(url, { name: value });
  if (res === 'exists') {
    setError(inputGroupName, groupNameError, 'Group name already exists');
    return false;
  }
  clearError(inputGroupName, groupNameError);
  return true;
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');  
  const groupId = document.getElementById('color-group-id').value;
  const status = document.getElementById('status');
  const active = status.checked ? 1 : 0;

  if (!await validateCode() || !await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    group_id: groupId,
    active: active
  };
  
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const res = await response.text();

    if (isJson(res)) {
      let ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#new-row-template').html();
        const output = $('#color-table');
        renderPrepend(template, ds.data, output);
        reIndex();
        clearFields();
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
    showError(error.message);
    click = 0;
  }
}


async function edit(id) {
  const url = `${HOME}get_data`;
  const data = { id: id };
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const res = await response.text();

    if (isJson(res)) {
      let ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#edit-row-template').html();
        const output = $(`#row-${id}`);
        renderAfter(template, ds.data, output);
        output.addClass('hide');
        $(`#group-id-${id}`).val(ds.data.group_id).select2();
        setTimeout(() => { $(`#code-${id}`).focus();}, 100);
      }
      else {
        showError(ds.message);
      }
    }
    else {
      showError(res);
    }
  }
  catch (error) {
    showError(error.message);
  }
}


async function update(id) {
  clearErrorByClass('e');
  const codeInput = document.getElementById(`code-${id}`);
  const nameInput = document.getElementById(`name-${id}`);  
  const groupIdInput = document.getElementById(`group-id-${id}`);  
  const statusInput = document.getElementById(`active-${id}`);
  const active = statusInput.checked ? 1 : 0;
    
  if (!await validateCode(id) || !await validateName(id)) {
    click = 0;
    return false;
  }
  
  const url = `${HOME}update`;
  const data = {
    id: id,
    code: codeInput.value.trim(),
    name: nameInput.value.trim(),
    group_id: groupIdInput.value,
    active: active
  };  

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const res = await response.text();

    if(isJson(res)) {
      let ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#row-template').html();
        const output = $(`#row-${id}`);
        render(template, ds.data, output);
        $(`#row-${id}`).removeClass('hide');
        $(`#edit-row-${id}`).remove();
        reIndex();        
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


function cancel(id) {
  $(`#edit-row-${id}`).remove();
  $(`#row-${id}`).removeClass('hide');
}


function openColorGroupModal() {
  $('#group-name').val('').removeClass('has-error');
  $('#group-name-error').text('');
  $('#color-group-modal').modal('show');
}

$('#color-group-modal').on('shown.bs.modal', function () {
  $('#group-name').focus();
});


async function addColorGroup() {
  const inputGroupName = document.getElementById('group-name');  
    
  if(!await validateColorGroup()) {
    return false;
  }

  const url = `${HOME}add_color_group`;
  const data = { name: inputGroupName.value.trim() };  

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const res = await response.text();

    if(isJson(res)) {
      let ds = JSON.parse(res);

      if (ds.status === 'success') {
        $('#color-group-modal').modal('hide');
        $('#color-group-id').append(new Option(ds.group.name, ds.group.id, true, true)).trigger('change');
      }
      else {
        showError(ds.message);
      }
    }
    else {
      showError(res);
    }
  }
  catch (error) {
    showError(error);
  }
}


function confirmDelete(id, name) {
  swal({
    title: `Are you sure ?`,
    text: `Do you want to delete ${name} ?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    closeOnConfirm: true
  },
  function(isConfirm) {
    if (isConfirm) {
      deleteColor(id);
    }
  });
}


async function deleteColor(id) {
  const url = `${HOME}delete`;
  const data = { id: id }; 
  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const res = await response.text();

    setTimeout(() => {
      loadOut();
      if (res.trim() === 'success') {
        swal({
          title: 'Success',
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


function clearFields() {
  $('#name').val('');
  $('#color-group-id').val('').trigger('change');
  $('#status').prop('checked', true);
  $('#code').val('').focus();
}