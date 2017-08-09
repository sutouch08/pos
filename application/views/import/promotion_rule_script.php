<script>

/**************** Gain Rule *****************/
function insertGainPoint()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" class="gain-point" name="gain_item_type['+id+']" value="point" />'+
					'[คะแนนสะสม]'+
					'</td>'+
					'<td><input type="text" class="input-small input-sm text-center" name="gain_qty['+id+']" value="1" />  คะแนน</td>'+
					'<td align="center" style="width:5%;"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainList").append(row);
}

function insertGainCoupon()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" class="gain-coupon" name="gain_item_type['+id+']" value="coupon" />'+
					'[คูปองส่วนลด]'+
					'</td>'+
					'<td><input type="text" class="input-small input-sm text-center" name="gain_qty['+id+']" value="1" />'+
					' <select class="input-small" ><option value="amount">บาท</option><option value="percent">เปอร์เซ็น</option></select></td>'+
					'<td align="center" style="width:5%;"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainList").append(row);
}

function insertGainDiscount()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" class="gain-discount" name="gain_item_type['+id+']" value="discount" />'+
					'[ส่วนลดท้ายใบเสร็จ]'+
					'</td>'+
					'<td><input type="text" class="input-small input-sm text-center" name="gain_qty['+id+']" value="1" />'+
					' <select class="input-small" ><option value="amount">บาท</option><option value="percent">เปอร์เซ็น</option></select></td>'+
					'<td align="center" style="width:5%;"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainList").append(row);
}

function insertGainItem()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right;">'+
					'<input type="hidden" class="gain-item" name="gain_item_type['+id+']" value="item" />'+
					'[แถมสินค้าต่อไปนี้]'+
					'</td>'+
					'<td colspan="2">'+
					'<select class="input-medium" id="selectGainItemType">'+
						'<option value="item">รายการสินค้า</option>'+
						'<option value="style">รุ่นสินค้า</option>'+
						'<option value="category">หมวดหมู่สินค้า</option>'+
						'<option value="brand">แบร์นสินค้า</option>'+
					'</select>'+
					'<button type="button" class="btn btn-primary btn-xs input-small" style="margin-top:-3px; margin-left:10px;"  onClick="insertGainItemRows()"><i class="fa fa-plus"></i> เพิ่ม</button> '+
					'<button type="button" class="btn btn-white btn-minier pull-right" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button>'+
					'<table class="table table-striped" style="margin-top:10px;" id="gainProductList"></table>'+
					
					'</td>'+
					'</tr>';
	$("#gainList").append(row);
}

function insertGainPrice()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right;">'+
					'<input type="hidden" class="gain-price" name="gain_item_type['+id+']" value="price" />'+
					'[ซื้อสินค้าต่อไปนี้]'+
					'</td>'+
					'<td colspan="2">'+
					'<select class="input-medium" id="selectGainPriceType">'+
						'<option value="item">รายการสินค้า</option>'+
						'<option value="style">รุ่นสินค้า</option>'+
						'<option value="category">หมวดหมู่สินค้า</option>'+
						'<option value="brand">แบร์นสินค้า</option>'+
					'</select>'+
					'<button type="button" class="btn btn-primary btn-xs input-small" style="margin-top:-3px; margin-left:10px;"  onClick="insertGainPriceRows()"><i class="fa fa-plus"></i> เพิ่ม</button> '+
					'<button type="button" class="btn btn-white btn-minier pull-right" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button>'+
					'<table class="table table-striped" style="margin-top:10px;" id="gainPriceList"></table>'+
					
					'</td>'+
					'</tr>';
	$("#gainList").append(row);
}

function insertGainPriceRows()
{
	var type = $('#selectGainPriceType').val();
	if( type == 'item' ){
		insertGainPriceItemRow();
		gain_id++;
	}else if( type == 'style' ){
		insertGainPriceStyleRow();
		gain_id++;
	}else if( type == 'category'){
		insertGainPriceCategoryRow();
		gain_id++;
	}else if( type == 'brand' ){
		insertGainPriceBrandRow();
		gain_id++;
	}
}

function insertGainItemRows()
{
	var type = $('#selectGainItemType').val();
	if( type == 'item' ){
		insertGainItemRow();
		gain_id++;
	}else if( type == 'style' ){
		insertGainStyleRow();
		gain_id++;
	}else if( type == 'category'){
		insertGainCategoryRow();
		gain_id++;
	}else if( type == 'brand' ){
		insertGainBrandRow();
		gain_id++;
	}
}


function insertGainItemRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_item_type['+id+']" value="item" />'+
					'[รายการสินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_item_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainProductList").append(row);
	$("#gain_item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getItemCode',
		autoFocus: true,
		close: function(){
			var rs = $(this).val();
			var rs = rs.split(' | ');
			$(this).val(rs[0]);
		}
	});
}

function insertGainStyleRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_item_type['+id+']" value="style" />'+
					'[รุ่นสินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_item_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainProductList").append(row);
	$("#gain_item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getStyle',
		autoFocus: true
	});
}

function insertGainCategoryRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_item_type['+id+']" value="category" />'+
					'[หมวดหมู่สินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_item_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainProductList").append(row);
	$("#gain_item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getCategory',
		autoFocus: true
	});
}

function insertGainBrandRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_item_type['+id+']" value="brand" />'+
					'[แบรนด์สินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_item_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainProductList").append(row);
	$("#gain_item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getBrand',
		autoFocus: true
	});
}


function insertGainPriceItemRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_price_type['+id+']" value="item" />'+
					'[รายการสินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_price_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">ราคา</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainPriceList").append(row);
	$("#gain_price_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getItemCode',
		autoFocus: true,
		close: function(){
			var rs = $(this).val();
			var rs = rs.split(' | ');
			$(this).val(rs[0]);
		}
	});
}

function insertGainPriceStyleRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_price_type['+id+']" value="style" />'+
					'[รุ่นสินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_price_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">ราคา</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainPriceList").append(row);
	$("#gain_price_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getStyle',
		autoFocus: true
	});
}

function insertGainPriceCategoryRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_price_type['+id+']" value="category" />'+
					'[หมวดหมู่สินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_price_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">ราคา</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainPriceList").append(row);
	$("#gain_price_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getCategory',
		autoFocus: true
	});
}

function insertGainPriceBrandRow()
{
	var id = gain_id;
	var row = 	'<tr id="gain_tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:25%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="gain_price_type['+id+']" value="brand" />'+
					'[แบรนด์สินค้า]'+
					'</td>'+
					'<td style="width:40%;"><input type="text" class="form-control input-sm" name="gain_product['+id+']" id="gain_price_'+id+'" /></td>'+
					'<td style="width:10%; text-align:right; vertical-align:middle;">ราคา</td>'+
					'<td style="width:15%; "><input type="text" class="form-control input-sm text-center" name="gain_qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeGainRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#gainPriceList").append(row);
	$("#gain_price_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getBrand',
		autoFocus: true
	});
}



</script>