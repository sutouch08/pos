<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access 	= validAccess($id_menu);  ?>
<?php $view		= $access['view']; ?>
<?php $add 		= $access['add']; ?>
<?php $edit 		= $access['edit']; ?>
<?php $delete		= $access['delete']; ?>
<?php if(!$view) : ?>
<?php access_deny();  ?>
<?php else : ?>

<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-top:10px; margin-bottom:0px;'><i class='fa fa-tint'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class="pull-right">
        	<button type="button" class="btn btn-success btn-sm" onClick="addNewRule()"><i class="fa fa-plus"></i> เพิ่มใหม่</button>
        </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="tabbable tabs-below">
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <form id="search_form" action="<?php echo $this->home; ?>" method="post">
                    <label>ค้นหาสินค้า</label>
                    <input type="text" id="search_text" name="search_text" placeholder="ระบุรายการค้นหา" class="form-control input-sm" value="<?php echo $search_text; ?>" />
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <label style="display:block;">&nbsp;</label>
                    <button type="button" class="btn btn-info btn-xs btn-block" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <label style="display:block;">&nbsp;</label>
                    <button type="button" class="btn btn-warning btn-xs btn-block" id="btn_reset" onClick="clearFilter()"><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button>
                </div>
            </div><!--/ Row -->
        </div><!--/ tab1 -->
    </div><!-- tab content -->
    <ul class="nav nav-tabs" id="myTab">
    	<li class="active"><a data-toggle="tab" href="#tab1"><i class="fa fa-search"></i>&nbsp; ค้นหา</a></li>
    	<li><a data-toggle="tab" href="javascript:void(0)" onClick="addNewRule()"><i class="fa fa-plus"></i>&nbsp; เพิ่มเงื่อนไข</a></li>
    </ul>
    <div class="row">
        <div class="col-lg-12" style="height:1px !important">
            <p class="pull-right" style="margin-top:-25px;">
            พบ <?php echo number_format($total_row); ?> รายการ | รายการ/หน้า 
            <input type="text" class="input-sm" id="set_rows" value="<?php echo $row; ?>" style="width:50px; text-align:center; margin-left:15px; margin-right:15px;" />
            <button class="btn btn-success btn-mini" onclick="set_rows()">บันทึก</button>
            </p>
        </div>
    </div>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />

<div class='row'>
	<div class='col-xs-12' style="padding-bottom:20px;">
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:10px;'>
        	<th style='width:10%;'>รหัส</th>
            <th style="width:20%;">ชื่อ</th>
            <th style="width:10%;"><a href="javascript:void(0)" onClick="showConditionType()">ประเภทเงื่อนไข</a></th>
            <th style="width:10%;"><a href="javascript:void(0)" onClick="showRuleType()">รูปแบบเงื่อนไข</a></th>
            <th style="width:10%;"><a href="javascript:void(0)" onClick="showGainType()">รูปแบบการให้</a></th>
            <th style="width:10%;"><a href="javascript:void(0)" onClick="showTarget()">การจำกัด</a></th>        
            <th ></th>
          </tr>
      </thead>
      <tbody id="rs">
<?php if($data != FALSE) : ?>
        <?php foreach($data as $rs): ?>
        <?php 	$id = $rs->id_rule; ?>
        		<tr style="font-size:10px;" id="row_<?php echo $id; ?>">
                    <td style="vertical-align:middle;"><?php echo $rs->code; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->name; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->condition_type == 'amount' ? 'ยอดซื้อ' : 'สินค้า'; ?></td>
                    <td style="vertical-align:middle;"><?php echo ruleType($rs->rule_type); ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->condition_type == 'amount' ? 'ยอดซื้อ' : 'สินค้า'; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->condition_type == 'amount' ? 'ยอดซื้อ' : 'สินค้า'; ?></td>
                                    
                    <td align="right" style="vertical-align:middle;">
                       <div class="btn-group">
                        <button class="btn btn-primary btn-minier btn-white dropdown-toggle" aria-expanded="false" data-toggle="dropdown">&nbsp; คำสั่ง &nbsp;<i class="face-icon fa fa-angle-down icon-on-right"></i></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                            	<li><a href="javascript:void(0)" onclick="viewDetail(<?php echo $id; ?>)" ><i class="fa fa-eye"></i> &nbsp; รายละเอียด</a></li>
                                 <?php if( $add OR $edit ) : ?>
                                <li class="divider"></li>
                                <?php endif; ?>
                            	<?php if( $add ) : ?>
                            	<li><a href="javascript:void(0)" onclick="addPromotionItems('<?php echo $rs->code; ?>')" ><i class="fa fa-plus"></i> &nbsp; เพิ่มสินค้าโปรโมชั่น</a></li>
                                <li><a href="javascript:void(0)" onclick="select_file(<?php echo $id; ?>)" ><i class="fa fa-upload"></i> &nbsp; นำเข้าสินค้าโปรโมชั่น</a></li>
                                <?php endif; ?>
                                
                                <?php if( $add && $edit ) : ?>
                                <li class="divider"></li>
                                <?php endif; ?>
                                <?php if( $edit ) : ?>
                                <li><a href="javascript:void(0)" onclick="removePromotionItems('<?php echo $rs->code; ?>')" ><i class="fa fa-trash"></i> &nbsp; ลบสินค้าโปรโมชั่น</a></li>
                                <li><a href="javascript:void(0)" onclick="confirm_delete(<?php echo $id; ?>)"><i class="fa fa-trash"></i> &nbsp; ลบรายการนำเข้า</a></li>
                                <?php endif; ?>       
                                <?php if( $add OR $edit OR $delete) : ?>                         
                               	<li class="divider"></li>
                                <?php endif; ?>
                               <?php if($edit) : ?> 
                               <li><a href="javascript:void(0)" id="btn_edit<?php echo $id; ?>" onclick="edit_row(<?php echo $id; ?>)"><i class="fa fa-pencil"></i>&nbsp; แก้ไขโปรโมชั่น</a></li> 
                               <?php endif; ?>
                               <?php if($delete) : ?> 
                               <li><a href="javascript:void(0)" onclick="confirm_delete(<?php echo $id; ?>)"><i class="fa fa-trash"></i>&nbsp; ลบโปรโมชั่น</a></li> 
                               <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr id="nocontent"><td colspan="11" align="center" ><h4>-----  ไม่พบรายการ  -----</h4></td></tr>
    <?php endif; ?>
    	</tbody>
		</table>
        <?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->


