$('#sub-district').autocomplete({
	source: `${BASE_URL}auto_complete/sub_district`,
	autoFocus: true,
	open: function (event) {
		let $ul = $(this).autocomplete('widget');
		$ul.css('width', 'auto');
	},
	close: function () {
		let rs = $.trim($(this).val());
		let adr = rs.split('>>');
		if (adr.length == 4) {
			$('#sub-district').val(adr[0]);
			$('#district').val(adr[1]);
			$('#province').val(adr[2]);
			$('#postcode').val(adr[3]);
		}
	}
});


$('#district').autocomplete({
	source: `${BASE_URL}auto_complete/district`,
	autoFocus: true,
	open: function (event) {
		let $ul = $(this).autocomplete('widget');
		$ul.css('width', 'auto');
	},
	close: function () {
		let rs = $.trim($(this).val());
		let adr = rs.split('>>');
		if (adr.length == 3) {
			$('#district').val(adr[0]);
			$('#province').val(adr[1]);
			$('#postcode').val(adr[2]);
		}
	}
});


$('#province').autocomplete({
	source: `${BASE_URL}auto_complete/province`,
	autoFocus: true,
	open: function (event) {
		let $ul = $(this).autocomplete('widget');
		$ul.css('width', 'auto');
	},
	close: function () {
		let rs = $.trim($(this).val());
		let adr = rs.split('>>');
		if (adr.length == 2) {
			$('#province').val(adr[0]);
			$('#postcode').val(adr[1]);
		}
	}
});


function clearFields() {
	clearErrorByClass('ad');
	$('.ad').val('').removeAttr('disabled');
	$('#address-id').val('');
	$('#branch-code').val('00000');
	$('#branch-name').val('สำนักงานใหญ่');
	$('#save-btn').removeClass('hide');
	$('#cancel-btn').removeClass('hide');
}


function newAddress(addressType) {
	const title = addressType === 'S' ? 'Ship To Address' : 'Bill To Address';
	clearFields();
	$('#address-type').val(addressType);
	$('#address-title').text(title);
	$('#address-panel').removeClass('not-show');
	$('#alias').focus();
}


function editAddress(id) {
	clearFields();
	const data = JSON.parse($(`#address-data-${id}`).val());
	const title = data.addressType === 'S' ? 'Ship To Address' : 'Bill To Address';
	console.log(data);
	$('#address-type').val(data.addressType);
	$('#address-id').val(data.id);
	$('#alias').val(data.alias);
	$('#consignee').val(data.name);
	$('#branch-code').val(data.branchCode);
	$('#branch-name').val(data.branchName);
	$('#address').val(data.address);
	$('#sub-district').val(data.subDistrict);
	$('#district').val(data.district);
	$('#province').val(data.province);
	$('#postcode').val(data.postcode);
	$('#phone').val(data.phone);
	$('#address-title').text(title);
	$('#address-panel').removeClass('not-show');
	$('#alias').focus();

}


function viewAddress(id) {
	clearFields();
	const data = JSON.parse($(`#address-data-${id}`).val());
	const title = data.addressType === 'S' ? 'Ship To Address' : 'Bill To Address';
	console.log(data);
	$('#address-type').val(data.addressType);
	$('#address-id').val(data.id);
	$('#alias').val(data.alias).attr('disabled', 'disabled');
	$('#consignee').val(data.name).attr('disabled', 'disabled');
	$('#branch-code').val(data.branchCode).attr('disabled', 'disabled');
	$('#branch-name').val(data.branchName).attr('disabled', 'disabled');
	$('#address').val(data.address).attr('disabled', 'disabled');
	$('#sub-district').val(data.subDistrict).attr('disabled', 'disabled');
	$('#district').val(data.district).attr('disabled', 'disabled');
	$('#province').val(data.province).attr('disabled', 'disabled');
	$('#postcode').val(data.postcode).attr('disabled', 'disabled');
	$('#phone').val(data.phone).attr('disabled', 'disabled');
	$('#address-title').text(title);
	$('#save-btn').addClass('hide');
	$('#cancel-btn').addClass('hide');
	$('#address-panel').removeClass('not-show');
}


