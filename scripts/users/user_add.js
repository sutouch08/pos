var click = 0;
var validUname = true;
var validDname = true;
var validPwd = true;

const inputUname = document.getElementById('uname');
const inputDname = document.getElementById('dname');
const inputPwd = document.getElementById('pwd');
const inputCmPwd = document.getElementById('cm-pwd');
const regex = /[^a-zA-Z0-9-_.@]+/gi;

window.addEventListener('load', () => {
  if (inputUname) {
    inputUname.addEventListener('input', () => validInput(inputUname, regex));
  }

  if (inputPwd && inputCmPwd) {
    inputPwd.addEventListener('input', debounce(() => validatePwd(), 300));
    inputCmPwd.addEventListener('input', debounce(() => validatePwd(), 300));
  }
})


async function validateUname(uid = null) {
  const uname = document.getElementById('uname');
  const unameError = document.getElementById('uname-error');
  const value = uname.value.trim();

  if (value === '') {
    setError(uname, unameError, 'User name is required!');
    return false;
  }

  const url = `${HOME}valid_uname`;
  const res = await validateRemote(url, { uname: value, id: uid });
  if (res === 'exists') {
    setError(uname, unameError, 'User name already exists!');
    return false;
  }

  clearError(uname, unameError);
  return true;
}

async function validateDname(uid = null) {
  const dname = document.getElementById('dname');
  const dnameError = document.getElementById('dname-error');
  const value = dname.value.trim();
  if (value === '') {
    setError(dname, dnameError, 'Display name is required!');
    return false;
  }

  const url = `${HOME}valid_dname`;
  const res = await validateRemote(url, { dname: value, id: uid });
  if (res === 'exists') {
    setError(dname, dnameError, 'Display name already exists!');
    return false;
  }

  clearError(dname, dnameError);
  return true;
}


function validatePwd() {
  const pwd = document.getElementById('pwd');
  const cmp = document.getElementById('cm-pwd');
  const pwdError = document.getElementById('pwd-error');
  const cmpError = document.getElementById('cm-pwd-error');

  const p = pwd.value.trim();
  const c = cmp.value.trim();

  if (!p) {
    setError(pwd, pwdError, 'Password is required!');
    validPwd = false;
    return false;
  }

  if (!validatePassword(p)) {
    setError(
      pwd,
      pwdError,
      'รหัสผ่านต้องมีความยาว 8 - 20 ตัวอักษร และต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก พิมพ์ใหญ่ และตัวเลขอย่างน้อย อย่างละตัว'
    );
    validPwd = false;
    return false;
  }

  clearError(pwd, pwdError);

  if (p !== c) {
    setError(cmp, cmpError, 'Password mismatch!');
    validPwd = false;
    return false;
  }

  clearError(cmp, cmpError);
  validPwd = true;
  return true;
}


function validatePassword(input) {
  if (USE_STRONG_PWD == 1) {
    const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
    return pattern.test(input);
  }

  return true;
}


const changePassword = async () => {
  if (!validPwd) {
    return false;
  }

  const id = document.getElementById('user-id').value;
  const pwd = document.getElementById('pwd').value.trim();
  const force = document.getElementById('force-reset').checked ? 1 : 0;
  const url = `${HOME}change_password`;
  const data = {
    id: id,
    pwd: pwd,
    force: force
  };

  if (data.length == 0) {
    console.log("no data found");
    return false;
  }

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const text = await response.text();

    setTimeout(() => {
      loadOut();
      if (text.trim() === 'success') {
        swal({
          title: 'Updated',
          text: "Password updated !",
          type: 'success',
          timer: 1000
        });
      }
      else {
        showError(text);
      }
    }, 500);
  }
  catch (err) {
    loadOut();
    showError(err);
  }
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (! await validateUname() || ! await validateDname() || !validatePwd()) {
    click = 0;
    return false;
  }

  const uname = document.getElementById('uname');
  const dname = document.getElementById('dname');
  const pwd = document.getElementById('pwd');
  const profile = document.getElementById('profile');
  const employee = document.getElementById('employee');
  const sale = document.getElementById('sale-id');
  const status = document.querySelector('input[name="status"]:checked');
  const profileError = document.getElementById('profile-error');
  const forceReset = document.getElementById('force-reset').checked ? 1 : 0;

  const url = `${HOME}add`;

  const data = {
    uname: uname.value.trim(),
    dname: dname.value.trim(),
    pwd: pwd.value.trim(),
    id_profile: profile.value.trim(),
    id_employee: employee.value.trim(),
    sale_id: sale.value.trim(),
    active: status.value,
    force_reset: forceReset
  };

  if (data.id_profile === "") {
    setError(profile, profileError, 'Profile is required!');
    click = 0;
    return false;
  }

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const text = await response.text();
    setTimeout(() => {
      loadOut();

      if (isJson(text)) {
        const ds = JSON.parse(text);

        if (ds.status === 'success') {
          swal({
            title: 'Success',
            type: 'success',
            timer: 1000
          });

          setTimeout(() => addNew(), 1200);
        } else {
          showError(ds.message);
        }
      } else {
        showError(text);
      }
    }, 500)
  } catch (err) {
    loadOut();
    showError(err);
  }

  click = 0;
}


const update = async () => {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const id = document.getElementById('user-id').value;

  if (! await validateDname(id)) {
    click = 0;
    return false;
  }

  const uid = document.getElementById('uid').value;
  const uname = document.getElementById('uname');
  const dname = document.getElementById('dname');
  const profile = document.getElementById('profile');
  const employee = document.getElementById('employee');
  const sale = document.getElementById('sale-id');
  const status = document.querySelector('input[name="status"]:checked');
  const profileError = document.getElementById('profile-error');

  const url = `${HOME}update`;

  const data = {
    id: id,
    uid: uid,
    uname: uname.value.trim(),
    dname: dname.value.trim(),
    id_profile: profile.value.trim(),
    id_employee: employee.value.trim(),
    sale_id: sale.value.trim(),
    active: status.value
  };

  if (data.id_profile === "") {
    setError(profile, profileError, 'Profile is required!');
    click = 0;
    return false;
  }

  clearError(profile, profileError);

  loadIn();

  try {
    const response = await postData(url, data);
    const res = await response.json();

    setTimeout(() => {
      loadOut();
      if (res.status === 'success') {
        swal({
          title: 'Updated',
          type: 'success',
          timer: 1000
        });
      }
      else {
        showError(res.message);
      }
    }, 500)
  }
  catch (err) {
    loadOut();
    showError(err);
  }

  click = 0;
};
