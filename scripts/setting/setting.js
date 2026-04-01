var wms_warehouse = "";
var HOME = BASE_URL + 'setting/configs/';

function updateConfig(formName)
{
	loadIn();

	var formData = $("#"+formName).serialize();

	$.ajax({
		url: BASE_URL + "setting/configs/update_config",
		type:"POST",
		cache:"false",
		data: formData,
		success: function(rs) {
			setTimeout(() => {
				loadOut();

				if(rs.trim() == 'success') {
					setTimeout(() => {
						swal({
							title:'Updated',
							type:'success',
							timer:1000
						});
					}, 100)
				}
				else {
					showError(rs);
				}
			}, 500);			
		},
		error:function(rs) {
			showError(rs);
		}
	});	
}


function checkCompanySetting(){
	vat = parseFloat($('#VAT').val());
	year = parseInt($('#startYear').val());

	if(isNaN(year)){
		swal('ปีที่เริ่มต้นกิจการไม่ถูกต้อง');
		return false;
	}

	if(year < 1970){
		swal('ปีที่เริ่มต้นกิจการไม่ถูกต้อง');
		return false;
	}

	if(year > 2100){
		year = year - 543;
		$('#startYear').val(year);
	}


	updateConfig('companyForm');
}


$('#default-warehouse').select2();


function changeURL(tab)
{
	var url = HOME + 'index/'+ tab;
	var stObj = { stage: 'stage' };
	window.history.pushState(stObj, 'setting', url);
}
