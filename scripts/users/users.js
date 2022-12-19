var validUname = true;
var validDname = true;
var validPm = true;
var validPwd = true;


function closeModal() {
  $('#user-modal').modal('hide');
}

function closeResetModal() {
  $('#pwd-modal').modal('hide');
}


function addNew() {
  $('#modal-title').text('New User');
  $('#user_id').val('');
  $('.err-label').text('');
  $('.add').val('');
  $('.has-error').removeClass('has-error');
  $('#active').prop('checked', true);
  $('.add').removeAttr('disabled');
  $('.edit').removeClass('hide');
  $('#btn-update').addClass('hide');
  $('#user-modal').modal('show');
}



function goBack() {
  window.location.href = HOME;
}


function getEdit(id) {
  load_in();

  $.ajax({
    url:HOME + 'view_detail',
    type:'GET',
    cache:false,
    data: {
      'id' : id
    },
    success:function(rs) {
      load_out();

      if(isJson(rs)) {
        let ds = $.parseJSON(rs);
        $('#modal-title').text('Edit User');
        $('#user_id').val(ds.id);
        $('#uname').val(ds.uname);
        $('#dname').val(ds.name);
        $('#emp_id').val(ds.emp_id);
        $('#sale_id').val(ds.sale_id);
        $('#group_id').val(ds.group_id);

        if(ds.active == 0) {
          $('#active').prop('checked', false);
        }
        else {
          $('#active').prop('checked', true);
        }

        $('.add').removeAttr('disabled');
        $('.edit').addClass('hide');
        $('#uname').attr('disabled', 'disabled');
        $('#btn-update').removeClass('hide');

        $('#user-modal').modal('show');
      }
      else {
        Swal.fire({
          title:'Error!',
          text:rs,
          icon:'error'
        });
      }
    }
  })
}


function viewDetail(id) {
  $('#modal-title').text('User Data');
  $.ajax({
    url:HOME + 'view_detail',
    type:'GET',
    cache:false,
    data: {
      'id' : id
    },
    success:function(rs) {
      if(isJson(rs)) {
        let ds = $.parseJSON(rs);
        $('#user_id').val(ds.id);
        $('#uname').val(ds.uname);
        $('#dname').val(ds.name);
        $('#emp_id').val(ds.emp_id);
        $('#sale_id').val(ds.sale_id);
        $('#group_id').val(ds.group_id);

        if(ds.active == 0) {
          $('#active').prop('checked', false);
        }
        else {
          $('#active').prop('checked', true);
        }

        $('.add').attr('disabled', 'disabled');
        $('.edit').addClass('hide');

        $('#user-modal').modal('show');
      }
      else {
        Swal.fire({
          title:'Error!',
          text:rs,
          icon:'Error'
        });
      }
    }
  });
}


function getReset(id) {

  $.ajax({
    url:HOME + 'view_detail',
    type:'GET',
    cache:false,
    data: {
      'id' : id
    },
    success:function(rs) {
      if(isJson(rs)) {
        let ds = $.parseJSON(rs);
        $('#x-id').val(id);
        $('#x-uname').val(ds.uname);
        $('#x-dname').val(ds.name);
        $('#pwd-modal').modal('show');
      }
      else {
        Swal.fire({
          title : 'Error!',
          text:rs,
          icon:'error'
        });
      }
    }
  });
}


