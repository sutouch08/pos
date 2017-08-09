<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access 	= validAccess($id_menu);  ?>
<?php $view		= $access['view']; ?>
<?php $add 		= $access['add']; ?>
<?php $edit 		= $access['edit']; ?>
<?php $delete		= $access['delete']; ?>
<?php if(!$view OR !$add) : ?>
<?php access_deny();  ?>
<?php else : ?>
<style>
	.error {
		border-color: #d6533d !important;
	}
</style>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-top:10px; margin-bottom:0px;'><i class='fa fa-tint'></i>&nbsp; <?php echo $page_title ? $page_title : $this->title; ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class="pull-right">
        	<button type="button" class="btn btn-success btn-sm" onClick="saveRule()"><i class="fa fa-plus"></i> บันทึก</button>
        </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
    <form id="selectForm">
<div class="tabbable">
    <ul class="nav nav-tabs" id="myTab">
    	<li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true"><i class="fa fa-info-circle"></i> เงื่อนไข</a></li>
    	<li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false"><i class="fa fa-random"></i> การกระทำ</a></li>
    </ul>
	<div class="tab-content">

		<div id="tab1" class="tab-pane fade active in">
            <div class="row">
                    <div class="col-lg-12" style="margin-bottom:10px;">
                        <label >ชื่อ</label>
                        <input type="text" class="form-control input-sm input-xxlarge" id="name" name="name" placeholder="ระบุชื่อของกฏ" autofocus />
                        <input type="hidden" id="id_rule" name="id_rule" value="" />
                    </div>
                    <div class="col-lg-12" style="margin-bottom:10px;">
                        <label >คำอธิบาย</label>
                        <textarea class="form-control input-sm input-xxlarge" id="remark" name="remark" placeholder="ระบุคำอธิบายเงื่อนไข"></textarea>
                    </div>
                    <div class="col-lg-12" style="margin-bottom:10px;">
                        <label style="display:block;">เงื่อนไข</label>
                        <select class="form-control input-sm input-large" id="conditionType" name="conditionType" style="display:inline-block;" onChange="toggle_condition_type_select()">
                            <option value="amount">ยอดเงิน</option>
                            <option value="item">สินค้า</option>
                            <option value="all">สินค้าและยอดเงิน</option>
                        </select>
                    </div>
                    <div class="col-lg-12" id="targetAmount" style="margin-bottom:10px;">
                    	<label style="display:block;">มูลค่าขั้นต่ำ</label>
                        <input type="text" class="form-control input-sm input-medium" style="display:inline-block;" id="target_amount" name="target_amount" placeholder="ระบุยอดเงินขั้นต่ำ" />
                        <span class="badge badge-transparent tooltip-info" style="display:inline;" title="" 
                        	data-original-title="กำหนดมูลค่ายอดซื้อขั้นต่ำที่จะทำให้เงื่อนไขเป็นจริง">
									<i class="ace-icon fa fa-info-circle blue bigger-130"></i>
						</span>
                    </div>
                    <div class="col-lg-12" id="condition-type-select" style="margin-bottom:10px; display:none;">
                    <hr style="margin-top:0px; margin-bottom:10px;"/>
                        <label style="display:block;">การเชื่อมโยงสินค้า</label>
                        <select class="form-control input-sm input-large" style="display:inline-block;" id="ruleType" name="ruleType" onChange="toggle_select_btn()">
                            <option value="any">ทุกรายการสินค้า</option>
                            <option value="fixed">เฉพาะสินค้า</option>
                            <option value="include">สินค้าที่ร่วมรายการ</option>
                            <option value="combine">จับคู่สินค้า</option>
                        </select>
                        <span class="badge badge-transparent tooltip-info" style="display:inline;" title="" 
                        	data-original-title="วิธีการเชื่อมโยงสินค้ากับโปรโมชั่น">
									<i class="ace-icon fa fa-info-circle blue bigger-130"></i>
						</span>
                        <div class="col-lg-12" id="targetQty" style="display:none; margin-top:10px; margin-bottom:10px;">
                    	<label style="display:block;">จำนวนขั้นต่ำ</label>
                        <input type="text" class="form-control input-sm input-medium" style="display:inline-block;" id="target_qty" name="target_qty" placeholder="ระบุจำนวนสินค้าขั้นต่ำ" value="1" />
                        <span class="badge badge-transparent tooltip-info" style="display:inline;" title="" 
                        	data-original-title="กำหนดจำนวนขั้นต่ำที่จะทำให้เงื่อนไขเป็นจริง    &nbsp; ( ในกรณีที่เงื่อนไขถูกเลือกเป็น **สินค้าและยอดเงิน** &nbsp;  จำนวนจะไม่มีผลใดๆ )">
									<i class="ace-icon fa fa-info-circle blue bigger-130"></i>
						</span>
                    </div>
                    </div>
                                                            
                    <div class="col-lg-12" id="selectBox" style="display:none;">
                    	<div class="col-lg-2">
                        	<label>เพิ่มเงื่อนไขให้กับ</label>
                            <select class="form-control input-sm" id="selectItemType">
                            	<option value="item">รายการสินค้า</option>
                                <option value="style">รุ่นสินค้า</option>
                                <option value="category">หมวดหมู่สินค้า</option>
                                <option value="brand">แบร์นสินค้า</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                        <label style="display:block; visibility:hidden">btn</label>
                    	<button type="button" class="btn btn-primary btn-xs" id="btn-select-product" onClick="insertSelectRow()"><i class="fa fa-plus"></i> เพิ่ม</button>
                        </div>
                        <div class="col-lg-12"></div>
                        <div class="col-lg-8">
                        <table class="table table-striped" style="margin-top:10px;" id="productList"></table>
                        </div>
                    </div>
                    <div class="col-lg-12">
                    	<hr style="margin-top:0px; margin-bottom:10px;"/>
                        <label style="display:block;">การใช้งาน</label>
                        <div class="control-group">
                            <div class="radio">
                            	<label><input name="applyType" type="radio" class="ace" value="bill" checked><span class="lbl"> 1 ครั้ง/ ใบเสร็จ</span></label>
                                <span class="badge badge-transparent tooltip-info" title="" data-original-title="เงื่อนไขนี้จะสามารถใช้ได้เพียง 1 ครั้ง/ 1 ใบเสร็จเท่านั้น">
									<i class="ace-icon fa fa-info-circle blue bigger-130"></i>
								</span>
                            </div>
                            <div class="radio">
                            <label><input name="applyType" type="radio" class="ace" value="step"><span class="lbl"> ตามเงื่อนไข</span></label>
                            <span class="badge badge-transparent tooltip-info" title="" data-original-title="การใช้งานจะเป็นไปตามลำดับขั้นของเงื่อนไข เช่น ทุกๆ 300 บาท หรือ ทุกๆ 2 ชิ้น ซึ่งใน 1 ใบเสร็จสามารถเกิดขึ้นได้หลายครั้ง">
									<i class="ace-icon fa fa-info-circle blue bigger-130"></i>
								</span>
                            </div>
                        </div>
                    </div>
                    
                </div> <!-- Row -->
		</div><!-- /tab1 -->
        <div id="tab2" class="tab-pane fade">
        	<div class="row">
            	<div class="col-lg-12">
                        <label style="display:block;" >การตอบแทน</label>
                        <select class="form-control input-sm input-large" id="gainType" name="gain_type" style="display:inline-block;">
                        	<option value="point">คะแนนสะสม</option>
                            <option value="coupon">คูปองส่วนลด</option>
                            <option value="discount">ส่วนลดท้ายใบเสร็จ</option>
                            <option value="item">ของแถม</option>
                            <option value="price">แลกซื้อสินค้า</option>
                        </select>
                        <button type="button" class="btn btn-primary btn-xs input-small" style="margin-top:-3px;"  onClick="insertGainRow()"><i class="fa fa-plus"></i> เพิ่ม</button>   
                        
				</div><!--/ col-lg-12 -->    
                <hr/>
                <div class="col-lg-8" >
                	<label style=" margin-top:10px; display:block;">รายการที่ให้</label>
                    <hr style="margin-top:5px; margin-bottom:5px;"/>
                	<table class="table table-striped" style="margin-top:10px; margin-bottom:0px;" id="gainList"></table>
                </div>
            </div><!-- row -->
        </div><!-- /tab2 -->
        
	</div><!--/ tabcontent -->
     <hr/>
    <button type="button" class="btn btn-success" onClick="saveAndStay()"><i class="fa fa-save"></i> บันทึกและอยู่ต่อ</button>
