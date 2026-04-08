let click = 0;
let validCode = false;
let validName = false;

const inputCode = document.getElementById("code");
const inputName = document.getElementById("name");
const regex = /[^a-zA-Z0-9-_.@]+/gi;


if(inputCode) {
  inputCode.addEventListener("input", () => validInput(inputCode, regex));
  inputCode.addEventListener("blur", () => validateCode());
}

if(inputName) {
  inputName.addEventListener("blur", () => validateName());
}

const addNew = () => {
  window.location.href = `${HOME}add_new`;
}

const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}

async function validateCode() {
  const id = document.getElementById("id") ? document.getElementById("id").value : null;
  const inputCode = document.getElementById("code");
  const codeError = document.getElementById("code-error");
  const value = inputCode.value.trim();
  if (!value) {
    setError(inputCode, codeError, "Code is Required");
    validCode = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const res = await validateRemote(url, { code: value, id: id });

  if (res === "exists") {
    setError(inputCode, codeError, "Code already exists");
    validCode = false;
    return false;
  } 
  clearError(inputCode, codeError);
  validCode = true;
  return true;
}

async function validateName() {
  const id = document.getElementById("id") ? document.getElementById("id").value : null;
  const inputName = document.getElementById("name");
  const nameError = document.getElementById("name-error");
  const value = inputName.value.trim();
  if (!value) {
    setError(inputName, nameError, "Name is Required");
    validName = false;
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: value, id: id });

  if (res === "exists") {
    setError(inputName, nameError, "Name already exists");
    validName = false;
    return false;
  } 
  clearError(inputName, nameError);
  validName = true;
  return true;
}

async function add() {
  if(click !== 0) {
    return false;
  }

  click = 1;

  const inputCode = document.getElementById("code");
  const inputName = document.getElementById("name");
  const codeError = document.getElementById("code-error");
  const nameError = document.getElementById("name-error");
  const active = document.querySelector('input[name="active"]:checked').value;
  clearError(inputCode, codeError);
  clearError(inputName, nameError);

  if( ! await validateCode() | ! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    active: active
  };

  loadIn();

  try {
    const response = await postData(url, data);
    const res = await response.text();

    setTimeout(() => {
      loadOut();
      if(res === "success") {
        swal({
          title: "Success",
          type: "success",
          timer: 1000
        });

        setTimeout(() => { addNew(); }, 1200);
      }
      else {
        showError(res);
      }
    }, 500);

    click = 0;
  } 
  catch (error) {
    click = 0;
    showError(error.message);
  }
}

async function update() {
  if (click !== 0) {
    return false;
  }
  click = 1;
  const id = document.getElementById('id').value;
  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');  
  const codeError = document.getElementById('code-error');
  const nameError = document.getElementById('name-error');
  const active = document.querySelector('input[name="active"]:checked').value;
  clearError(inputCode, codeError);
  clearError(inputName, nameError);
  
  if( ! await validateCode() | ! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}update`;
  const data = {
    id: id,
    code: inputCode.value.trim(),
    name: inputName.value.trim(),
    active: active
  };

  loadIn();

  try {
    const response = await postData(url, data);
    const res = await response.text();

    setTimeout(() => {
      loadOut();
      if (res === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { edit(id); }, 1200);
      }
      else {
        showError(res);
      }
    }, 500);

    click = 0;
  } 
  catch (error) {
    click = 0;
    showError(error.message);
  }
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
  function(isConfirm) {
    if (isConfirm) {
      deleteBrand(id);
    }
  });
}

async function deleteBrand(id) {
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
    showError(error.message);
  }
}