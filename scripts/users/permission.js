//---- profile
let click = 0;

function addNew() {
	$('#profile-error').html('&nbsp;');
	$('#profile-name').val('');
	$('#profile-uid').val('');
	$('#profile-mode').val('add');
	$('#profileModal').modal('show');
	$('#profileModal').on('shown.bs.modal', function() {
		$('#profile-name').focus();
	});
}


function save() {
	if(click != 0) {
		return false;
	}

	click = 1;
	const label = $('#profile-error');
	label.html('&nbsp;');
	const name = $('#profile-name').val().trim();
	const mode = $('#profile-mode').val();
	const uid = $('#profile-uid').val();

	if(name.length == 0) {
		label.text('Profile name is required');
		click = 0;
		return false;
	}

	if(mode == 'edit' && uid.length == 0) {
		label.text('Missing profile uid');
		click = 0;
		return false;
	}

	$.ajax({
		url:`${HOME}is_exists_profile`,
		type:'POST',
		cache:false,
		data:{
			'name': name,
			'uid' : uid
		},
		success:function(rs) {
			if(rs.trim() === 'exists') {
				label.text(`${name} already exists, please try different name`);
				click = 0;
			}
			else {
				if (mode === 'edit') {
					update();
				}
				else {
					add();
				}
			}
		},
		error:function(rs) {
			click = 0;
			showError(rs);
		}
	});	
}


function add() {
	const name = $('#profile-name').val().trim();	
	const url = `${HOME}add`;
	click = 0;
	closeModal('profileModal');
		
	$.ajax({
		url:url,
		type:'POST',
		cache:false,
		data:{
			'name' : name,
			'uid' : ''
		},
		success:function(rs) {
			if(isJson(rs)) {
				const ds = JSON.parse(rs);

				if(ds.status === 'success') {
					const source = $('#add-row-template').html();
					const data = ds.data;
					const output = $('#list-table');

					renderPrepend(source, data, output);
					reIndex();

					swal({
						title:'Success',
						type:'success',
						timer:1000
					});
				}
				else {
					showError(ds.message);
				}
			}
			else {				
				showError(rs);
			}
		},
		error:function(rs) {			
			showError(rs);
		}
	});
}


function editProfile(uid) {
	$.ajax({
		url:`${HOME}get/${uid}`,
		type:'GET',
		cache:false,
		success:function(rs) {
			if(isJson(rs)) {
				const ds = JSON.parse(rs);

				if(ds.status === 'success') {
					$(`#profile-uid`).val(uid);
					$(`#profile-mode`).val('edit');
					$(`#profile-name`).val(ds.data.name);
					$(`#profile-error`).html('&nbsp;');

					$(`#profileModal`).modal('show');
				}
				else {
					showError(ds.message);
				}
			}
			else {
				showError(rs);
			}
		},
		error:function(rs) {
			showError(rs);
		}
	})
}


function update() {
	const name = $('#profile-name').val().trim();
	const uid = $('#profile-uid').val();
	const url = `${HOME}update`;
	click = 0;
	closeModal('profileModal');
	
	$.ajax({
		url:url,
		type:'POST',
		cache:false,
		data:{
			'name' : name,
			'uid' : uid
		},
		success:function(rs) {
			if(isJson(rs)) {
				const ds = JSON.parse(rs);

				if(ds.status === 'success') {
					$(`#profile-${uid}`).text(name);					
				}
				else {
					showError(ds.message);
				}
			}
			else {
				showError(rs);
			}
		},
		error:function(rs) {
			click = 0;
			showError(rs);
		}
	});
}

function deleteProfile(uid, name) {
	swal({
		title:'Are you sure ?',
		text:`Do you want to delete ${name} ?`,
		type:'warning',
		showCancelButton:true,
		confirmButtonColor:'#d33',
		confirmButtonText:'Yes, I want to delete',
		cancelButtonText:'No, cancel',
		closeOnConfirm:true
	}, function(){
		loadIn();
		setTimeout(() => {
			$.ajax({
				url:`${HOME}delete`,
				type:'POST',
				cache:false,
				data:{
					'uid' : uid
				},
				success:function(rs) {
					loadOut();
					if(rs.trim() === 'success') {
						swal({
							title:'Deleted',
							type:'success',
							timer:1000
						});
						
						$(`#row-${uid}`).remove();
						reIndex();
					}
				},
				error:function(rs) {
					showError(rs);
				}
			});
		}, 100);
	})
}

//---------------- End profile -------------//

//--------------- Permission ----------------//
function editPermission(uid) {
	window.location.href = `${HOME}edit_permission/${uid}`;
}

function toggleCollapseAll() {
	const btn = $('#btn-toggle-collapse');	
	const isCollapsed = btn.data('collapse');
	
	//-- collapse all
	if(isCollapsed === false) {		
		$('#accordion .panel-collapse').collapse('hide');
		btn.data('collapse', true);
		btn.html('<i class="fa fa-plus"></i>&nbsp;&nbsp;Expand All');
	}

	//-- expand all
	if(isCollapsed === true) {		
		$('#accordion .panel-collapse').collapse('show');
		btn.data('collapse', false);
		btn.html('<i class="fa fa-minus"></i>&nbsp;&nbsp;Collapse All');
	}
}

function groupCheck(type, group) {
	const checked = $(`#${type}-group-${group}`).is(':checked') ? true : false;
	$(`.${type}-${group}`).prop('checked', checked);	
}

function groupCheckAll(group) {
	const checked = $(`#all-group-${group}`).is(':checked') ? true : false;
	$(`#view-group-${group}`).prop('checked', checked);
	$(`#add-group-${group}`).prop('checked', checked);
	$(`#edit-group-${group}`).prop('checked', checked);
	$(`#delete-group-${group}`).prop('checked', checked);
	$(`#approve-group-${group}`).prop('checked', checked);
	$(`.all-${group}`).prop('checked', checked).change();
}

function rowCheck(code) {
	const checked = $(`#all-${code}`).is(':checked') ? true : false;	
	$(`.${code}`).prop('checked', checked);
}


function setPermission(uid) {	
	if($('.pm-row').length) {
		let h = {
			'uid': uid,
			'permissions': []
		};

		$('.pm-row').each(function() {
			const code = $(this).data('code');
			h.permissions.push({
				'menu' : code,
				'view' : $(`#view-${code}`).is(':checked') ? 1 : 0,
				'add' : $(`#add-${code}`).is(':checked') ? 1 : 0,
				'edit' : $(`#edit-${code}`).is(':checked') ? 1 : 0,
				'delete' : $(`#delete-${code}`).is(':checked') ? 1 : 0,
				'approve' : $(`#approve-${code}`).is(':checked') ? 1 : 0
			});
		});

		loadIn();

		$.ajax({
			url:`${HOME}set_permission`,
			type:'POST',
			cache:false,
			data:{
				'data' : JSON.stringify(h)
			},
			success:function(rs) {
				loadOut();

				if(rs.trim() === 'success') {
					swal({
						title:'Success',
						type:'success',
						timer:1000
					});
				}
				else {
					showError(rs);
				}
			},
			error:function(rs) {
				showError(rs);
			}
		});
	}
}


function viewPermission(uid) {
	const url = `${HOME}view_permission/${uid}?nomenu&nonavbar`;
	const width = 900;
	const height = 800;
	const left = (screen.width - width) / 2;
	const top = (screen.height - height) / 2;
	window.open(url, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
}