</div><!--/ tabable -->
 </form>
                                        
<script>
var row_id = 1;
var gain_id = 1;
$('.tooltip-info').tooltip({ 'container' : 'body' });
</script>
<?php $this->load->view('import/promotion_rule_script'); ?>

<script>

function toggle_gain_type()
{
	var type = $('#gainType').val();
	if( type == 'point' ){
		$('#couponBox').css('display', 'none');
		$('#discountBox').css('display', 'none');
		$('#itemBox').css('display', 'none');
		$('#priceBox').css('display', 'none');
		$('#pointBox').css('display', '');
	}else if( type == 'coupon' ){
		$('#discountBox').css('display', 'none');
		$('#itemBox').css('display', 'none');
		$('#priceBox').css('display', 'none');
		$('#pointBox').css('display', 'none');
		$('#couponBox').css('display', '');
	}else if( type == 'discount'){
		$('#couponBox').css('display', 'none');
		$('#itemBox').css('display', 'none');
		$('#priceBox').css('display', 'none');
		$('#pointBox').css('display', 'none');
		$('#discountBox').css('display', '');
	}else if( type == 'item'){
		$('#couponBox').css('display', 'none');
		$('#priceBox').css('display', 'none');
		$('#pointBox').css('display', 'none');
		$('#discountBox').css('display', 'none');
		$('#itemBox').css('display', '');
	}else if( type == 'price'){
		$('#couponBox').css('display', 'none');
		$('#pointBox').css('display', 'none');
		$('#discountBox').css('display', 'none');
		$('#priceBox').css('display', '');
		$('#itemBox').css('display', '');
	}		
}

