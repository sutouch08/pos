let click = 0;

async function validateName(id = null) {
  const nameInput = id === null ? document.getElementById("name") : document.getElementById(`name-${id}`);
  const nameError = id === null ? document.getElementById("name-error") : document.getElementById(`error-${id}`);
  const value = nameInput.value.trim();
  if (!value) {
    setError(nameInput, nameError, "Name is Required");
    return false;
  }

  // Check for duplicate name
  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: value, id: id });
  if (res === "exists") {
    setError(nameInput, nameError, "Name already exists");
    return false;
  }
  clearError(nameInput, nameError);
  return true;
}


function clearFields() {
  $('#status').prop('checked', true);
  $('#name').val('').focus();
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    name: $('#name').val().trim(),
    active: $('#status').is(':checked') ? 1 : 0
  };

  try {
    const response = await postData(url, data);
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
  if (! await validateName(id)) {
    return false;
  }

  const url = `${HOME}update`;
  const data = {
    id: id,
    name: $(`#name-${id}`).val().trim(),
    active: $(`#status-${id}`).is(':checked') ? 1 : 0
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
        $('#edit-row-' + id).remove();
        $(`#row-${id}`).removeClass('hide');
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