let click = 0;

const inputCode = document.getElementById("code");
const regex = /[^a-zA-Z0-9-_.@\/]+/gi;

if (inputCode) {
  inputCode.addEventListener("input", () => validInput(inputCode, regex));
}

async function validateCode() {
  const id = document.getElementById("id") ? document.getElementById("id").value : null;
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById("code-error");
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


async function validateName() {
  const id = document.getElementById("id") ? document.getElementById("id").value : null;
  const fname = document.getElementById("fname");
  const fnameError = document.getElementById("fname-error");
  const lname = document.getElementById("lname");
  const lnameError = document.getElementById("lname-error");

  if (!fname.value.trim()) {
    setError(fname, fnameError, "First Name is Required");
    return false;
  }

  if (!lname.value.trim()) {
    setError(lname, lnameError, "Last Name is Required");
    return false;
  }

  const name = `${fname.value.trim()} ${lname.value.trim()}`;

  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { fname: fname.value.trim(), lname: lname.value.trim(), id: id });

  if (res === "exists") {
    setError(fname, fnameError, `${name} already exists`);
    setError(lname, lnameError, `${name} already exists`);
    return false;
  }

  clearError(fname, fnameError);
  clearError(lname, lnameError);
  return true;
}


const clearInputCode = () => {
  const inputCode = document.getElementById("code");
  inputCode.value = "";
  inputCode.focus();
}


async function genEmployeeCode() {
  const prefix = document.getElementById('prefix');
  const code = document.getElementById('code');
  const codeError = document.getElementById("code-error");
  const value = prefix.value.trim();

  if (!value) {
    setError(prefix, codeError, "Please select prefix");
    return false;
  }

  const url = `${HOME}generate_code`;
  try {
    const response = await postData(url, { prefix: value });
    const res = await response.text();
    if(isJson(res)) {
      const ds = JSON.parse(res);
      if(ds.status === 'success') {
        code.value = ds.code;
        clearError(prefix, codeError);
        $('#fname').focus();
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


const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  clearErrorByClass('e');

  const code = document.getElementById('code').value.trim();
  const fname = document.getElementById('fname').value.trim();
  const lname = document.getElementById('lname').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const email = document.getElementById('email').value.trim();
  const gender = document.getElementById('gender').value;
  const birthDate = document.getElementById('birth-date').value.trim();
  const position = document.getElementById('position').value;
  const department = document.getElementById('department').value;
  const employmentStatus = document.getElementById('employment-status').value;  
  const hireDate = document.getElementById('hire-date').value.trim();
  const active = document.querySelector('input[name="active"]').checked ? 1 : 0;

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  if(birthDate && !isDate(birthDate)) {
    $('#birth-date').hasError("Invalid Birth Date");
    click = 0;
    return false;
  }

  if(hireDate && !isDate(hireDate)) {
    $('#hire-date').hasError("Invalid Hire Date");
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    code: code,
    fname: fname,
    lname: lname,
    phone: phone,
    email: email,
    gender: gender,
    birthDate: birthDate,
    position: position,
    department: department,
    status: employmentStatus,
    hireDate: hireDate,
    active: active
  };

  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (res.trim() === 'success') {
      swal({
        title: 'Success',
        type: 'success',
        timer: 1000
      });

      setTimeout(() => { addNew(); }, 1200);
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
  window.location.href = `${HOME}edit/${id}`;
}


async function update() {
  clearErrorByClass('e');

  const id = document.getElementById("id").value;  
  const fname = document.getElementById('fname').value.trim();
  const lname = document.getElementById('lname').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const email = document.getElementById('email').value.trim();
  const gender = document.getElementById('gender').value;
  const birthDate = document.getElementById('birth-date').value.trim();
  const position = document.getElementById('position').value;
  const department = document.getElementById('department').value;
  const employmentStatus = document.getElementById('employment-status').value;
  const hireDate = document.getElementById('hire-date').value.trim();
  const active = document.querySelector('input[name="active"]').checked ? 1 : 0;

  if (! await validateName()) {    
    return false;
  }

  if (birthDate && !isDate(birthDate)) {
    $('#birth-date').hasError("Invalid Birth Date");    
    return false;
  }

  if (hireDate && !isDate(hireDate)) {
    $('#hire-date').hasError("Invalid Hire Date");    
    return false;
  }
  
  const url = `${HOME}update`;
  const data = {
    id: id,
    fname: fname,
    lname: lname,
    phone: phone,
    email: email,
    gender: gender,
    birthDate: birthDate,
    position: position,
    department: department,
    status: employmentStatus,
    hireDate: hireDate,
    active: active
  };

  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (res.trim() === 'success') {
      swal({
        title: 'Success',
        type: 'success',
        timer: 1000
      });
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