function insertGainRow()
{
	// function ต่างๆที่เรียกใช้เก็บอยู่ในไฟล์ import/promotion_rule_script.php
	var type = $("#gainType").val();	
	switch(type){
		case 'point' : 
			if( $(".gain-point").length ){
				swal('คุณกำหนดคะแนนสะสมไปแล้ว');
				return false;
			}else{
				insertGainPoint();
				gain_id++;
			}
			break;
		case 'coupon' :
			if( $(".gain-coupon").length ){
				swal("คุณกำหนดคูปองส่วนลดไปแล้ว");
				return false;
			}else{
				insertGainCoupon();
				gain_id++;
			}
			break;
		case 'discount' :
			if( $(".gain-discount").length ){
				swal("คุณกำหนดส่วนลดท้ายบิลไปแล้ว");
				return false;
			}else{
				insertGainDiscount();
				gain_id++;
			}
			break;
		case 'item' :
			if( $(".gain-item").length ){
				swal("คุณเพิ่มของแถมไปแล้ว");
				return false;
			}else{
				insertGainItem();
				gain_id++;
			}
			break;
		case 'price' :
			if( $(".gain-price").length ){
				swal("คุณเพิ่มการแลกซื้อไปแล้ว");
				return false;
			}else{
				insertGainPrice();
				gain_id++;
			}
			break;
	}
	
}



function insertSelectRow()
{
	var type = $('#selectItemType').val();
	if( type == 'item' ){
		insertItemRow(row_id);
		row_id++;
	}else if( type== 'style' ){
		insertStyleRow(row_id);
		row_id++;
	}else if( type == 'category' ){
		insertCategoryRow(row_id);
		row_id++;
	}else if( type == 'brand' ){
		insertBrandRow(row_id);
		row_id++;
	}
}

function insertItemRow(id)
{
	var row = 	'<tr id="tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="type['+id+']" value="item" />'+
					'[รายการสินค้า]'+
					'</td>'+
					'<td style="width:50%;"><input type="text" class="form-control input-sm pbox" name="product['+id+']" id="item_'+id+'" /></td>'+
					'<td style="width:15%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:10%; "><input type="text" class="form-control input-sm text-center" name="qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#productList").append(row);
	$("#item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getItemCode',
		autoFocus: true,
		close: function(){
			var rs = $(this).val();
			var rs = rs.split(' | ');
			$(this).val(rs[0]);
		}
	});
}

function insertStyleRow(id)
{
	var row = 	'<tr id="tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="type['+id+']" value="style" />'+
					'[รุ่นสินค้า]'+
					'</td>'+
					'<td style="width:50%;"><input type="text" class="form-control input-sm pbox" name="product['+id+']" id="item_'+id+'" /></td>'+
					'<td style="width:15%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:10%;"><input type="text" class="form-control input-sm text-center" name="qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#productList").append(row);
	$("#item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getStyle',
		autoFocus: true
	});
}

function insertCategoryRow(id)
{
	var row = 	'<tr id="tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="type['+id+']" value="category" />'+
					'[หมวดหมู่สินค้า]'+
					'</td>'+
					'<td style="width:50%;"><input type="text" class="form-control input-sm pbox" name="product['+id+']" id="item_'+id+'" /></td>'+
					'<td style="width:15%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:10%;"><input type="text" class="form-control input-sm text-center" name="qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#productList").append(row);
	$("#item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getCategory',
		autoFocus: true
	});
}

