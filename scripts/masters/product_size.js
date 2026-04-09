let click = 0;

const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');
const inputGroupName = document.getElementById('group-name');
const regex = /[^a-zA-Z0-9\/.\-_@]+/gi; // อนุญาตเฉพาะ a-z, A-Z, /, ., -, _, @

if (inputCode) {
  inputCode.addEventListener('input', () => validInput(inputCode, regex));
}


async function validateCode() {
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const value = inputCode.value.trim();
  const id = null;

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
  const id = null;

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
  const active = document.getElementById('status').checked ? 1 : 0;
  const groupId = document.getElementById('size-group-id').value;
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
      if (isJson(res)) {
        const ds = JSON.parse(res);
        if (ds.status === 'success') {
          swal({
            title: 'Success',
            type: 'success',
            timer: 1000
          });

          const template = $('#new-row-template').html();
          const output = $('#size-table');
          renderPrepend(template, ds.data, output);
          reIndex();
          clearInput();
        }
        else {
          showError(ds.message)
        }
      }
      else {
        showError(res);
      }
    }, 300);

    click = 0;
  }
  catch (error) {
    click = 0;
    showError(error);
  }
}


function clearInput() {
  document.getElementById('code').value = '';
  document.getElementById('name').value = '';
  document.getElementById('position').value = '';
  document.getElementById('status').checked = true;
  $('#size-group-id').val('').trigger('change');
  document.getElementById('code').focus();
}


function openSizeGroupModal() {
  $('#group-name').val('').clearError();
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
        $('#size-group-id').append(newOption).trigger('change');
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


async function edit(id) {
  const url = `${HOME}get_edit_data`;
  const data = { id: id };
  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  });

  const res = await response.json();

  let source = $('#inline-edit-template').html();
  let output = $(`#row-${id}`);

  renderAfter(source, res, output);
  output.addClass('hide');

  $(`#group-id-${id}`).val(res.group_id).trigger('change');
}


async function update(id) {
  clearErrorByClass('e');
  const codeInput = document.getElementById(`code-${id}`);
  const nameInput = document.getElementById(`name-${id}`);
  const groupIdInput = document.getElementById(`group-id-${id}`);
  const positionInput = document.getElementById(`position-${id}`);
  const statusInput = document.getElementById(`active-${id}`);
  const active = statusInput.checked ? 1 : 0;

  if (! await validateInlineCode(id) || ! await validateInlineName(id)) {
    return false;
  }

  const url = `${HOME}update`;
  const data = {
    id: id,
    code: codeInput.value.trim(),
    name: nameInput.value.trim(),
    group_id: groupIdInput.value,
    position: parseDefaultInt(positionInput.value.trim(), 0),
    active: active
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

    if (res.status === 'success') {
      let source = $(`#row-template`).html();
      let output = $(`#row-${id}`);
      render(source, res.data, output);

      $(`#row-${id}`).removeClass('hide');
      $(`#edit-row-${id}`).remove();
      reIndex();
    }
    else {
      showError(res.message);
    }
  }
  catch (error) {
    showError(error);
  }

}


async function validateInlineCode(id) {
  const codeInput = document.getElementById(`code-${id}`);
  const errorLabel = document.getElementById(`error-${id}`);
  const code = codeInput.value.trim();
  if (!code) {
    codeInput.classList.add('has-error');
    errorLabel.textContent = 'Code is required';
    return false;
  }

  const url = `${HOME}is_exists_code`;
  const result = await validateRemote(url, { code: code, id: id });

  if (result === 'exists') {
    codeInput.classList.add('has-error');
    errorLabel.textContent = 'Code already exists';
    return false;
  }
  codeInput.classList.remove('has-error');
  errorLabel.textContent = '';
  return true;
}


async function validateInlineName(id) {
  const nameInput = document.getElementById(`name-${id}`);
  const errorLabel = document.getElementById(`error-${id}`);
  const name = nameInput.value.trim();
  if (!name) {
    nameInput.classList.add('has-error');
    errorLabel.textContent = 'Name is required';
    return false;
  }

  const url = `${HOME}is_exists_name`;
  const result = await validateRemote(url, { name: name, id: id });
  if (result === 'exists') {
    nameInput.classList.add('has-error');
    errorLabel.textContent = 'Name already exists';
    return false;
  }
  nameInput.classList.remove('has-error');
  errorLabel.textContent = '';
  return true;
}

