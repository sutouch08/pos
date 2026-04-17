let click = 0;
const regex = /[^a-zA-Z0-9\-_.@]/g;
const inputCode = document.getElementById('code');
if (inputCode) {
  inputCode.addEventListener('input', () => validInput(inputCode, regex));
}

async function validateCode() {
  const id = document.getElementById("id") ? document.getElementById("id").value : null;
  const inputCode = document.getElementById("acc-no");
  const codeError = document.getElementById("acc-no-error");
  const value = inputCode.value.trim();
  if (!value) {
    setError(inputCode, codeError, "Account number is required");
    return false;
  }
  //--- check duplicated
  const url = `${HOME}is_exists_account_no`;
  const res = await validateRemote(url, { account_no: value, id: id });
  if (res === 'exists') {
    setError(inputCode, codeError, "Account No already exists");
    return false;
  }
  else {
    clearError(inputCode, codeError);
  }

  return true;
}

async function validateName() {  
  const inputName = document.getElementById("acc-name");
  const nameError = document.getElementById("acc-name-error");
  const value = inputName.value.trim();
  if (!value) {
    setError(inputName, nameError, "Account name is required");
    return false;
  }  
  else {
    clearError(inputName, nameError);
  }

  return true;
}


const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}


const viewDetail = (id) => {
  const width = 800;
  const height = 600;
  const left = (screen.width - width) / 2;
  const top = 50;
  const options = `width=${width},height=${height},top=${top},left=${left}`;
  const url = `${HOME}view_detail/${id}?nomenu`;
  window.open(url, '_blank', options);  
}


async function add() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  clearErrorByClass('e');

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  const bank = document.getElementById("bank");
  const bankError = document.getElementById("bank-error");  
  const accountNo = document.getElementById("acc-no");
  const accNoError = document.getElementById("acc-no-error");
  const accountName = document.getElementById("acc-name");
  const accNameError = document.getElementById("acc-name-error");
  const branch = document.getElementById("branch");
  const active = document.querySelector('input[name="status"]:checked').value;

  if(!bank.value) {
    setError(bank, bankError, "Please select a bank");
    click = 0;
    return false;
  }

  if(!accountNo.value) {
    setError(accountNo, accNoError, "Account number is required");
    click = 0;
    return false;
  }

  if(!accountName.value) {
    setError(accountName, accNameError, "Account name is required");
    click = 0;
    return false;
  }

  const data = {    
    bank_code: bank.value,
    account_no: accountNo.value.trim(),
    account_name: accountName.value.trim(),
    branch: branch.value.trim(),
    active: active
  };

  const url = `${HOME}add`;

  loadIn();

  try {
    const res = await postData(url, data);
    const rs = await res.text();

    setTimeout(() => {
      loadOut();
      if(rs.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { addNew(); }, 1200);
      }
      else {
        showError(rs);
      }      
    }, 500);
  }
  catch (error) {    
    click = 0;
    showError(error.message);
  }
  finally {
    click = 0;
  }
}


async function update() {
  clearErrorByClass('e');
  const id = document.getElementById("id").value;
  const bank = document.getElementById("bank");  
  const accountNo = document.getElementById("acc-no");
  const accNoError = document.getElementById("acc-no-error");
  const accountName = document.getElementById("acc-name");
  const accNameError = document.getElementById("acc-name-error");
  const branch = document.getElementById("branch");
  const active = document.querySelector('input[name="status"]:checked').value;

  if( ! await validateCode() || ! await validateName()) {
     return false;
  }

  if(!bank.value) {
    setError(bank, document.getElementById("bank-error"), "Please select a bank");
    return false;
  }

  if(!accountNo.value) {
    setError(accountNo, accNoError, "Account No is required");
    return false;
  }

  if(!accountName.value) {
    setError(accountName, accNameError, "Account name is required");
    return false;
  }

  const data = {
    id: id,    
    bank_code: bank.value,
    account_no: accountNo.value.trim(),
    account_name: accountName.value.trim(),
    branch: branch.value.trim(),
    active: active
  };

  const url = `${HOME}update`;

  loadIn();

  try {
    const res = await postData(url, data);
    const rs = await res.text();
    setTimeout(() => {
      loadOut();
      if(rs.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { window.location.reload(); }, 1200);
      }
      else {
        showError(rs);
      }
    }, 500);
  }
  catch (error) {        
    showError(error.message);
  }  
}


confirmDelete = (id, name) => {
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
  catch (error) {        
    showError(error.message);
  }  
}