<div class='modal fade' id='importModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:500px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>นำเข้าสินค้าโปรโมชั่น</h4>
		  </div>
		  <div class='modal-body' id="edit_modal">      
          	<form id="myform" action="<?php echo $this->home; ?>/import_items" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-8">
                            <label for="search_detail">ไฟล์รายการสินค้า</label>
                            <!-- #section:custom/file-input -->
                                <input id="user_file" type="file" name="user_file" class="input-sm">                                          
                        </div>
                        <div class="col-lg-4">
                            <label for="btn_search" style="display:block;">&nbsp;</label>
                            <button type="button" class="btn btn-success btn-xs btn-block" id="btn_upload" onclick="upload()" ><i class="fa fa-upload"></i>&nbsp; นำเข้า</button>
                        </div>
                    </div>
                    <div class="col-lg-12">** ไฟล์ที่นำเข้าต้องเป็นไฟล์ .xlsx หรือ .xls เท่านั้น</div>
                </div><!--/ Row -->
                <input type="hidden" name="id_promotion" id="id_promotion" />
            </form>
          </div><!--- modal-body -->
		</div>
	</div>
</div>


<div class='modal fade' id='detailModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>รายละเอียดโปรโมชั่น</h4>
		  </div>
		  <div class='modal-body' id="viewBody">      
          	
          </div><!--- modal-body -->
		</div>
	</div>
</div>

<?php $this->load->view('import/promotion_explain'); ?>

<script id="row-template" type="text/x-handlebars-template">
<tr style="font-size:10px;" id="row_{{ id }}">
    <td style="vertical-align:middle;" align="center">{{ id }}</td>
    <td style="vertical-align:middle;">{{ code }}</td>
    <td style="vertical-align:middle;">{{ name }}</td>
    <td style="vertical-align:middle;">{{ price }}</td>
    <td style="vertical-align:middle;" align="center">{{ percent }}</td>
    <td style="vertical-align:middle;" align="center">{{ amount }}</td>
    <td style="vertical-align:middle;" align="center">{{ start }}</td>
    <td style="vertical-align:middle;" align="center">{{ end }}</td>
    <td style="vertical-align:middle;" align="center">{{{ active }}}</td>  
    <td style="vertical-align:middle;" align="center">{{ date_upd }}</td>                  
    <td align="right" style="vertical-align:middle;">
    <div class="btn-group">
    <button class="btn btn-primary btn-minier btn-white dropdown-toggle" aria-expanded="false" data-toggle="dropdown">&nbsp; คำสั่ง &nbsp;<i class="face-icon fa fa-angle-down icon-on-right"></i></button>
    <ul class="dropdown-menu dropdown-menu-right">
	<li><a href="javascript:void(0)" onclick="viewDetail({{ id }})" ><i class="fa fa-eye"></i> &nbsp; รายละเอียด</a></li>
	<?php if( $add OR $edit ) : ?>
	<li class="divider"></li>
	<?php endif; ?>
	<?php if( $add ) : ?>
	<li><a href="javascript:void(0)" onclick="addPromotionItems('{{ code }}')" ><i class="fa fa-plus"></i> &nbsp; เพิ่มสินค้าโปรโมชั่น</a></li>
	<li><a href="javascript:void(0)" onclick="select_file({{ id }})" ><i class="fa fa-upload"></i> &nbsp; นำเข้าสินค้าโปรโมชั่น</a></li>
	<?php endif; ?>
	<?php if( $add && $edit ) : ?>
	<li class="divider"></li>
	<?php endif; ?>
	<?php if($edit) : ?> 
	<li><a href="javascript:void(0)" onclick="removePromotionItems('{{ code }}')" ><i class="fa fa-trash"></i> &nbsp; ลบสินค้าโปรโมชั่น</a></li>
	<li><a href="javascript:void(0)" onclick="confirm_delete({{ id }})"><i class="fa fa-trash"></i> &nbsp; ลบรายการนำเข้า</a></li>
	<?php endif; ?>
	<?php if( $add OR $edit OR $delete) : ?>
	<li class="divider"></li>
	<?php endif; ?>
    <?php if($edit) : ?> 
    <li><a href="javascript:void(0)" id="btn_edit_{{id}}" onclick="edit_row({{ id }})"><i class="fa fa-pencil"></i>&nbsp; แก้ไขโปรโมชั่น</a></li> 
    <?php endif; ?>
    <?php if($delete) : ?> 
    <li><a href="javascript:void(0)" onclick="confirm_delete({{ id }})"><i class="fa fa-trash"></i>&nbsp; ลบโปรโมชั่น</a></li> 
    <?php endif; ?>
    </ul>
    </div>
    </td>
