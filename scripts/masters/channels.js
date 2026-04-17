let click = 0;
const regex = /[^a-zA-Z0-9\-_.@]/g;
const inputCode = document.getElementById('code');

if (inputCode) {
  inputCode.addEventListener('input', () => validInput(inputCode, regex));
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
  $('#code').val('').clearError();
  $('#name').val('').clearError();  
  $('#status').prop('checked', true);
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');  
  const inputStatus = document.getElementById('status');
  const active = inputStatus.checked ? 1 : 0;  

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),    
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
      const ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#new-row-template').html();
        const output = $('#data-table');
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
  catch (err) {
    click = 0;
    showError(err.message);
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
        $('#status-' + id).prop('checked', ds.data.active == 1);
      }
      else {
        showError(ds.message);
      }
    }
    else {
      showError(res);
    }
  }
  catch (err) {
    showError(err.message);
  }
}


function cancel(id) {
  $(`#edit-row-${id}`).remove();
  $(`#row-${id}`).removeClass('hide');
}


async function update(id) {
  if (! await validateName(id)) {
    return false;
  }

  const inputName = document.getElementById(`name-${id}`);  
  const inputStatus = document.getElementById(`status-${id}`);
  const active = inputStatus.checked ? 1 : 0;
  
  const url = `${HOME}update`;
  const data = {
    id: id,
    name: inputName.value.trim(),    
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
  catch (err) {
    showError(err.message);
  }
}


function confirmDelete(id, name) {
  swal({
    title: "Are you sure?",
    text: `Do you want to delete ${name} ?`,
    type: "warning",
    html: true,
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    closeOnConfirm: true
  }, function (isConfirm) {
    if (isConfirm) {
      deleteItem(id);
    }
  });
}


async function deleteItem(id) {
  const url = `${HOME}delete`;
  const data = { id: id };

  loadIn();

  try {
    const response = await postData(url, data);
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
        showError(res);
      }
    }, 500);
  }
  catch (err) {
    showError(err.message);
  }
}
