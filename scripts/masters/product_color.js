let click = 0;
let validCode = false;
let validName = false;
const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');

if (inputCode) {
  inputCode.addEventListener('blur', validateCode);
}

if (inputName) {
  inputName.addEventListener('blur', validateName);
}


const addNew = () => {
  window.location.href = `${HOME}add_new`;
}

const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}


async function validateCode() {
  const id = document.getElementById('id') ? document.getElementById('id').value : null;
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
  const res = await validateRemote(url, { code: value, id: id });

  if (res === 'exists') {
    setError(inputCode, codeError, 'Code already exists');
    validCode = false;
    return false;
  }

  clearError(inputCode, codeError);
  validCode = true;
  return true;
}


async function validateName() {
  const id = document.getElementById('id') ? document.getElementById('id').value : null;
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const value = inputName.value.trim();

  if (!value) {
    setError(inputName, nameError, "Name is Required");
    validName = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: value, id: id });

  if (res === 'exists') {
    setError(inputName, nameError, 'Name already exists');
    validName = false;
    return false;
  }

  clearError(inputName, nameError);
  validName = true;
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
  const codeError = document.getElementById('code-error');
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const groupId = document.getElementById('group-id').value;
  const active = document.querySelector('input[name="active"]:checked').value;

  clearError(inputCode, codeError);
  clearError(inputName, nameError);

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
      if (res === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { addNew() }, 1200);
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


async function update() {
  if (click !== 0) {
    return false;
  }
  click = 1;
  const id = document.getElementById('id').value;
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const groupId = document.getElementById('group-id').value;
  const active = document.querySelector('input[name="active"]:checked').value;
  clearError(inputCode, codeError);
  clearError(inputName, nameError);
  if (!await validateCode() || !await validateName()) {
    click = 0;
    return false;
  }
  const url = `${HOME}update`;
  const data = {
    id: id,
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    group_id: groupId,
    active: active
  };

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
      if (res === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });
        setTimeout(() => { edit(id) }, 1200);
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
  const groupNameError = document.getElementById('group-name-error');
  const value = inputGroupName.value.trim();
  if (!value) {
    setError(inputGroupName, groupNameError, "Group name is required");
    return false;
  }

  clearError(inputGroupName, groupNameError);

  if(!await validateColorGroup()) {
    return false;
  }

  const url = `${HOME}add_color_group`;
  const data = { name: value };
  
  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const res = await response.json();

    setTimeout(() => {
      loadOut();
      if (res.status === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        $('#color-group-modal').modal('hide');
        // Optionally, refresh the color group dropdown or perform other actions
        $('#group-id').append(new Option(res.group.name, res.group.id, true, true)).trigger('change');
      }
      else {
        showError(res.message);
      }
    }, 500);
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
