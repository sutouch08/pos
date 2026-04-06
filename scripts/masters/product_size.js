let click = 0;
let validCode = false;
let validName = false;

const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');
const inputGroupName = document.getElementById('group-name');

if (inputCode) {
  inputCode.addEventListener('blur', validateCode);
}


if (inputName) {
  inputName.addEventListener('blur', validateName);
}

if (inputGroupName) {
  inputGroupName.addEventListener('blur', validateGroupName);
}


const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}


async function validateCode() {
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const value = inputCode.value.trim();
  const id = document.getElementById('id') ? document.getElementById('id').value : null;

  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    validCode = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const result = await validateRemote(url, { code: value, id: id });

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
  const id = document.getElementById('id') ? document.getElementById('id').value : null;

  if (!value) {
    setError(inputName, nameError, "Name is Required");
    validName = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_name`;
  const result = await validateRemote(url, { name: value, id: id });

  if (result === 'exists') {
    setError(inputName, nameError, 'Name already exists');
    validName = false;
    return false;
  }

  clearError(inputName, nameError);
  validName = true;
  return true;
}


async function validateGroupName() {
  const groupNameInput = document.getElementById('group-name');
  const groupNameError = document.getElementById('group-name-error');
  const value = groupNameInput.value.trim();
  if (!value) {
    setError(groupNameInput, groupNameError, "Group Name is Required");
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_group_name`;
  const result = await validateRemote(url, { name: value });
  if (result === 'exists') {
    setError(groupNameInput, groupNameError, 'Group Name already exists');
    return false;
  }

  clearError(groupNameInput, groupNameError);
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
  const position = parseDefaultInt(document.getElementById('position').value.trim(), 0);
  const active = document.querySelector('input[name="active"]:checked').value;
  const groupId = document.getElementById('group-id').value;
  clearError(inputCode, codeError);
  clearError(inputName, nameError);

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    position: position,
    active: active,
    group_id: groupId
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
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
        showError(res)
      }
    }, 500);

    click = 0;
  }
  catch (error) {
    click = 0;
    showError(error);
  }
}


async function update() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const position = parseDefaultInt(document.getElementById('position').value.trim(), 0);
  const active = document.querySelector('input[name="active"]:checked').value;
  const groupId = document.getElementById('group-id').value;
  clearError(inputCode, codeError);
  clearError(inputName, nameError);

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}update`;
  const id = document.getElementById('id').value;
  const data = {
    id: id,
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    position: position,
    active: active,
    group_id: groupId
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
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
        showError(res)
      }
    }, 500);

    click = 0;
  }
  catch (error) {
    click = 0;
    showError(error);
  }
}


function openSizeGroupModal() {
  $('#group-name').val('');
  $('#group-name-error').text('');
  $('#size-group-modal').modal('show');
  $('#size-group-modal').on('shown.bs.modal', function () {
    $('#group-name').focus();
  });
}

async function addSizeGroup() {
  const groupNameInput = document.getElementById('group-name');
  const groupNameError = document.getElementById('group-name-error');
  clearError(groupNameInput, groupNameError);

  if (! await validateGroupName()) {
    return false;
  }

  const url = `${HOME}add_size_group`;
  const data = {
    name: groupNameInput.value.trim()
  };

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });

    const res = await response.json();

    setTimeout(() => {
      if (res.status === 'success') {
        const newOption = new Option(res.group.name, res.group.id, true, true);
        $('#group-id').append(newOption).trigger('change');
        $('#size-group-modal').modal('hide');
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
    confirmButtonText: 'Yes',
    cancelButtonText: 'No',
    closeOnConfirm: true
  }, function () {
    deleteSize(id);
  });
}
   
async function deleteSize(id) {
  const url = `${HOME}delete`;
  const data = { id: id };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });

    const res = await response.text();
    setTimeout(() => {
      loadOut();
      if (res === 'success') {
        swal({
          title: 'Deleted',
          type: 'success',
          timer: 1000
        });

        $(`#row-${id}`).remove();
        reIndex();
      }
      else {
        showError(res)
      }
    }, 500);
  }
  catch (error) {
    showError(error);
  }
}