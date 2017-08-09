<?php if(isset($id_order)) : ?>
<div class="row">

<input type="hidden" id="id_user" name="id_user" value="<?php echo $this->session->userdata("id_user"); ?>" />
<input type="hidden" id="id_order" name="id_order" value="<?php echo $id_order; ?>"  />
<div class="col-lg-9">
	<!-- #section:custom/widget-box -->
	<div class="widget-box ">
		<div class="widget-header widget-header-large" style="padding: 15px;">	
        	<div class="row" style="margin-top:10px;">
        		<div class="col-lg-3">
                	<div class="input-group">
                	<span class="input-group-addon" style="padding-left:5px; padding-right:5px;">Order No.</span>
                   	<span class="form-control input-sm text-center"><?php echo $order->reference; ?></span>            
                	</div>
                </div>
                
                <div class="col-lg-3">
                	<div class="input-group">
                	<span class="input-group-addon" style="padding-left:5px; padding-right:5px;">Payment</span>
                   	<span class="form-control input-sm text-center"><?php echo paymentMethod($id_order); ?></span>            
                	</div>
                </div>
            
            </div>
        							
		</div>
		<div class="widget-body">
			<div class="widget-main" id="items_box" style="min-height:500px; padding:0px;">
            <table class="table table-striped">
            <thead style="font-size:12px;">
            	<th style="width: 5%; text-align:center;">No.</th>
                <th style="width: 10%;">Barcode</th>
                <th style="width: 15%;">Items</th>
                <th style="width: 25%;">Detail</th>
                <th style="width: 5%; text-align:center;">Qty.</th>
                <th style="width: 10%; text-align:center;">Price</th>
                <th style="width: 10%; text-align:center;">Discount</th>
                <th style="width: 15%; text-align:right;">Amount.</th>
                <th style="width: 5%; text-align:center;"></th>
            </thead>
            <tbody id="rs">
     <?php $i = 0; $n = 1; $total_amount = 0.00; $total_qty = 0.00; ?>
	<?php if( isset($detail) && $detail != FALSE ) : ?>
    	<?php foreach($detail as $rd) : ?>
        <?php 	$id = $rd->id_order_detail; ?>
        		<tr style="font-size:10px;" id="row_<?php echo $id; ?>">
                    <td align="center"><span class="no"><?php echo $n; ?></span></td>
                    <td id="barcode_<?php echo $id; ?>"><?php echo $rd->barcode; ?></td>
                    <td><?php echo $rd->item_code; ?></td>
                    <td><?php echo $rd->item_name; ?></td>
                    <td align="center" class="qty"><?php echo number_format($rd->qty); ?></td>
                    <td align="center"><?php echo number_format($rd->price,2); ?></td>
                    <td align="center"><?php echo discount($rd->discount_percent, $rd->discount_amount); ?></td>
                    <td align="right" class="amount"><?php echo number_format($rd->total_amount,2); ?></td>
                    <td align="center"><button type="button" class="btn btn-primary btn-minier" onClick="getReturn(<?php echo $id; ?>, <?php echo $rd->qty; ?>)"><i class="fa fa-retweet"></i> คืนสินค้า</button></td>
                </tr>
        <?php $n++; ?>
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

	<!-- #section:custom/widget-box -->
	<div class="widget-box ">
		<div class="widget-header">	
        	<h5 class="widget-title"><center>คืนแล้ว</center></h5>
		</div>
		<div class="widget-body">
			<div class="widget-main" id="items_box" style="min-height:200px; padding:0px; padding-bottom:15px;">
            	<div class="row">
                <div class="col-lg-6 input-lg">รายการ</div><div class="col-lg-6 input-lg" id="total_rows"><?php echo number_format(returnedItems($id_order)); ?></div>
                <div class="col-lg-6 input-lg">จำนวน</div><div class="col-lg-6 input-lg" id="total_items"><?php echo number_format(returnedQty($id_order)); ?></div>
                <div class="col-lg-12">
                	<div style="width:100%; height:100px; background-color:red; color: yellow; font-size:38px; padding:15px; text-align:center" id="total_amount_label">
					<?php echo number_format(returnedAmount($id_order), 2);  ?>
                    </div>
                </div>
                </div> 
		</div>
	</div>
	<!-- /section:custom/widget-box -->	
