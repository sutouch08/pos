
const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;
}


const getReset = (id) => {
  window.location.href = `${HOME}reset_password/${id}`;
}


function getDelete(id, uname){
  swal({
    title:'Are sure ?',
    text:'ต้องการลบ '+ uname +' หรือไม่ ?',
    type:'warning',
    showCancelButton: true,
		confirmButtonColor: '#FA5858',
		confirmButtonText: 'ใช่, ฉันต้องการลบ',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: false
  },function(){
    $.ajax({
      url: `${HOME}delete_user`,
      type:'POST',
      cache:false,
      data:{
        'id' : id
      },
      success:function(rs){
        if(rs.trim() == 'success'){
          swal({
            title:'Deleted',
            title:'User deleted',
            type:'success',
            timer: 1000
          });

          $(`#row-${id}`).remove();

          reIndex();          
        }
        else{
          showError(rs);          
        }
      },
      error:function(rs) {
        showError(rs);
      }
    })
  })
}


const getPermission = async (id) => {
  loadIn();
  document.getElementById('user-id').value = id;
  
  const url = `${HOME}get_permission/${id}`;

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



function doExport() {
  let token = generateUID();
  $('#token').val(token);
  $('#permission-modal').modal('hide');
  getDownload(token);
  $('#permission-form').submit();
}


function getAllPermission() {
  $('#all-permission-modal').modal('show');
}

function exportAll(option) {
  let token = Date.now();
  $('#all').val(option);
  $('#all-token').val(token);
  $('#all-permission-modal').modal('hide');
  get_download(token);
  $('#all-permission-form').submit();
}