</tr>
</script>

<script>

function addNewRule()
{
	window.location.href = '<?php echo $this->home; ?>/addNewRule';
}	

function select_file(id)
{
	$("#id_promotion").val(id);
	$("#importModal").modal("show");	
}
function confirm_delete(id)
{
	swal({
		  title: "แน่ใจนะ?",
		  text: "คุณกำลังจะลบสินค้าโปรโมชั่น โปรดตรวจสอบให้แน่ใจว่าคุณต้องการลบจริง ๆ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "ใช่ ลบเลย",
		  cancelButtonText: "ยกเลิก",
		  closeOnConfirm: false
		},
		function(isConfirm){
		  if (isConfirm) 
		  {
				delete_imported(id);
		  } 
		});
}
function delete_imported(id)
{
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/deleteImported/"	+id,
		type:"POST", cache: "false", success: function(rs){
			load_out();
			var rs = $.trim(rs);
			if( rs == "success"){
				swal({ title : "สำเร็จ", text: "ลบสินค้าโปรโมชั่นเรียบร้อยแล้ว", timer: 1000, type: "success" });
			}else{
				swal("ลบสินค้าโปรโมชั่นไม่สำเร็จ");
			}
		}
	});
}

function addPromotionItems(code)
{
	window.location.href = "<?php echo base_url(); ?>	admin/promotion/addPromotionItems/"+code;
}

function removePromotionItems(code)
{
	window.location.href = '<?php echo base_url(); ?>admin/promotion/removePromotionItems/'+code;	
}

function save(){
	var name 	= $("#promo-name").val();
	var start		= $("#start-date").val();
	var end		= $("#end-date").val();
	var price	 	= parseFloat($("#sell-price").val());
	var percent	= parseFloat($("#percent").val());
	var amount	= parseFloat($("#amount").val());
	var active	= $("#active").val();
	
	if( name == "" ){ swal("กรุณากำหนดชื่อโปรโมชั่น"); return false; }
	if( !isDate(start) || !isDate(end) ){ swal("วันที่ไม่ถูกต้อง"); return false; }
	if( isNaN(price) || isNaN(percent) || isNaN(amount) ){ swal("ส่วนลดไม่ถูกต้อง"); return false; }
	if( percent > 100 ){ swal("ส่วนลดเกิน 100%"); return false; }
	
	load_in();
	$.ajax({
		url: "<?php echo $this->home; ?>/add",
		type:"POST", cache: false, data:{ "name" : name, "start" : start, "end" : end, "price" : price, "percent" : percent, "amount" : amount, "active" : active },
		success: function(rs){
			load_out();
			var rs 		= $.trim(rs);
			var source 	= $('#row-template').html();
			var data 		= $.parseJSON(rs);
			var output 	= $("#rs");
			render_prepend(source, data, output);
		}
	});
}

$("#promo-name").keyup(function(e) {
    if( e.keyCode == 13 ){
		if( $(this).val() != '' ){
			$("#start-date").focus();
		}
	}
});

$("#start-date").keyup(function(e) {
    if( e.keyCode == 13 ){
		if( !isDate($(this).val()) ){
			swal('วันที่ไม่ถูกต้อง');
		}else{
			$('#end-date').focus();
		}
	}
});

