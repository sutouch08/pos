let click = 0;
let validCode = false;
let validName = false;

const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');

if (inputCode) {  
  inputCode.addEventListener('focusout', () => validateCode());
}

if (inputName) {
  inputName.addEventListener('focusout', () => validateName());
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

  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    validCode = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const result = await validateRemote(url, { code: value });

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

  if (!value) {
    setError(inputName, nameError, 'Name is required');
    validName = false;
    return false;
  }

  clearError(inputName, nameError);
  validName = true;
  return true;
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (!validCode || !validName) {
    click = 0;
    return false;
  }

  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const codeError = document.getElementById('code-error');
  const nameError = document.getElementById('name-error');
  const active = document.querySelector('input[name="active"]:checked').value;

  clearError(inputCode, codeError);
  clearError(inputName, nameError);

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    active: active
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const rs = await response.text();

    setTimeout(() => {
      loadOut();

      if (rs.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { addNew() }, 1200);
      }
      else {
        showError(rs);
      }

      click = 0;
    }, 500);
  }
  catch (err) {
    click = 0;
    showError(err);
  }
}


async function update() {
  if (click !== 0) {
    return false;
  }
  click = 1;

  if (!validName) {
    click = 0;
    return false;
  }

  const inputId = document.getElementById('id');
  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const codeError = document.getElementById('code-error');
  const nameError = document.getElementById('name-error');
  const active = document.querySelector('input[name="active"]:checked').value;
  clearError(inputCode, codeError);
  clearError(inputName, nameError);

  const url = `${HOME}update`;
  const data = {
    id: inputId.value,
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    active: active
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const rs = await response.text();

    setTimeout(() => {
      loadOut();

      if (rs.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });
      }
      else {
        showError(rs);
      }

      click = 0;
    }, 500);
  }
  catch (err) {
    click = 0;
    showError(err);
  }
}


function confirmDelete(id, code, name) {
  swal({
    title: 'ARE YOU SURE ?',
    text: `Do you want to delete ${code} : ${name} ?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, I am sure!',
    cancelButtonText: 'No, cancel it!',
    closeOnConfirm: true
  }, function (isConfirm) {
    if (isConfirm) {
      loadIn();
      deleteUnit(id);
    }
  });
}


async function deleteUnit(id) {
  const url = `${HOME}delete`;
  const data = { id };

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const rs = await response.text();

    setTimeout(() => {
      loadOut();

      if (rs.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        $(`#row-${id}`).remove();
        reIndex();
      }
      else {
        showError(rs);
      }      
    }, 500);
  }
  catch (err) {    
    showError(err);
  }
}
