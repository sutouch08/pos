<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<?php if(isset($order)) : ?>
<?php   foreach($order as $rs) : ?>
<div class="row">

<input type="hidden" id="id_user" name="id_user" value="<?php echo $this->session->userdata("id_user"); ?>" />
<input type="hidden" id="id_order" name="id_order" value="<?php echo $rs->id_order; ?>"  />
<div class="col-lg-9">
	<!-- #section:custom/widget-box -->
	<div class="widget-box ">
		<div class="widget-header widget-header-large" style="padding: 15px;">	
        	<div class="row" style="margin-top:10px;">
        		<div class="col-lg-4">
                	<div class="input-group">
                	<span class="input-group-addon" style="padding-left:5px; padding-right:5px;">ส่วนลด</span>
                    <input type="text" class="form-control input-sm" value="0.00" id="discount_percent" name="discount_percent" style="text-align:center;" />
                    <span class="input-group-addon" style="padding-left:5px; padding-right:5px;">%</span>
                    <input type="text" class="form-control input-sm" value="0.00" id="discount_amount" name="discount_amount" style="text-align:center;" />
                    <span class="input-group-addon" style="padding-left:5px; padding-right:5px;">฿</span>                    
                	</div>
                </div>
                
                <div class="col-lg-3">
                    <div class="input-group">
                    	<span class="input-group-addon" style="padding-left:5px; padding-right:5px;">จำนวน</span>
                    	<input class="input-sm spinbox-input form-control text-center" id="qty" name="qty" type="text" value="1">
                    	<span class="input-group-btn">
                        <button type="button" class="btn btn-xs btn-success" style="margin-left:5px;" onClick="increse()"><i class="fa fa-caret-up"></i></button>
                        <button type="button" class="btn btn-xs btn-danger" style="margin-left:5px;" onClick="decrese()"><i class="fa fa-caret-down"></i></button>
                        </span>
                    </div>
                </div>
                
                <div class="col-lg-5">
                	<div class="input-group">
                	<span class="input-group-addon" style="padding-left:5px; padding-right:5px;">ยิงบาร์โค้ด</span>
                    <input type="text" class="form-control input-sm" value="" id="barcode" name="barcode" autofocus />
                    <span class="input-group-btn">
                    	<button type="button" class="btn btn-xs btn-primary" id="btn_add" onClick="add_item()"><i class="fa fa-bolt"></i> เพิ่มรายการ</button>
                     </span>
                	</div>
                </div>     	
            
            </div>
        							
		</div>
		<div class="widget-body">
        <div class="widget-main" style="padding:0px;">
         <table class="table table-striped" style="margin-bottom:0px;">
            <tr style="font-size:12px;">
            	<th style="width: 5%; text-align:center;">No.</th>
                <th style="width: 10%;">Barcode</th>
                <th style="width: 15%;">Items</th>
                <th style="width: 25%;">Detail</th>
                <th style="width: 5%; text-align:center;">Qty.</th>
                <th style="width: 10%; text-align:center;">Price</th>
                <th style="width: 10%; text-align:center;">Discount</th>
                <th style="width: 15%; text-align:right;">Amount.</th>
                <th style="width: 5%; text-align:center;"></th>
            </tr>
            </table>
            </div>
            
			<div class="widget-main" id="items_box" style="min-height:500px; padding:0px;">
            <table class="table table-striped" style="margin-bottom:0px;">
            <tbody id="rs">
     <?php $i = 0; $n = 1; $total_amount = 0.00; $total_qty = 0.00; ?>
	<?php if( isset($detail) && $detail != false ) : ?>
    	<?php foreach($detail as $rd) : ?>
        <?php 	$id = $rd->id_order_detail; ?>
        		<tr style="font-size:10px;" id="row_<?php echo $id; ?>">
                    <td align="center" style="width: 5%;"><span class="no"><?php echo $n; ?></span></td>
                    <td style="width: 10%;"><?php echo $rd->barcode; ?></td>
                    <td style="width: 15%;"><?php echo $rd->item_code; ?></td>
                    <td style="width: 25%;"><?php echo $rd->item_name; ?></td>
                    <td style="width: 5%;" align="center" class="qty"><?php echo number_format($rd->qty); ?></td>
                    <td style="width: 10%;" align="center"><?php echo number_format($rd->price,2); ?></td>
                    <td style="width: 10%;" align="center"><?php echo discount($rd->discount_percent, $rd->discount_amount); ?></td>
                    <td style="width: 15%;" align="right" class="amount"><?php echo number_format($rd->total_amount,2); ?></td>
                    <td style="width: 5%;" align="center"><button type="button" class="btn btn-danger btn-minier" onClick="delete_row(<?php echo $id; ?>)"><i class="fa fa-trash"></i></button></td>
                </tr>
        <?php $total_qty += $rd->qty; $total_amount += $rd->total_amount; $i++; $n++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
            	
            </tbody>            
            </table>
            	
			</div>
		</div>
	</div>
	<!-- /section:custom/widget-box -->	
