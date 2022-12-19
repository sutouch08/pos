var HOME = BASE_URL + 'masters/department/';

function goBack() {
  window.location.href = HOME;
}

$('#add-modal').on('shown.bs.modal', function() {
  $('#add-name').focus();
});

$('#edit-modal').on('shown.bs.modal', function() {
  $('#edit-name').focus();
});

function closeModal(name) {
  $('#'+name).modal('hide');
}

function showModal(name) {
  $('#'+name).modal('show');
}

function addNew() {
  $('#add-name').val('');

  showModal('add-modal');
}


function saveAdd() {
  let name = $('#add-name').val();
  let status = $('#add-active').is(':checked') ? 1 : 0;

  if(name.length == 0) {
    $('#add-name-error').text('required');

    return false;
  }
  else {
    $('#add-name-error').text('');
  }

  closeModal('add-modal');

  setTimeout(function() {
    load_in();
    $.ajax({
      url:HOME + 'add',
      type:'POST',
      cache:false,
      data:{
        'name' : name,
        'status' : status
      },
      success:function(rs) {
        load_out();

        if(rs === 'success') {
          setTimeout(function() {
            Swal.fire({
    					title:'Success',
    					icon:'success',
              showConfirmButton:false,
              width:'500px',
    					timer:1000
    				});

            setTimeout(function() {
              window.location.reload();
            }, 1200);
          }, 200);
        }
        else {
          Swal.fire({
  					title:'Error!',
  					text: rs,
  					icon:'error'
  				});
        }
      },
  		error:function(xhr) {
  			load_out();
  			Swal.fire({
  				title:"Error!",
  				text: xhr.responseText,
  				icon:'error'
  			});
  		}
    });
  }, 500);
}


function getEdit(id) {
  $.ajax({
    url:HOME + 'get/'+id,
    type:'GET',
    cache:false,
    success:function(rs) {
      if( isJson(rs)) {
        let ds = $.parseJSON(rs);
        $('#edit-id').val(ds.id);
        $('#edit-name').val(ds.name);

        if(ds.status == '1') {
          $('#edit-active').prop('checked', true);
        }
        else {
          $('#edit-active').prop('checked', false);
        }

        showModal('edit-modal');
      }
      else {
        Swal.fire({
          title:'Error!',
          text:rs,
          icon:'error'
        });
      }
    }
  });
}


function update() {
  let id = $('#edit-id').val();
  let name = $('#edit-name').val();
  let status = $('#edit-active').is(':checked') ? 1 : 0;

  if(name.length == 0) {
    $('#edit-name-error').text('Required');
    return false;
  }
  else {
    $('#edit-name-error').text('');
  }

  closeModal('edit-modal');

  setTimeout(function() {
    load_in();

    $.ajax({
      url:HOME + 'update',
      type:'POST',
      cache:false,
      data:{
        'id' : id,
        'name' : name,
        'status' : status
      },
      success:function(rs) {
        load_out();

        setTimeout(function() {
          if(rs === 'success') {
            Swal.fire({
              title:'Success',
              icon:'success',
              showConfirmButton:false,
              width:'500px',
              timer:1000
            });

            setTimeout(function() {
              window.location.reload();
            }, 1200);
          }
          else {
            Swal.fire({
              title:"Error!",
              text: ts,
              icon:'error'
            });
          }
        }, 200);
      },
      error:function(xhr) {
        load_out();
        Swal.fire({
  				title:"Error!",
  				text: xhr.responseText,
  				icon:'error'
  			});
      }
    })
  }, 200);
}


function viewDetail(id) {
  $.ajax({
    url:HOME + 'get/'+id,
    type:'GET',
    cache:false,
    success:function(rs) {
      if( isJson(rs)) {
        let ds = $.parseJSON(rs);
        $('#view-name').val(ds.name);
        $('#create-at').val(ds.create_at);
        $('#create-by').val(ds.create_by);
        $('#update-at').val(ds.update_at);
        $('#update-by').val(ds.update_by);

        if(ds.status == '1') {
          $('#view-active').val('Active');
        }
        else {
          $('#view-active').val('Inactive');
        }

        showModal('view-modal');
      }
      else {
        Swal.fire({
          title:'Error!',
          text:rs,
          icon:'error'
        });
      }
    }
  });
}


function getDelete(id, name) {
  Swal.fire({
    title:'Are you sure ?',
    text:'ต้องการลบ '+ name +' หรือไม่ ?',
    icon:'warning',
    showCancelButton: true,
		confirmButtonColor: '#FA5858',
		confirmButtonText: 'ใช่, ฉันต้องการลบ',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: true
  }).then((result) => {
    if(result.isConfirmed) {
      $.ajax({
  			url:HOME + 'delete',
  			type:'POST',
  			cache:false,
  			data: {
  				'id' : id
  			},
  			success:function(rs) {
  				if(rs === 'success') {

            setTimeout(function() {
              Swal.fire({
    						title:'Deleted',
    						icon:'success',
    						timer:1000
    					});

    					setTimeout(function() {
    						goBack();
    					}, 1500);
            }, 200);

  				}
  				else {
            setTimeout(function() {
              Swal.fire({
                title:'Error!',
                text:rs,
                icon:'error'
              });
            }, 200);
  				}
  			}
  		});
    }
  });
}