function insertBrandRow(id)
{
	var row = 	'<tr id="tr_'+id+'" style="border:solid 1px #ccc;">'+
					'<td style="width:20%; text-align:right; vertical-align:middle;">'+
					'<input type="hidden" name="type['+id+']" value="brand" />'+
					'แบรนด์สินค้า'+
					'</td>'+
					'<td style="width:50%;"><input type="text" class="form-control input-sm pbox" name="product['+id+']" id="item_'+id+'" /></td>'+
					'<td style="width:15%; text-align:right; vertical-align:middle;">จำนวน</td>'+
					'<td style="width:10%;"><input type="text" class="form-control input-sm text-center" name="qty['+id+']" value="1" /></td>'+
					'<td align="center"><button type="button" class="btn btn-white btn-minier" onClick="removeRow('+id+')"><i class="fa fa-times"></i></button></td>'+
					'</tr>';
	$("#productList").append(row);
	$("#item_"+id).autocomplete({
		source: '<?php echo base_url(); ?>admin/tool/getBrand',
		autoFocus: true
	});
}

function removeRow(id)
{
	$("#tr_"+id).remove();	
}

function removeGainRow(id)
{
	$("#gain_tr_"+id).remove();	
}

function toggle_select_btn()
{
	var value = $("#ruleType").val();
	if( value == 'any' ){
		$('#selectBox').css('display', 'none');
		$('#targetQty').css('display', '');
	}else if( value == 'fixed' || value == 'include' || value == 'combine' ){
		$('#selectBox').css('display','block');
		$('#targetQty').css('display', 'none');
	}
}

function toggle_condition_type_select()
{
	var value = $('#conditionType').val();
	if( value == 'amount' ){
		$("#targetAmount").css('display', '');
		$('#condition-type-select').css('display', 'none');
		$('#selectBox').css('display', 'none');
	}else if( value == 'all' ){
		$("#targetAmount").css('display', '');
		$('#condition-type-select').css('display', '');
		toggle_select_btn();
	}else if( value == 'item' ){
		$("#targetAmount").css('display', 'none');
		$('#condition-type-select').css('display', '');
		toggle_select_btn();
	}
}

function saveAndStay()
{
	var id 			= $('#id_rule').val();
	var name 		= $('#name').val();
	var type 			= $('#conditionType').val();
	var ruleType 	= $('#ruleType').val();
	var amount 		= $('#target_amount').val();
	var qty 			= $('#target_qty').val();
	var count		= $("#productList tr").size();
	var g_count		= $("#gainProductList tr").size();
	if( type == 'amount' && amount == '' || type == 'amount' && amount <= 0){ swal('กรุณาระบุมูลค่าขั้นต่ำ'); return false; }
	
	if( (type == 'item' && ruleType == 'any' && qty == '') || (type == 'item' && ruleType == 'any' && qty <= 0 )){ swal('กรุณาระบุจำนวนขั้นต่ำ'); return false; }
	if( (type == 'item' || type == 'all') && ( ruleType == 'fixed' || ruleType == 'include' ) && count == 0 ){ swal('กรุณากำหนดสินค้าให้กับเงื่อนไข'); return false; }
	if( (type == 'item' || type == 'all') && ( ruleType == 'fixed' || ruleType == 'include' ) && count > 0  ){ 
		var c = 0;
		$('.pbox').each(function(index, element) {
            if( $(this).val() == '' ){
				$(this).addClass('error');
				c++;
			}else{
				$(this).removeClass('error');
			}
        });
		if( c > 0 ){
			swal('กรุณากำหนดสินค้าให้กับเงื่อนไข'); 
			return false; 
		}
	}
	if( (type == 'item' || type == 'all') && ruleType == 'combine'){
		var c = 0;
		$('.pbox').each(function(index, element) {
            if( $(this).val() == '' ){
				$(this).addClass('error');
			}else{
				$(this).removeClass('error');
				c++;
			}
        });
		if( c < 2 ){
			swal('สินค้าที่จะผูกกับเงื่อนไขต้องมีอย่างน้อย 2 รายการ'); 
			return false; 
		}
	}
	if( (type == 'all' && qty == '') || ( type == 'all' && qty <= 0 ) ){ swal('กรุณาระบุมูลค่าขั้นต่ำ'); return false; }
	
	
}
function saveRule()
{
	$.ajax({
		url: '<?php echo $this->home; ?>/saveNewRule',
		type:'POST', cache:'false', data: $("#selectForm").serializeArray()
	});
}
</script>                                        
 
          	        	
 

<?php endif; ?>