$("#end-date").keyup(function(e) {
    if( e.keyCode == 13 ){
		if( !isDate($(this).val()) ){
			swal('วันที่ไม่ถูกต้อง');
		}else{
			$('#sell-price').focus();
		}
	}
});

$("#sell-price").keyup(function(e) {
	if( e.keyCode == 13 ){
		if( isNaN( parseFloat($(this).val())) ){
			swal('ราคาขายไม่ถูกต้อง');
		}else{
			$("#percent").focus();
		}
	}
});

$("#sell-price").focusout(function(e) {
    if( $(this).val() == ''){
		$(this).val('0.00');
	}else if( isNaN(parseFloat($(this).val()))){
		$(this).val('0.00');
	}
});

$("#percent").focusout(function(e) {
    if( $(this).val() == ''){
		$(this).val('0.00');
	}else if( isNaN(parseFloat($(this).val()))){
		$(this).val('0.00');
	}
});

$("#amount").focusout(function(e) {
    if( $(this).val() == ''){
		$(this).val('0.00');
	}else if( isNaN(parseFloat($(this).val()))){
		$(this).val('0.00');
	}
});

$("#percent").keyup(function(e) {
    if( e.keyCode == 13 ){
		var max_dis = 100;
		var dis		= parseFloat($(this).val());
		if( isNaN(dis) ){
			swal('ส่วนลดไม่ถูกต้อง');
		}else if( dis > max_dis){
			swal("ส่วนลดเกิน 100%");
		}else{
			$("#amount").focus();
		}
	}
});

$("#amount").keyup(function(e) {
    if( e.keyCode == 13 ){
		if( isNaN(parseFloat($(this).val())) ){
			swal('ส่วนลดไม่ถูกต้อง');
		}else{
			$("#btn_save").focus();
		}
	}
});
$('#start-date').datepicker({	dateFormat : 'dd-mm-yy', onClose: function(selectedDate){ $('#end-date').datepicker('option', 'minDate', selectedDate); } });
$('#end-date').datepicker({	dateFormat : 'dd-mm-yy' , onClose: function(selectedDate){ $('#start-date').datepicker('option', 'maxDate', selectedDate); }});

function upload()
{
	var file = $("#user_file").val();
	if(file == "")
	{ 
		swal("กรุณาเลือกไฟล์"); 
	}
	else
	{
		$("#myform").submit();
	}
}


function disable()
{
	$("#btn_active").removeClass("btn-success");
	$("#btn_disactive").addClass("btn-danger");
	$("#active").val(0);
}

function enable()
{
	$("#btn_disactive").removeClass("btn-danger");
	$("#btn_active").addClass("btn-success");
	$("#active").val(1);
}

function get_search()
{
	var txt = $("#search_text").val();
	if(txt != "")
	{
		$("#search_form").submit();
	}
}

$("#set_rows").keyup(function(e){
	if(e.keyCode == 13 ){ set_rows(); }
});

function set_rows()
{
	load_in();
	var rows =$("#set_rows").val();
	if(rows == "")
	{
		load_out();
		swal("จำนวนแถวต้องเป็นตัวเลขเท่านั้น");
		return false;
	}else{
		$.ajax({
			url:"<?php echo base_url(); ?>admin/tool/set_rows",type:"POST",cache:false,
			data:{ "rows" : rows },
			success: function(rs)
			{
				var rs = $.trim(rs);
				if(rs == "success")
				{
					load_out();
					window.location.reload();
				}else{
					load_out();
					swal("ไม่สามารถเปลี่ยนจำนวนแถวต่อหน้าได้ กรุณาลองใหม่อีกครั้งภายหลัง");
				}
			}
		});
	}
}
$("#user_file").ace_file_input({
	btn_choose : 'เลือกไฟล์',
	btn_change: 'เปลี่ยน',
	droppable: true,
	thumbnail: 'large',
	maxSize: 5000000,//bytes
	allowExt: ["xlsx|xls"]
});

$("#user_file").on('file.error.ace', function(ev, info) {
	if(info.error_count['ext'] || info.error_count['mime']){
		swal('กรุณาเลือกไฟล์นามสกุล .xlsx หรือ .xls เท่านั้น');
	}
	if(info.error_count['size']){
		swal('ขนาดไฟล์สูงสุดไม่เกิน 5 MB');
	}
});

function upload()
{
	var file = $("#user_file").val();
	if(file == "")
	{ 
		swal("กรุณาเลือกไฟล์"); 
	}
	else
	{
		load_in();
		$("#myform").submit();
	}
}


function clearFilter()
{
	var url = '<?php echo current_url(); ?>';
	$.ajax({
		url:"<?php echo $this->home; ?>/clear_filter",
		type: "POST", cache: "false", success: function(rs){
			window.location.href = url;
		}
	});
}
</script>

<?php endif; ?>