
function edit(id) {
	window.location.href = `${HOME}edit/${id}`;
}


function groupViewCheck(el, id) {
	if (el.is(":checked")) {
		$(".view-" + id).each(function (index, element) {
			$(this).prop("checked", true);
		});
	} else {
		$(".view-" + id).each(function (index, element) {
			$(this).prop("checked", false);
		});
	}
}

function groupAddCheck(el, id) {
	if (el.is(":checked")) {
		$(".add-" + id).each(function (index, element) {
			$(this).prop("checked", true);
		});
	} else {
		$(".add-" + id).each(function (index, element) {
			$(this).prop("checked", false);
		});
	}
}

function groupEditCheck(el, id) {
	if (el.is(":checked")) {
		$(".edit-" + id).each(function (index, element) {
			$(this).prop("checked", true);
		});
	} else {
		$(".edit-" + id).each(function (index, element) {
			$(this).prop("checked", false);
		});
	}
}

function groupDeleteCheck(el, id) {
	if (el.is(":checked")) {
		$(".delete-" + id).each(function (index, element) {
			$(this).prop("checked", true);
		});
	} else {
		$(".delete-" + id).each(function (index, element) {
			$(this).prop("checked", false);
		});
	}
}

function groupApproveCheck(el, id) {
	if (el.is(":checked")) {
		$(".approve-" + id).each(function (index, element) {
			$(this).prop("checked", true);
		});
	} else {
		$(".approve-" + id).each(function (index, element) {
			$(this).prop("checked", false);
		});
	}
}


function groupAllCheck(el, id) {
	var view = $("#view-group-" + id);
	var add = $("#add-group-" + id);
	var edit = $("#edit-group-" + id);
	var del = $("#delete-group-" + id);
	var ap = $('#approve-group-' + id);

	if (el.is(":checked")) {
		view.prop("checked", true);
		groupViewCheck(view, id);
		add.prop("checked", true);
		groupAddCheck(add, id);
		edit.prop("checked", true);
		groupEditCheck(edit, id);
		del.prop("checked", true);
		groupDeleteCheck(del, id);
		ap.prop("checked", true);
		groupApproveCheck(ap, id);

	} else {
		view.prop("checked", false);
		groupViewCheck(view, id);
		add.prop("checked", false);
		groupAddCheck(add, id);
		edit.prop("checked", false);
		groupEditCheck(edit, id);
		del.prop("checked", false);
		groupDeleteCheck(del, id);
		ap.prop("checked", false);
		groupApproveCheck(ap, id);

	}
}


function allCheck(el, id_tab) {
	if (el.is(":checked")) {
		$("." + id_tab).each(function (index, element) {
			$(this).prop("checked", true);
		});
	} else {
		$("." + id_tab).each(function (index, element) {
			$(this).prop("checked", false);
		});
	}
}



function setPermission() {
	let h = {
		'id' : $('#id-profile').val(),
		'menus' : []
	};

	$('.x-menu').each(function() {		
		let code = $(this).val();

		h.menus.push({
			'menu' : code,
			'view' : $(`#view-${code}`).is(':checked') ? 1 : 0,
			'add' : $(`#add-${code}`).is(':checked') ? 1 : 0,
			'edit' : $(`#edit-${code}`).is(':checked') ? 1 : 0,
			'delete' : $(`#delete-${code}`).is(':checked') ? 1 : 0,
			'approve' : $(`#approve-${code}`).is(':checked')
		});
	});

	load_in();
	
	$.ajax({
		url:`${HOME}set_permission`,
		type:'POST',
		cache:false,
		data:{
			'data' : JSON.stringify(h)
		},
		success:function(rs) {
			load_out();

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
	})	
}
