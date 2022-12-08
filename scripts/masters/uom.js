var HOME = BASE_URL + 'masters/uom/';

function goBack() {
	window.location.href = HOME;
}


function getEdit(id) {
	window.location.href = HOME + 'edit/'+id;
}


function update() {
	let id = $('#id').val();
	let code = $('#code').val();
	let name = $('#name').val();

	if(code.length == 0) {
		set_error($('#code'), $('#code-error'), "Required");
		return false;
	}
	else {
		clear_error($('#code'), $('#code-error'));
	}

	if(code.length == 0) {
		set_error($('#name'), $('#name-error'), "Required");
		return false;
	}
	else {
		clear_error($('#name'), $('#name-error'));
	}


	$.ajax({
		url:HOME + 'update',
		type:'POST',
		cache:false,
		data: {
			'id' : id,
			'code' : code,
			'name' : name
		},
		success:function(rs) {
			if(rs === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				});
			}
			else {
				swal({
					title:'Error!',
					text: rs,
					type:'error'
				});
			}
		}
	});

}


function syncData() {
	load_in();

	$.ajax({
		url:HOME + 'sync_data',
		type:'GET',
		cache:false,
		success:function(rs) {
			load_out();

			if(rs === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				});

				setTimeout(function() {
					goBack();
				}, 1200);
			}
			else {
				swal({
					title:'Error!',
					text: rs,
					type:'error'
				});
			}
		}
	});
}
