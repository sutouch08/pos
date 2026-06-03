
const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


const edit = (uid) => {
  window.location.href = `${HOME}edit/${uid}`;
}


const getReset = (uid) => {
  window.location.href = `${HOME}reset_password/${uid}`;
}


const viewDetail = (uid) => {
  const url = `${HOME}view_detail/${uid}?nomenu&nonavbar`;
  const width = 900;
  const height = 800;
  const left = (screen.width - width) / 2;
  const top = (screen.height - height) / 2;
  window.open(url, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
}


const confirmDelete = (id, uid, name) => {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to delete ${name} ?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FA5858',
    confirmButtonText: 'Yes, I want to delete',
    cancelButtonText: 'Cancel',
    closeOnConfirm: true
  }, function() {
    doDelete(id, uid);
  });
}


async function doDelete(id, uid) {
  const url = `${HOME}delete`;
  const data = { uid:uid };  
  loadIn();
  try {
    const response = await postData(url, data);
    const res = await response.json();

    setTimeout(() => {
      loadOut();
      if (res.status === 'success') {
        swal({
          title: 'Deleted',
          text: `User has been deleted`,
          type: 'success',
          timer: 1000
        });

        $(`#row-${id}`).remove();

        reIndex();
      }
      else {
        showError(res.message);
      }
    }, 500);
  }
  catch (err) {    
    loadOut();
    showError(err);
  }
}


const confirmRestore = (uid, name) => {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to restore <b class="blue">${name}</b> ?`,
    type: 'warning',
    html:true,
    showCancelButton: true,
    confirmButtonColor: '#5CB85C',
    confirmButtonText: 'Yes, I want to restore',
    cancelButtonText: 'Cancel',
    closeOnConfirm: true
  }, function() {
    doRestore(uid);
  });
}


async function doRestore(uid) {
  const url = `${HOME}restore`;
  const data = { uid:uid };  
  loadIn();
  try {
    const response = await postData(url, data);
    const res = await response.json();

    setTimeout(() => {
      loadOut();
      if (res.status === 'success') {
        swal({
          title: 'Restored',
          text: `User has been restored`,
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { refresh(); }, 1200);
      }
      else {
        showError(res.message);
      }
    }, 500);
  }
  catch (err) {    
    loadOut();
    showError(err);
  }
}


const confirmPermanentDelete = (uid, name) => {
  swal({
    title: 'Are you sure ?',
    text: `Do you want to permanently delete <b class="red">${name}</b> ?<br><br><span class="red">This action cannot be undone.</span>`,
    type: 'warning',
    html:true,
    showCancelButton: true,
    confirmButtonColor: '#FA5858',
    confirmButtonText: 'Yes, I want to delete',
    cancelButtonText: 'Cancel',
    closeOnConfirm: true
  }, function() {
    doPermanentDelete(uid);
  });
}


async function doPermanentDelete(uid) {
  const url = `${HOME}permanent_delete`;
  const data = { uid:uid };  
  loadIn();
  try {
    const response = await postData(url, data);
    const res = await response.json();

    setTimeout(() => {
      loadOut();
      if (res.status === 'success') {
        swal({
          title: 'Deleted',
          text: `User has been permanently deleted`,
          type: 'success',
          timer: 1000
        });

        setTimeout(() => { refresh(); }, 1200);
      }
      else {
        showError(res.message);
      }
    }, 500);
  }
  catch (err) {    
    loadOut();
    showError(err);
  }
}


const getPermission = async (uid) => {
  loadIn();
  
  document.getElementById('uid').value = uid;
  const url = `${HOME}get_permission/${uid}`;

  try {
    const response = await fetch(url);

    loadOut();

    if(response.ok) {
      const ds = await response.json();

      if(ds){
        if(ds.status === 'success') {
          const source = $('#template').html();
          const output = $('#permission-result');

          render(source, ds.data, output);

          $('#permission-modal').modal('show');
        }
        else {
          showError(ds.message);
        }        
      }
      else {
        showError(ds);
      }
    }
    else {
      throw new Error(response.status);
    }
  }
  catch (err) {
    showError(err);
  }
}


const exportPermission = () => {
  const url = `${HOME}export_permission`;
  const uid = document.getElementById('uid').value;  
  const data = { uid:uid };  
  $('#permission-modal').modal('hide');  
  downloadExcel(url, data);
}
  