</div>

<div class="col-lg-3">
<form id="payment_form" action="<?php echo $this->home; ?>/payment/<?php echo $rs->id_order; ?>" method="post">
	<!-- #section:custom/widget-box -->
	<div class="widget-box ">
		<div class="widget-header">	
        	<h5 class="widget-title"><center><?php echo $rs->reference; ?></center></h5>
		</div>
		<div class="widget-body">
			<div class="widget-main" id="items_box" style="min-height:500px; padding:0px; padding-bottom:15px;">
            	<div class="row">
                <div class="col-lg-6 input-lg">รายการ</div><div class="col-lg-6 input-lg" id="total_rows"><?php echo $i; ?></div>
                <div class="col-lg-6 input-lg">จำนวน</div><div class="col-lg-6 input-lg" id="total_items"><?php if(isset($total_qty)){ echo number_format($total_qty); }else{ echo 0; } ?></div>
                <div class="col-lg-12">
                	<div style="width:100%; height:100px; background-color:red; color: yellow; font-size:38px; padding:15px; text-align:center" id="total_amount_label">
					<?php if(isset($total_amount)){ echo number_format($total_amount, 2); }else{ echo 0.00; } ?>
                    </div>
                    <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $total_amount; ?>" />
                </div>
                </div>
               <div class="row" style="margin-left:0px; margin-right:0px;">
                <div class="col-lg-12 input-lg"><label for="cash"><input type="radio" name="payment_method" id="cash" value="cash" checked />&nbsp; ชำระด้วยเงินสด</label></div>
                <div class="col-lg-12 input-lg"><label for="card"><input type="radio" name="payment_method" id="card" value="credit_card" />&nbsp; ชำระด้วยบัตรเคดิต</label></div>
                <div class="col-lg-12" style="margin-top:15px;">
                    <label style="font-size:20px;">รับเงิน </label>
					<input type="text" class="form-control input-lg" value="" id="received" name="received" style="text-align:center;" />
				</div>
                <div class="col-lg-12" style="font-size:20px;">เงินทอน</div>
                <div class="col-lg-12" style="height:70px; font-size:38px; color:blue; padding:15px; text-align:center; margin-bottom:15px;">
                	<span id="change">0.00</span><input type="hidden" id="change_amount" name="change_amount" value="0.00" />
                </div>
                <div class="col-lg-12"><button type="button" class="btn btn-lg btn-success btn-block" id="btn_payment" onclick="save()">ชำระเงิน</button></div>
				<input type="text" style="display:none;" />
			</div>
		</div>
	</div>
	<!-- /section:custom/widget-box -->	
</div>
</form>
</div>
<script id="row" type="text/x-handlebars-template">
<tr style="font-size:10px;" id="row_{{ id }}">
    <td align="center"><span class="no"></span></td>
    <td>{{ barcode }}</td>
    <td>{{ item }}</td>
    <td>{{ detail }}</td>
    <td align="center" class="qty">{{ qty }}</td>
    <td align="center">{{ price }}</td>
    <td align="center">{{ discount }}</td>
    <td align="right" class="amount">{{ amount }}</td>
    <td align="center"><button type="button" class="btn btn-danger btn-minier" onClick="delete_row({{ id }})"><i class="fa fa-trash"></i></button></td>