function saveAddress() {
	if (click !== 0) {
		return false;
	}

	click = 1;

	clearErrorByClass('ad');
	const inputAlias = document.getElementById('alias');
	const aliasError = document.getElementById('alias-error');
	const inputName = document.getElementById('consignee');
	const nameError = document.getElementById('consignee-error');
	const inputAddress = document.getElementById('address');
	const addressError = document.getElementById('address-error');

	let data = {
		id: $('#address-id').val(),
		addressType: $('#address-type').val(),
		customerCode: $('#customer-code').val(),
		alias: $('#alias').val().trim(),
		name: $('#consignee').val().trim(),
		branchCode: $('#branch-code').val().trim(),
		branchName: $('#branch-name').val().trim(),
		address: $('#address').val().trim(),
		subDistrict: $('#sub-district').val().trim(),
		district: $('#district').val().trim(),
		province: $('#province').val().trim(),
		postcode: $('#postcode').val().trim(),
		phone: $('#phone').val().trim()
	};

	if (data.alias.length === 0) {
		setError(inputAlias, aliasError, 'กรุณาระบุชื่อเรียก');
		click = 0;
		return false;
	}

	if (data.name.length === 0) {
		setError(inputName, nameError, 'กรุณาระบุชื่อผู้รับ');
		click = 0;
		return false;
	}

	if (data.address.length === 0) {
		setError(inputAddress, addressError, 'กรุณาระบุที่อยู่');
		click = 0;
		return false;
	}

	if (data.id === '') {
		addAddress(data);
	}
	else {
		updateAddress(data);
	}
}


async function addAddress(data) {
	const url = `${HOME}add_address`;

	loadIn();

	try {
		const response = await fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(data)
		});
		const result = await response.json();

		if (result.status === 'success') {
			const template = $('#address-template').html();
			const output = result.data.type === 'S' ? $('#ship-to-list') : $('#bill-to-list');
			result.data.data = JSON.stringify(result.data);
			renderAppend(template, result.data, output);
			if (data.addressType === 'S') {
				$('#no-ship-to').remove();
			}
			else {
				$('#no-bill-to').remove();
			}

			setTimeout(() => {
				swal({
					title: 'Added',
					text: 'เพิ่มที่อยู่เรียบร้อยแล้ว',
					type: 'success',
					timer: 1000
				});

				clearFields();
			}, 500);
		}
		else {
			showError(result.message);
		}
	}
	catch (err) {
		console.log(err);
		showError('เกิดข้อผิดพลาดในการเพิ่มที่อยู่');
	}
	finally {
		setTimeout(() => {
			loadOut();
		}, 500);

		click = 0;
	}
}


async function updateAddress(data) {
	const url = `${HOME}update_address`;
	loadIn();
	try {
		const response = await fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(data)
		});
		const result = await response.json();
		if (result.status === 'success') {
			const id = data.id;
			const template = $('#address-update-template').html();
			const output = $('#address-' + id);
			result.data.data = JSON.stringify(result.data);
			render(template, result.data, output);
			setTimeout(() => {
				swal({
					title: 'Updated',
					text: 'แก้ไขที่อยู่เรียบร้อยแล้ว',
					type: 'success',
					timer: 1000
				});

				clearFields();
			}, 500);
		}
		else {
			showError(result.message);
		}
	}
	catch (err) {
		console.log(err);
		showError('เกิดข้อผิดพลาดในการแก้ไขที่อยู่');
	}
	finally {
		setTimeout(() => {
			loadOut();
		}, 500);

		click = 0;
	}
}


function confirmDelete(id, alias) {
	swal({
		title: 'Are you sure?',
		text: `คุณต้องการลบที่อยู่ "${alias}" หรือไม่?`,
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#333',
		confirmButtonText: 'ลบ',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: true
	}, function () {
		deleteAddress(id);
	});
}


async function deleteAddress(id) {
	const url = `${HOME}delete_address`;
	const formData = new FormData();
	formData.append('id', id);
	loadIn();
	try {
		const response = await fetch(url, {
			method: 'POST',			
			body: formData
		});

		const result = await response.text();

		if(result.trim() === 'success') {
				$(`#address-${id}`).remove();
				setTimeout(() => 
				swal({
					title: 'Deleted',
					text: 'ลบที่อยู่เรียบร้อยแล้ว',
					type: 'success',
					timer: 1000
				}), 500);
		}
		else {
			showError(result);
		}		
	}
	catch (err) {
		console.log(err);
		showError('เกิดข้อผิดพลาดในการลบที่อยู่');
	}
	finally {
		setTimeout(() => {
			loadOut();
		}, 500);		
	}
}





