let click = 0;

async function validateName(id = null) {
  const inputName = id === null ? document.getElementById('name') : document.getElementById(`name-${id}`);
  const nameError = id === null ? document.getElementById('name-error') : document.getElementById(`error-${id}`);
  const name = inputName.value.trim();
  if (name === '') {
    setError(inputName, nameError, 'กรุณาระบุชื่อกลุ่ม');
    return false;
  }

  // Check for duplicate name
  const url = `${HOME}is_exists_name`;
  const result = await validateRemote(url, { name: name, id: id });
  if (result === 'exists') {
    setError(inputName, nameError, 'ชื่อกลุ่มนี้มีอยู่แล้วในระบบ');
    return false;
  }

  clearError(inputName, nameError);
  return true;
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

  const name = document.getElementById('name').value.trim();
  const url = `${HOME}add`;
  const data = { name: name };

  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (isJson(res)) {
      let ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#new-row-template').html();
        const output = $('#group-table');
        renderPrepend(template, ds.data, output);
        reIndex();
        $('#name').val('');
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


async function update(id) {
  const inputName = document.getElementById(`name-${id}`);
  const name = inputName.value.trim();

  if (! await validateName(id)) {
    return false;
  }

  const url = `${HOME}update`;
  const data = { id: id, name: name };

  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (isJson(res)) {
      let ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#row-template').html();
        const output = $(`#row-${id}`);
        render(template, ds.data, output);
        output.removeClass('hide');
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
  }
  catch (error) {
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
      let ds = JSON.parse(res);
      if (ds.status === 'success') {
        const template = $('#edit-row-template').html();
        const output = $(`#row-${id}`);
        renderAfter(template, ds.data, output);
        output.addClass('hide');
        setTimeout(() => { $(`#edit-row-${id}`).focus().select(); }, 100);
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


function confirmDelete(id, name) {
  swal({
    title: 'Are you sure?',
    text: `Do you want to delete ${name}?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel',
    closeOnConfirm: true
  }, function (isConfirm) {
    if (isConfirm) {
      setTimeout(() => {
        deleteGroup(id);
      }, 100);
    }
  });
}


async function deleteGroup(id) {
  const url = `${HOME}delete`;
  const data = { id: id };
  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (res.trim() === 'success') {
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
  }
  catch (error) {
    showError(error.message);
  }
}