</tr>
</script>
<?php endforeach; ?>
<?php endif; ?>
<script>
$(document).keyup(function(e) {
    if(e.keyCode == 32)
	{
		$("#received").focus();
	}
});

$("#card").change(function(e) {
    var amount = $("#total_amount").val();
	$("#received").val(amount);
	$("#received").focus();
});

$("#cash").change(function(e){
	$("#received").val('');
	$("#received").focus();
});


$("#discount_amount").keyup(function(e) {
    $("#discount_percent").val('0.00');
	if( e.keyCode == 13 ){
		$("#qty").focus();
	}
});
$("#discount_amount").focusout(function(e) {
    if( isNaN(parseFloat($(this).val())) ){
		$(this).val('0.00');
	}
});

$("#discount_percent").keyup(function(e){
	$("#discount_amount").val('0.00');
	if( e.keyCode == 13 ){
		$("#discount_amount").focus();
	}
});

$("#discount_percent").focusout(function(e) {
    if( isNaN(parseFloat($(this).val())) ){
		$(this).val('0.00');
	}
});

$("#received").numberOnly();
$("#barcode").keyup(function(e) {
    if(e.keyCode == 13 )
	{
		$("#btn_add").click();
	}
	if(e.keyCode == 38)
	{
		increse();
	}
	if(e.keyCode == 40)
	{
		decrese();
	}
});


$("#received").keyup(function(e) {
    if(e.keyCode == 13)
	{
		$("#btn_payment").focus();
	}else{
		cal_change();
	}
});

function cal_change()
{
	var amount = parseFloat($("#total_amount").val());
	var received = parseFloat($("#received").val());
	var change = parseFloat(received - amount).toFixed(2);
	if(change > 0)
	{
		change = addCommas(change);
		$("#change").text(change);	
		$("#change_amount").val(change);
	}
	else
	{
		$("#change").text("0.00");
		$("#change_amount").val(0.00);
	}
}

function recal()
{
	var rows 	= totalRows();
	var qty		= totalQty();
	var amount 	= totalAmount();
	$("#total_rows").text(addCommas(rows));
	$("#total_items").text(addCommas(qty));
	$("#total_amount").val(amount);
	$("#total_amount_label").text(addCommas(amount));
}

function totalRows()
{
	var rows = 0;
	$(".no").each(function(index, element) {
        rows += 1;
    });	
	return rows;
}
function totalQty()
{
	var qtys = 0;
	$(".qty").each(function(index, element) {
        var qty = parseInt(removeCommas($(this).text()))
		if( !isNaN(qty) ){
			qtys += qty;
		}
    });	
	return qtys;
}

function totalAmount()
{
	var amounts = 0;
	$(".amount").each(function(index, element) {
        var amount = parseFloat(removeCommas($(this).text()));
		if( !isNaN(amount) ){
			amounts += amount;
		}
    });	
	return amounts.toFixed(2);
}

function reorder()
{
	var i = 1;
	$(".no").each(function(index, element) {
        $(this).text(i);
		i++;
    });	
}