function saveAdd() {
	validUserName();
	validDisplayName();
	validUserGroup();
	validPWD();

	if( !validUname || !validDname || !validPm || !validPwd ) {
		return false;
	}

	let uname = $('#uname').val();
	let dname = $('#dname').val();
	let sale_id = $('#sale_id').val();
	let emp_id = $('#emp_id').val();
	let team_id = $('#team_id').val();
	let pwd = $('#pwd').val();
	let group_id = $('#group_id').val();
	let active = $('#active').is(':checked') ? 1 : 0;
	let force_reset = $('#force_reset').is(':checked') ? 1 : 0;

  $('#user-modal').modal('hide');

	load_in();

	$.ajax({
		url:HOME + 'add',
		type:'POST',
		cache:false,
		data:{
			'uname' : uname,
			'dname' : dname,
			'sale_id' : sale_id,
			'team_id' : team_id,
			'pwd' : pwd,
			'group_id' : group_id,
			'active' : active,
			'force_reset' : force_reset
		},
		success:function(rs) {
			load_out();

			rs = $.trim(rs);

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
}



function update() {
	validDisplayName();
	validUserGroup();

	if( !validDname || !validPm ) {
		return false;
	}

	const id = $('#user_id').val();
	const dname = $('#dname').val();
	const sale_id = $('#sale_id').val();
	const emp_id = $('#emp_id').val();
	const team_id = $('#team_id').val();
	const group_id = $('#group_id').val();
	const active = $('#active').is(':checked') ? 1 : 0;

  closeModal();

  setTimeout(function() {
    load_in();

  	$.ajax({
  		url:HOME + 'update',
  		type:'POST',
  		cache:false,
  		data:{
  			'id' : id,
  			'dname' : dname,
  			'sale_id' : sale_id,
  			'emp_id' : emp_id,
  			'team_id' : team_id,
  			'group_id' : group_id,
  			'active' : active
  		},
  		success:function(rs) {
  			load_out();

  			rs = $.trim(rs);

  			if(rs === 'success') {
  				Swal.fire({
  					title:'Success',
  					icon:'success',
  					timer:1000
  				});

          setTimeout(function() {
            window.location.reload();
          }, 1200);
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
  				icon:'error',
  				html:true
  			});
  		}
  	});
  }, 500);

}



function changePassword()
{
	validxPWD();

	if( ! validPwd) {
		return false;
	}

	const id = $('#x-id').val();
	const pwd = $('#x-pwd').val();
	const force = $('#x-force_reset').is(':checked') ? 1 : 0;

  $('#pwd-modal').modal('hide');

	$.ajax({
		url:HOME + 'change_pwd',
		type:'POST',
		cache:false,
		data:{
			'id' : id,
			'pwd' : pwd,
			'force_reset' : force
		},
		success:function(rs) {
			rs = $.trim(rs);
			if(rs === 'success') {
        setTimeout(function() {
          Swal.fire({
            title:'Success',
            icon:'success',
            showConfirmButton:false,
            timer:1000
          });
        }, 200);
			}
			else {
        setTimeout(function() {
          Swal.fire({
            title:'Error!',
            text: rs,
            icon:'error'
          });
        }, 200);
			}
		}
	});
}



function getDelete(id, uname) {
  Swal.fire({
    title:'Are you sure ?',
    text:'ต้องการลบ '+ uname +' หรือไม่ ?',
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



function validatePassword(input)
{
	if(USE_STRONG_PWD == 1) {
		var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;

		if(input.match(passw))
		{
			return true;
		}

		return false;
	}

	return true;
}



function validPWD() {
  var pwd = $('#pwd').val();
  var cmp = $('#cm-pwd').val();
  if(pwd.length > 0) {

		if(!validatePassword(pwd)) {
			$('#pwd-error').text('รหัสผ่านต้องมีความยาว 8 - 20 ตัวอักษร และต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก พิมพ์ใหญ่ และตัวเลขอย่างน้อย อย่างละตัว');
      $('#pwd').addClass('has-error');
			validPwd = false;
      return false;
		}
		else {
			$('#pwd-error').text('');
			$('#pwd').removeClass('has-error');
			validPwd = true;
		}

    if(pwd != cmp) {
      $('#cm-pwd-error').text('Password missmatch!');
      $('#cm-pwd').addClass('has-error');
      validPwd = false;
			return false;
    }
		else {
      $('#cm-pwd-error').text('');
      $('#cm-pwd').removeClass('has-error');
      validPwd = true;
    }
  }
	else {
    $('#pwd-error').text('Password is required!');
    $('#pwd').addClass('has-error');
    validPwd = false;
  }
}

function validxPWD() {
  var pwd = $('#x-pwd').val();
  var cmp = $('#x-cm-pwd').val();
  if(pwd.length > 0) {

		if(!validatePassword(pwd)) {
			$('#x-pwd-error').text('รหัสผ่านต้องมีความยาว 8 - 20 ตัวอักษร และต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก พิมพ์ใหญ่ และตัวเลขอย่างน้อย อย่างละตัว');
      $('#x-pwd').addClass('has-error');
			validPwd = false;
      return false;
		}
		else {
			$('#x-pwd-error').text('');
			$('#x-pwd').removeClass('has-error');
			validPwd = true;
		}

    if(pwd != cmp) {
      $('#x-cm-pwd-error').text('Password missmatch!');
      $('#x-cm-pwd').addClass('has-error');
      validPwd = false;
			return false;
    }
		else {
      $('#x-cm-pwd-error').text('');
      $('#x-cm-pwd').removeClass('has-error');
      validPwd = true;
    }
  }
	else {
    $('#x-pwd-error').text('Password is required!');
    $('#x-pwd').addClass('has-error');
    validPwd = false;
  }
}





function validUserName() {
  let uname = $('#uname').val();
  let id = $('#user_id').val();

  if(uname.length > 0) {
		$.ajax({
			url:HOME + 'valid_uname',
			type:'GET',
			cache:false,
			data:{
				'id' : id,
				'uname' : uname
			},
			success:function(rs) {
				rs = $.trim(rs);
        if(rs === 'exists') {
          $('#uname-error').text('User name already exists!');
          $('#uname').addClass('has-error');
          validUname = false;
        }
				else {
          $('#uname-error').text('');
          $('#uname').removeClass('has-error');
          validUname = true;
        }
			}
		});
  }
	else {
    $('#uname-error').text('User name is required!');
    $('#uname').addClass('has-error');
    validUname = false;
  }
}



function validDisplayName() {
  var dname = $('#dname').val();
  var id = $('#user_id').val();
  if(dname.length > 0){
    $.ajax({
			url:HOME + 'valid_dname',
			type:'GET',
			cache:false,
			data:{
				'id' : id,
				'dname' : dname
			},
			success:function(rs) {
				var rs = $.trim(rs);
				if(rs === 'exists'){
	        $('#dname-error').text('Display name already exists!');
	        $('#dname').addClass('has-error');
	        validDname = false;
	      }
				else {
	        $('#dname-error').text('');
	        $('#dname').removeClass('has-error');
	        validDname = true;
	      }
			}
		});
  }
	else {
    $('#dname-error').text('Display name is required!');
    $('#dname').addClass('has-error');
    validDname = false;
  }
}



function validUserGroup() {
	const el = $('#group_id');
	const label = $('#group-error');

	if(el.val() == "") {
		set_error(el, label, "User group is required !");
		validPm = false;
	}
	else {
		clear_error(el, label);
		validPm = true;
	}
}



$('#dname').focusout(function(){
  validDisplayName();
});


$('#uname').focusout(function(){
  validUserName();
});

$('#group_id').focusout(function() {
	validUserGroup();
});

$('#pwd').focusout(function(){
  validPWD();
});


$('#cm-pwd').keyup(function(e){
  validPWD();
});

$('#cm-pwd').focusout(function(){
  validPWD();
});


$('#x-pwd').focusout(function(){
  validxPWD();
});


$('#x-cm-pwd').keyup(function(e){
  validxPWD();
});

$('#x-cm-pwd').focusout(function(){
  validxPWD();
});
