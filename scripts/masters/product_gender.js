let click = 0;

const inputCode = document.getElementById("code");
const regex = /[^a-zA-Z0-9-_.@\/]+/gi;

if (inputCode) {
  inputCode.addEventListener("input", () => validInput(inputCode, regex));
}

async function validateCode(id = null) {
  const inputCode = id === null ? document.getElementById("code") : document.getElementById(`code-${id}`);
  const codeError = id === null ? document.getElementById("code-error") : document.getElementById(`error-${id}`);
  const value = inputCode.value.trim();
  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const res = await validateRemote(url, { code: value, id: id });

  if (res === "exists") {
    setError(inputCode, codeError, "Code already exists");
    return false;
  }

  clearError(inputCode, codeError);
  return true;
}


async function validateName(id = null) {
  const inputName = id === null ? document.getElementById("name") : document.getElementById(`name-${id}`);
  const nameError = id === null ? document.getElementById("name-error") : document.getElementById(`error-${id}`);
  const value = inputName.value.trim();
  if (!value) {
    setError(inputName, nameError, "Name is Required");
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: value, id: id });

  if (res === "exists") {
    setError(inputName, nameError, "Name already exists");
    return false;
  }
  clearError(inputName, nameError);
  return true;
}


function clearFields() {
  $('#name').val('');
  $('#status').prop('checked', true);
  $('#code').val('').focus();
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const inputCode = document.getElementById("code");
  const inputName = document.getElementById("name");
  const status = document.getElementById("status");
  const active = status.checked ? 1 : 0;

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    active: active
  };

  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (isJson(res)) {
      const ds = JSON.parse(res);

      if (ds.status === 'success') {
        const template = $('#new-row-template').html();
        const output = $('#brand-table');

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
    click = 0;
    showError(error.message);
  }
}


async function edit(id) {
  const url = `${HOME}get_data`;
  const data = { id: id };
  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (isJson(res)) {
      const ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#edit-row-template').html();
        const output = $(`#row-${id}`);

        renderAfter(template, ds.data, output);

        $(`#row-${id}`).addClass('hide');
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
  const inputCode = document.getElementById(`code-${id}`);
  const inputName = document.getElementById(`name-${id}`);
  const status = document.getElementById(`status-${id}`);
  const active = status.checked ? 1 : 0;

  if (! await validateCode(id) || ! await validateName(id)) {
    return false;
  }

  const url = `${HOME}update`;
  const data = {
    id: id,
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    active: active
  };

  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (isJson(res)) {
      const ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#row-template').html();
        const output = $(`#row-${id}`);
        render(template, ds.data, output);
        $(`#edit-row-${id}`).remove();
        $(`#row-${id}`).removeClass('hide');
        reIndex();
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


function cancel(id) {
  $(`#edit-row-${id}`).remove();
  $(`#row-${id}`).removeClass('hide');
}


function confirmDelete(id, name) {
  swal({
    title: `Are you sure ?`,
    text: `Do you want to delete "${name}" ?`,
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true
  },
    function (isConfirm) {
      if (isConfirm) {
        deleteItem(id);
      }
    });
}


async function deleteItem(id) {
  const url = `${HOME}delete`;
  const data = { id: id };
  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (res === 'success') {
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
  }
  catch (error) {
    showError(error.message);
  }
}