function save()
{
	var id_order = $("#id_order").val();
	var received = parseFloat($("#received").val());
	var total_amount = parseFloat($("#total_amount").val());
	var payment_method = $("input[name=payment_method]:checked").val();
	if(isNaN(received)){ swal("กรุณาระบุยอดเงินที่รับมา");  return false; }
	if(received < total_amount){	swal("รับเงินมาน้อยกว่ายอดที่ต้องชำระ");	return false; 	}
	
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/payment/"+id_order,
		type:"POST", cache:"false", data:{ "total_amount" : total_amount, "received" : received, "payment_method" : payment_method },
		success: function(rs){
			load_out();
			var rs = $.trim(rs);
			if(rs == 'success'){
				var center = ($(document).width() - 400) /2;
				window.open('<?php echo $this->home; ?>/print_order/'+id_order, '_blank', 'width=400, height=600, left='+center+', scrollbars=yes');
				window.location.href = '<?php echo $this->home; ?>';
			}else{
				swal('ชำระเงินไม่สำเร็จ', 'การชำระเงินไม่สำเร็จกรุณาลองใหม่อีกครั้ง', 'error');
			}
		}
	});	
}
function add_item()
{
	var id						= $("#id_order").val();
	var discount_percent	= parseFloat($("#discount_percent").val());
	var discount_amount 	= parseFloat($("#discount_amount").val());
	var qty					= parseInt($("#qty").val());
	var barcode			= $.trim($("#barcode").val());
	if(barcode == ""){ swal("กรุณาระบุบาร์โค้ดสินค้า"); return false; }
	if(isNaN(qty)){ swal("กรุณาระบุจำนวนสินค้า ขั้นต่ำ 1 ชื้น"); return false; }
	if(isNaN(discount_percent)){ discount_percent = 0; }
	if(isNaN(discount_amount)){ discount_amount = 0; }
	if(discount_percent > 100){ swal("ส่วนลดเกิน 100%"); return false; }
	$("#discount_percent").val('0.00');
	$("#discount_amount").val('0.00');
	$("#qty").val(1);
	$("#barcode").val('');
	
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/add_item/"+id,
		type: "POST", cache:"false", data:{ "barcode" : barcode, "discount_percent" : discount_percent, "discount_amount" : discount_amount, "qty" : qty },
		success: function(rs){
			load_out();
			var rs = $.trim(rs);
			if( rs == "no_item" ){
				swal("ไม่มีสินค้าในระบบ");
			}else{
				var arr = rs.split(" || ");
				if( arr[0] == "update" ){
					var id_row = arr[1];
					$("#row_"+id_row).html(arr[2]);
					recal();
					reorder();
					$("#barcode").focus();
					
				}else if( arr[0] == "insert"){
					var source = $("#row").html();
					var data = $.parseJSON(arr[1]);
					var output = $("#rs");
					render_append(source, data, output);
					recal();
					reorder();
					$("#barcode").focus();
				}
			}
		}
	});	
}
function delete_row(id)
{
	swal({
		  title: "แน่ใจนะ?",
		  text: "คุณกำลังจะลบรายการ โปรดตรวจสอบให้แน่ใจว่าคุณต้องการลบจริง ๆ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "ใช่ ลบเลย",
		  cancelButtonText: "ยกเลิก",
		  closeOnConfirm: true
		},
		function(isConfirm){
		  if (isConfirm) 
		  {
			delete_item(id);
		  } 
		});
}

function delete_item(id)
{
	var id_order = $("#id_order").val();
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/delete_item", type: "POST", cache: "false",
		data:{ "id_order_detail" : id }, 
		success: function(rs)
		{
			load_out();
			var rs = $.trim(rs);
			if(rs == "success")
			{
				$("#row_"+id).remove();
				recal();
				reorder();$("#barcode").focus();
			}
			else
			{
				swal({ title: "ผิดพลาด", text: "ไม่สามารถลบรายการได้ กรุณาลองใหม่อีกครั้ง", type: "error"});
			}
		}
	});			
}

function increse()
{
	var qty = parseInt($("#qty").val());
	if(isNaN(qty)){ 
		qty = 1; 
	}else{
		qty += 1;
	}
	$("#qty").val(qty)	
}
function decrese()
{
	var qty = parseInt($("#qty").val());
	if(isNaN(qty)){ 
		qty = 1; 
	}else{
		if( qty > 1 ){
			qty = qty - 1;
		}
	}
	$("#qty").val(qty);
}

$("#qty").keyup(function(e) {
    if(e.keyCode == 38)
	{
		increse();
	}
	if(e.keyCode == 40)
	{
		decrese();
	}
});


$(function(){
    $('#items_box').slimScroll({
        height: '500px'
    });
});


</script>