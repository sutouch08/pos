let click = 0;

const addNew = () => {
  window.location.href = `${HOME}add_new`;
}

const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}

const viewDetail = (id) => {
  const url = `${HOME}view_detail/${id}?nomenu&nonavbar`;
  const width = 800;
  const height = 800;
  const left = (window.innerWidth - width) / 2;
  const top = (window.innerHeight - height) / 2;
  window.open(url, '_blank', `width=${width},height=${height},left=${left},top=${top}`);
}

const checkAll = () => {
  const isChecked = document.getElementById('chk-all').checked;

  if (isChecked) {
    document.querySelectorAll('.chk').forEach(el => el.checked = true);
  } else {
    document.querySelectorAll('.chk').forEach(el => el.checked = false);
  }
}

async function validateCode(id = null) {
  const inputCode = document.getElementById('code');
  const codeError = document.getElementById('code-error');
  const code = inputCode.value.trim();

  if (code === '') {
    setError(inputCode, codeError, 'Code is required');
    return false;
  }

  const url = `${HOME}is_exists_code`;
  const res = await validateRemote(url, { code: code, id: id });
  if (res === 'exists') {
    setError(inputCode, codeError, 'Code already exists');
    return false;
  }

  clearError(inputCode, codeError);

  return true;
}


async function validateName(id = null) {
  const inputName = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const name = inputName.value.trim();
  if (name === '') {
    setError(inputName, nameError, 'Name is required');
    return false;
  }

  const url = `${HOME}is_exists_name`;
  const res = await validateRemote(url, { name: name, id: id });
  if (res === 'exists') {
    setError(inputName, nameError, 'Name already exists');
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

  const code = document.getElementById('code').value.trim();
  const name = document.getElementById('name').value.trim();
  const warehouseId = document.getElementById('warehouse').value;
  const active = document.querySelector('input[name="active"]:checked').value;
  const pickface = document.querySelector('input[name="pickface"]:checked').value;
  const fastmove = document.querySelector('input[name="fastmove"]:checked').value;

  if (! await validateCode() || ! await validateName()) {
    click = 0;
    return false;
  }

  if (warehouseId === '') {
    setError(document.getElementById('warehouse'), document.getElementById('warehouse-error'), 'Warehouse is required');
    click = 0;
    return false;
  }
  else {
    clearError(document.getElementById('warehouse'), document.getElementById('warehouse-error'));
  }

  const data = {
    code: code,
    name: name,
    warehouse_id: warehouseId,
    active: active,
    pickface: pickface,
    fastmove: fastmove
  };

  const url = `${HOME}add`;
  try {
    const response = await postData(url, data);
    const res = await response.text();

    if (res === 'success') {
      click = 0;
      swal({
        title: 'Success',
        text: 'เพิ่มโซนเรียบร้อยแล้วม ตั้องการเพิ่มโซนอีกหรือไม่ ?',
        type: 'success',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonColor: '#5cb85c'
      }, function (isConfirm) {
        if (isConfirm) {
          window.location.href = `${HOME}add_new`;
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
    showError(error);
  }
}


async function update() {
  if (click !== 0) {
    return false;
  }
  click = 1;

  const id = document.getElementById('id').value;
  const code = document.getElementById('code').value.trim();
  const name = document.getElementById('name').value.trim();
  const warehouseId = document.getElementById('warehouse').value;
  const active = document.querySelector('input[name="active"]:checked').value;
  const pickface = document.querySelector('input[name="pickface"]:checked').value;
  const fastmove = document.querySelector('input[name="fastmove"]:checked').value;
  if (! await validateCode(id) || ! await validateName(id)) {
    click = 0;
    return false;
  }

  if (warehouseId === '') {
    setError(document.getElementById('warehouse'), document.getElementById('warehouse-error'), 'Warehouse is required');
    click = 0;
    return false;
  }
  else {
    clearError(document.getElementById('warehouse'), document.getElementById('warehouse-error'));
  }

  const data = {
    id: id,
    code: code,
    name: name,
    warehouse_id: warehouseId,
    active: active,
    pickface: pickface,
    fastmove: fastmove
  };

  const url = `${HOME}update`;
  try {
    const response = await postData(url, data);
    const res = await response.text();
    if (res === 'success') {
      click = 0;
      swal({
        title: 'Success',
        type: 'success',
        timer: 1000
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


const confirmDelete = (id, name) => {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to delete zone ${name} ?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete it!',
    cancelButtonText: 'No, cancel!',
    confirmButtonColor: '#d33',
    closeOnConfirm:true    
  }, function (isConfirm) {
    if (isConfirm) {
      setTimeout(() => {
        doDelete(id);
      }, 100);
    }
  });
}


async function doDelete(id) {
  const url = `${HOME}delete`;
  const data = { id: id };
  try {
    const response = await postData(url, data);
    const res = await response.text();
    if (res === 'success') {
      swal({
        title: 'Deleted!',
        text: 'The zone has been deleted.',
        type: 'success',
        timer: 1000
      });
      
      const row = document.getElementById(`row-${id}`);

      if (row) {
        row.remove();
        reIndex();
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


function restore(id, name) {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to restore zone ${name} ?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Restore it!',
    cancelButtonText: 'No, cancel!',
    confirmButtonColor: '#5cb85c',
    closeOnConfirm:true    
  }, function (isConfirm) {
    if (isConfirm) {
      setTimeout(() => {
        doRestore(id);
      }, 100);
    }
  });
}


async function doRestore(id) {
  const url = `${HOME}restore`;
  const data = { id: id };
  try {
    const response = await postData(url, data);
    const res = await response.text();
    if (res === 'success') {
      swal({
        title: 'Restored!',
        text: 'The zone has been restored.',
        type: 'success',
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


function confirmPermanentDelete(id, name) {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to permanently delete zone ${name} ? This action cannot be undone.`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete it!',
    cancelButtonText: 'No, cancel!',
    confirmButtonColor: '#d33', 
    closeOnConfirm:true   
  }, function (isConfirm) {
    if (isConfirm) {
      setTimeout(() => {
        doPermanentDelete(id);
      }, 100);
    }
  });
}


async function doPermanentDelete(id) {
  const url = `${HOME}permanent_delete`;
  const data = { id: id };
  try {
    const response = await postData(url, data);
    const res = await response.text();
    if (res === 'success') {
      swal({
        title: 'Deleted!',
        text: 'The zone has been permanently deleted.',
        type: 'success'
      }, function(){
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