</div>

</div>
<!------------------------------------------------- Modal  ----------------------------------------------------------->
<div class='modal fade' id='return_modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:500px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>คืนสินค้า</h4>
		  </div>
		  <div class='modal-body' id="body_modal">      
          	<div class="row">
            <div class="col-lg-12">
                <label for="due_date">บาร์โค้ดสินค้า</label>
                <input type="text" id="return_barcode"  class="form-control input-sm" value="" autofocus="autofocus" />
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-6">
            	<span>จำนวน</span>  <span id="limit_label" style="padding-left:20px;"></span>
            </div>
            <div class="col-lg-6">
            	<span>คืนแล้ว</span> | <span id="current_label" style="padding-left:20px;"></span>
                <input type="hidden" id="id_order_detail" value="" />
                <input type="hidden" id="limit" value=""/>
                <input type="hidden" id="current" value="0" />
            </div>
          </div><!--- modal-body -->
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->
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
<?php endif; ?>
<script>
function getReturn(id, limit)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/getReturnedItem/"+id,
		type:"POST", cache:"false", 
		success: function(rs){
			var rs = $.trim(rs);
			$("#current").val(rs);
			$("#current_label").text(rs);
		}
	});
	$("#id_order_detail").val(id);
	$("#limit").val(limit);
	$("#limit_label").text(limit);
	$("#return_modal").modal("show");
}
$("#return_modal").on("shown.bs.modal", function(){ $("#return_barcode").focus(); });

$("#return_barcode").keyup(function(e) {
    if(e.keyCode == 13 )
	{
		add_item();
	}
});

function recal()
{
	var id 		= $("#id_order").val();
	totalRows(id);
	totalQty(id);
	totalAmount(id);	
}

function totalRows(id)
{
	var rows = 0;
	$.ajax({
		url:"<?php echo $this->home; ?>/total_rows/"+id,
		type:"POST", cache:false, success: function(rs){
			var rs = $.trim(rs);
			$("#total_rows").text(addCommas(rs));
		}
	});
	
}
function totalQty(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/total_qty/"+id,
		type:"POST", cache:"false", success: function(rs){
			var rs = $.trim(rs);
			$("#total_items").text(addCommas(rs));
		}
	});
	
}

function totalAmount(id)
{
	var amounts = 0;
	$.ajax({
		url:"<?php echo $this->home; ?>/total_amount/"+id,
		type:"POST", cache:"false", success: function(rs){
			var rs = $.trim(rs);
			$("#total_amount_label").text(addCommas(rs));
		}
	});
}


function add_item()
{
	var id						= $("#id_order").val();
	var id_od				= $("#id_order_detail").val();
	var barcode			= $.trim($("#return_barcode").val());
	var limit					= parseInt($("#limit").val());
	var current				= parseInt($("#current").val());
	if(barcode == ""){ swal("กรุณาระบุบาร์โค้ดสินค้า"); return false; }
	if( current == limit ){ swal('สินค้าเกิน' ,'ไม่สามารถคืนสินค้ามากกว่าที่ซื้อ', 'error'); return false; }
	$("#return_barcode").val('');	
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/add_item/"+id,
		type: "POST", cache:"false", data:{ "id_order_detail" : id_od, "barcode" : barcode },
		success: function(rs){
			load_out();
			var rs = $.trim(rs);
			if( rs == "no_item" ){
				swal("สินค้าไม่ตรงกับรายการที่เลือก");
			}else if( rs == 'fail' ){
				swal('รับคืนไม่สำเร็จ');
			}else if( rs == 'completed'){
				swal('สินค้าเกิน' ,'ไม่สามารถคืนสินค้ามากกว่าที่ซื้อ', 'error');
			}else{
				$("#current").val(rs);
				$("#current_label").text(rs);
				recal();
				$("#return_barcode").focus();
			}
		}
	});	
}


</script>