var click = 0;
var validUname = true;
var validDname = true;
var validPwd = true;

const inputUname = document.getElementById('uname');
const regex = /[^a-zA-Z-_.@]+/gi;
inputUname.addEventListener('keyup', () => validInput(inputUname, regex));
document.getElementById('uname').addEventListener('focusout', debounce(() => validateUserName(), 300));
document.getElementById('dname').addEventListener('focusout', debounce(() => validateDisplayName(), 300));
document.getElementById('pwd').addEventListener('input', debounce(() => validatePwd(), 300));
document.getElementById('cm-pwd').addEventListener('input', debounce(() => validatePwd(), 300));

function debounce(fn, delay = 300) {
  let timer = null;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => fn(...args), delay);
  };
}

function setError(input, errorBox, message) {
  errorBox.textContent = message;
  input.classList.add('has-error');
}

function clearError(input, errorBox) {
  errorBox.textContent = '';
  input.classList.remove('has-error');
}

async function validateRemote(url, data = {}) {
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });

    return (await response.text()).trim();
  } catch (err) {
    console.error('Validation error:', err);
    return 'error';
  }
}


async function validateUserName() {
  const input = document.getElementById('uname');
  const errorBox = document.getElementById('uname-error');
  const id = document.getElementById('user_id').value.trim();
  const value = input.value.trim();

  if (!value) {
    setError(input, errorBox, 'User name is required!');
    validUname = false;
    return false;
  }

  const url = `${HOME}valid_uname`;
  const result = await validateRemote(url, { uname: value, id : id });

  if (result === 'exists') {
    setError(input, errorBox, 'User name already exists!');    
    validUname = false;
    return false;
  }

  clearError(input, errorBox);  
  validUname = true;
  return true;
}


async function validateDisplayName() {
  const input = document.getElementById('dname');
  const errorBox = document.getElementById('dname-error');
  const id = document.getElementById('user_id').value.trim();
  const value = input.value.trim();

  if (!value) {
    setError(input, errorBox, 'Display name is required!');
    validDname = false;
    return false;
  }

  const url = `${HOME}valid_dname`;
  const result = await validateRemote(url, { dname: value, id: id});

  if (result === 'exists') {
    setError(input, errorBox, 'Display name already exists!');
    validDname = false;
    return false;
  }

  clearError(input, errorBox); 
  validDname = true;
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


function validatePassword(input)
{
	if(USE_STRONG_PWD == 1) {
    const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
      return pattern.test(input);		
	}

	return true;
}


const add = async () => {
  if (click !== 0) return;
  click = 1;

  if (!validUname || !validDname || !validPwd) {
    click = 0;
    return false;
  }

  const uname = document.getElementById('uname');
  const dname = document.getElementById('dname');
  const pwd = document.getElementById('pwd');
  const profile = document.getElementById('profile');
  const sale = document.getElementById('sale-id');
  const status = document.querySelector('input[name="status"]:checked');
  const profileError = document.getElementById('profile-error');

  const url = `${HOME}add`;

  const data = {
    uname: uname.value.trim(),
    dname: dname.value.trim(),
    pwd: pwd.value.trim(),
    id_profile: profile.value.trim(),
    sale_id: sale.value.trim(),
    active: status.value
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
};


// const add = async () => {
//   if(click === 0) {
//     click = 1;

//     if( ! validUname || ! validDname || ! validPwd) {
//       click = 0;
//       return false;
//     }

//     const uname = document.getElementById('uname');
//     const dname = document.getElementById('dname');
//     const pwd = document.getElementById('pwd');
//     const profile = document.getElementById('profile');
//     const sale = document.getElementById('sale-id');
//     const status = document.querySelector('input[name="status"]:checked');
//     const profileError = document.getElementById('prodile-error');
//     const url = `${HOME}add`;

//     let data = {
//       'uname' : uname.value.trim(),
//       'dname' : dname.value.trim(),
//       'pwd' : pwd.value.trim(),
//       'id_profile' : profile.value.trim(),
//       'sale_id' : sale.value.trim(),
//       'active' : status.value
//     };

//     if(data.id_profile == "") {
//       setError(profile, profileError, 'Profile is required!');
//       click = 0;
//       return false;
//     }

//     loadIn();

//     $.ajax({
//       url:url,
//       type:'POST',
//       cache:false,
//       data:{
//         'data' : JSON.stringify(data)
//       },
//       success:function(rs) {
//         loadOut();

//         if(isJson(rs)) {
//           let ds = JSON.parse(rs);

//           if(ds.status === 'success') {
//             swal({
//               title:'Success',
//               type:'success',
//               timer:1000
//             });

//             setTimeout(() => {
//               addNew();
//             }, 1200);
//           }
//           else {
//             showError(ds.message);
//           }
//         }
//         else {
//           showError(rs);
//         }
//       },
//       error:function(rs) {
//         showError(rs);
//       }
//     })
//   }
// }