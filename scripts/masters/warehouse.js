let click = 0;

function addNew() {
  window.location.href = `${HOME}add_new`;
}

function edit(id) {
  window.location.href = `${HOME}edit/${id}`;
}

function viewDetail(id) {
  const width = 800;
  const height = 800;
  const left = (screen.width - width) / 2;
  const top = (screen.height - height) / 2;
  window.open(`${HOME}view_details/${id}?nomenu&nonavbar`, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
}

async function validateCode(id = null) {
  const code = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  
  if (code.value.trim() === '') {
    setError(code, codeError, 'Code is required');
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_code`;
  const res = await validateRemote(url, { code: code.value.trim(), id: id });
  if (res === 'exists') {
    setError(code, codeError, 'Code already exists');
    return false;
  }

  clearError(code, codeError);

  return true;
}

async function validateName(id = null) {
  const name = document.getElementById('name');
  const nameError = document.getElementById('name-error'); 
  if (name.value.trim() === '') {
    setError(name, nameError, 'Name is required');
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: name.value.trim(), id: id });
  if (res === 'exists') {
    setError(name, nameError, 'Name already exists');
    return false;
  }

  clearError(name, nameError);

  return true;
}


async function add() {
  if(click !== 0) {
    return false;
  }

  click = 1;

  const code = document.getElementById('code').value.trim();
  const name = document.getElementById('name').value.trim();
  const role = document.getElementById('role').value;
  const active = document.querySelector('input[name="active"]:checked').value;
  const auz = document.querySelector('input[name="auz"]:checked').value;

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  const url = `${HOME}add`;
  const data = {
    code: code,
    name: name,
    role: role,
    active: active,
    auz: auz
  };

  try {
    const response = await postData(url, data);
    const res = await response.text();
    if (res === 'success') {
      click = 0;
      swal({
        title: 'Success',
        type:'success',
        text:'เพิ่มคลังสินค้าเรียบร้อยแล้ว <br>ต้องการเพิ่มอีกหรือไม่ ?',
        html:true,
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        confirmButtonText: 'Yes, add more',
        cancelButtonText: 'No, go back'     
      },
      function(isConfirm){
        if(isConfirm) {
          addNew();
        }
        else {
          goBack();
        }
      });
    }
    else {
      click = 0;
      showError(res);
    }
  }
  catch (error) {
    click = 0;
    showError(error.message);
  }
}


async function update() {
  if(click !== 0) {
    return false;
  }
  click = 1;

  const id = document.getElementById('id').value;
  const code = document.getElementById('code').value.trim();
  const name = document.getElementById('name').value.trim();
  const role = document.getElementById('role').value;
  const active = document.querySelector('input[name="active"]:checked').value;
  const auz = document.querySelector('input[name="auz"]:checked').value;

  if (! await validateCode(id) || ! await validateName(id)) {
    click = 0;
    return false;
  }

  const url = `${HOME}update`;
  const data = {
    id: id,
    code: code,
    name: name,
    role: role,
    active: active,
    auz: auz
  };

  try {
    const response = await postData(url, data);
    const res = await response.text();
    if (res === 'success') {
      click = 0;
      swal({
        title: 'Success',
        type:'success',
        text:'แก้ไขคลังสินค้าเรียบร้อยแล้ว',
        html:true,
        timer:1000
      });
    }
    else {
      click = 0;
      showError(res);
    }
  }
  catch (error) {
    click = 0;
    showError(error.message);
  }
}


function confirmDelete(id, code) {
  swal({
    title: 'Are sure ?',
    text: `Do you want to delete ${code} ?`,
    type: 'warning',
    html:true,
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, delete',
    cancelButtonText: 'No, cancel',
    closeOnConfirm: true
  },
  function(isConfirm){
    if (isConfirm) {
      setTimeout(() => {
        doDelete(id);
      }, 100);
    }
  });
}


async function doDelete(id) {
  const url = `${HOME}delete`;
  try {
    const response = await postData(url, { id: id });
    const res = await response.text();
    if (res === 'success') {
      swal({
        title: 'Deleted!',
        text: 'Your warehouse has been deleted.',
        type: 'success',
        html: true,
        timer: 1000
      });

      const row = document.getElementById(`row-${id}`);
      if (row) {
        row.remove();
      }

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


function restore(id, code) {
  swal({
    title: 'Are sure ?',
    text: `Do you want to restore ${code} ?`,
    type: 'warning',
    html:true,
    showCancelButton: true,
    confirmButtonColor: '#5cb85c',
    confirmButtonText: 'Yes, restore',
    cancelButtonText: 'No, cancel',
    closeOnConfirm: true
  },
  function(isConfirm){
    if (isConfirm) {
      setTimeout(() => {
        doRestore(id);
      }, 100);
    }
  });
}


async function doRestore(id) {
  const url = `${HOME}restore`;
  try {
    const response = await postData(url, { id: id });
    const res = await response.text();
    if (res === 'success') {
      swal({
        title: 'Restored!',
        text: 'Your warehouse has been restored.',
        type: 'success',
        html: true,
        timer: 1000
      });

      setTimeout(() => {
        refresh();
      }, 1200);
    } 
    else {
      showError(res);
    }
  } 
  catch (error) {
    showError(error.message);
  }
}


function confirmPermanentDelete(id, code) {
  swal({
    title: 'Are sure ?',
    text: `Do you want to permanently delete ${code} ? This action cannot be undone.`,
    type: 'warning',
    html:true,
    showCancelButton: true,
    confirmButtonColor: '#d9534f',
    confirmButtonText: 'Yes, delete permanently',
    cancelButtonText: 'No, cancel',
    closeOnConfirm: true
  },
  function(isConfirm){
    if (isConfirm) {
      setTimeout(() => {
        doPermanentDelete(id);                
      }, 100);
    }
  });
}

async function doPermanentDelete(id) {
  const url = `${HOME}permanent_delete`;
  try {
    const response = await postData(url, { id: id });
    const res = await response.text();
    if (res === 'success') {
      swal({
        title: 'Deleted!',
        text: 'Your warehouse has been permanently deleted.',
        type: 'success',
        html: true,
        timer: 1000
      }, function() {
         refresh();
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
