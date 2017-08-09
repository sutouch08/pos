<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access 	= validAccess($this->id_menu);  ?>
<?php $view		= $access['view']; ?>
<?php $add 		= $access['add']; ?>
<?php $edit 		= $access['edit']; ?>
<?php $delete		= $access['delete']; ?>

<?php if(!$view) : ?>
<?php access_deny();  ?>
<?php else : ?>

<div class='row'>
	<div class='col-lg-12'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tint'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="tabbable tabs-below">
<div class="tab-content">
<div id="tab1" class="tab-pane active">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-6">
	<form id="search_form" action="<?php echo $this->home; ?>" method="post">
	<label for="search_detail">ค้นหาร้านค้า</label>
	<input type="text" id="search_text" name="shop_search" placeholder="ระบุรายการค้นหา" class="form-control input-sm" value="<?php echo $shop_search; ?>" />
    </form>
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_search" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-info btn-xs btn-block" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_reset" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-warning btn-xs btn-block" id="btn_reset" onClick="clearFilter()" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button>
</div>
</div><!--/ Row -->
</div><!--/ tab1 -->

<div id="tab2" class="tab-pane">
<div class="row">
<form id="add_form">
<div class="col-lg-2 col-md-3 col-sm-4">
    <label >รหัส</label>
	<input type="text" id="code" name="code" class="form-control input-sm" autofocus="autofocus"  />
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label >ชื่อร้านค้า</label>
	<input type="text" id="name" name="name" class="form-control input-sm" />
</div>

<div class="col-lg-2 col-md-3 col-sm-4">
	<label >เบอร์โทรศัพท์</label>
	<input type="text" id="phone" name="phone" class="form-control input-sm" style="text-align:center;"  placeholder="000-000-0000" />
</div>

<div class="col-lg-4 col-md-6 col-sm-6">
	<label for="cash_in">ที่อยู่</label>
	<input type="text" id="address" name="address" class="form-control input-sm" />
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label >จังหวัด</label>
    <select class="form-control input-sm" id="province" name="province"><?php echo selectProvince(); ?></select>
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label >รหัสไปรษณีย์</label>
	<input type="text" id="post_code" name="post_code" class="form-control input-sm" />
</div>

<div class="col-lg-2 col-md-4 col-sm-6">
	<label style="display:block;">สถานะ</label>
    <div class="btn-group">
    	<button type="button" class="btn btn-sm btn-success" id="btn_active" onclick="enable()"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-sm" id="btn_disactive" onclick="disable()"><i class="fa fa-times"></i></button>
    </div>
</div>

<?php if($add) : ?>
<div class="col-lg-1 col-md-2 col-sm-6">
	<label for="btn_save">&nbsp;</label>
	<button type="button" id="btn_save" onclick="save()" class="btn btn-success btn-xs btn-block"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
</div>
<?php endif; ?>
<input type="hidden" id="active" name="active" value="1" />
</form>
</div><!--/ Row -->
</div><!-- tab2 -->

</div><!-- tab content -->
<ul class="nav nav-tabs" id="myTab">
<li class="active" ><a aria-expanded="false" data-toggle="tab" href="#tab1"><i class="fa fa-search"></i>&nbsp; ค้นหา</a></li>
<li class=""><a aria-expanded="true" data-toggle="tab" href="#tab2"><i class="fa fa-plus"></i>&nbsp; เพิ่มใหม่</a></li>
</ul>
<div class="row">
<div class="col-lg-12" style="height:1px !important">
<p class="pull-right" style="margin-top:-25px;">
พบ <?php echo number_format($total_row); ?> รายการ | รายการ/หน้า 
<input type="text" class="input-sm" id="set_rows" value="<?php echo $row; ?>" style="width:50px; text-align:center; margin-left:15px; margin-right:15px;" />
<button class="btn btn-success btn-mini" onclick="set_rows()">เปลี่ยน</button>
</p>
</div>
</div>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />

<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ไอดี</th>
            <th style='width:15%;'>รหัส</th>
             <th style="width:30%;">ชื่อร้าน</th>
             <th style="width:15%;">จังหวัด</th>
             <th style="width:15%;">เบอร์โทรศัพท์</th>
            <th style="width:5%; text-align:center">สถานะ</th>
            <th style="width:15%; text-align:right"></th>
           </tr>
      </thead>
      <tbody id="rs">
<?php if($data != false) : ?>
        <?php foreach($data as $rs): ?>
        <?php 	$id = $rs->id_shop; ?>
        		<tr id="row_<?php echo $id; ?>">
                    <td style="vertical-align:middle;" align="center"><?php echo $id; ?></td>
                    <td style="vertical-align:middle;"><span id="code_<?php echo $id; ?>"><?php echo $rs->shop_code; ?></span></td>
                    <td style="vertical-align:middle;"><span id="name_<?php echo $id; ?>"><?php echo $rs->shop_name; ?></span></td>
                    <td style="vertical-align:middle;"><span id="province_<?php echo $id; ?>"><?php echo $rs->province; ?></span></td>
                    <td style="vertical-align:middle;"><span id="phone_<?php echo $id; ?>"><?php echo $rs->phone; ?></span></td>
                    <td style="vertical-align:middle;" align="center"><span id="active_<?php echo $id; ?>"><?php echo isActived($rs->active); ?></span></td>  
                    <td align="right" style="vertical-align:middle;">
                     <div class="btn-group">
                        <button class="btn btn-primary btn-minier btn-white dropdown-toggle" aria-expanded="false" data-toggle="dropdown">&nbsp; คำสั่ง &nbsp;<i class="face-icon fa fa-angle-down icon-on-right"></i></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                            <?php if( $edit ) : ?>
                            	<li><a href="javascript:void(0)" onclick="addEmp(<?php echo $id; ?>)"><i class="fa fa-plus"></i> &nbsp; เพิ่มพนักงาน</a></li>
                            	<li><a href="javascript:void(0)" onclick="edit_row(<?php echo $id; ?>)" ><i class="fa fa-pencil"></i> &nbsp; แก้ไขร้านค้า</a></li>
                            <?php endif; ?>
                            <?php if( $delete ) : ?>    
                                <li><a href="javascript:void(0)" onclick="confirm_delete(<?php echo $id; ?>, '<?php echo $rs->shop_name; ?>')"><i class="fa fa-trash"></i> &nbsp; ลบรายการนำเข้า</a></li>
                             <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr id="nocontent"><td colspan="11" align="center" ><h3>----- ไม่พบรายการใดๆ  -----</h3></td></tr>
    <?php endif; ?>
		</table>
        <?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->

<!------------------------------------------------- Modal  ----------------------------------------------------------->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>แก้ไขร้านค้า</h4>
		  </div>
		  <div class='modal-body' id="editBody">      

          </div><!--- modal-body -->
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->
<!------------------------------------------------- Modal add Emp  ----------------------------------------------------------->
<div class='modal fade' id='addEmp' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>เพิ่มพนักงานในร้านค้า</h4>
		  </div>
		  <div class='modal-body'>      
			<div class="row">
            	<div class="col-lg-9">
                	<label>ค้นหาพนักงาน</label>
                	<input type="text" class="form-control input-sm" id="empSearch" placeholder="ค้นหาพนักงาน" />
                    <span class="help-block">การค้นหาจะแสดงเฉพาะพนักงานที่ยังไม่ได้สังกัดร้านค้าใดๆ</span>
                </div>
                <div class="col-lg-3">
                <label style="display:block; visibility:hidden;">ค้นหาพนักงาน</label>
                <button type="button" class="btn btn-info btn-xs btn-block" onClick="addToShop()" ><i class="fa fa-plus"></i> เพิ่มในร้าน</button>
                
                <input type="hidden" id="id_employee"/>
                <input type="hidden" id="id_shop" />
                </div>
             </div>
             <hr/>
             <div class="row">
             	<div class="col-lg-12"><label>พนักงานในร้าน</label></div>
               	<div class="col-lg-12" id="empTable">
                	
                </div>
             </div>
          </div><!--- modal-body -->
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->

<script id="emp_field" type="tex/x-handlebars-template">                    
<table class="table table-bordered table-striped">
	<thead>
		<th style="width:20%; text-align:center;">รหัส</th>
		<th style="width:40%; text-align:center;">พนักงาน</th>
		<th style="width:20%; text-align:center;">เบอร์โทร</th>
		<th style="width:5%; text-align:center;">สถานะ</th>
		<th></th>
	 </thead>
	{{#each this}}
	<tr style="font-size:10px;" id="empRow_{{ id }}">
		<td>{{ code }}</td>
		<td>{{ empName }}</td>
		<td>{{ phone }}</td>
		<td align="center">{{{ active }}}</td>
		<td align="center"><button type="button" class="btn btn-danger btn-minier" onClick="removeEmpShop({{ id }})"><i class="fa fa-times"></i></button></td>
	</tr>
	{{/each}}
</table>
</script>

<script id="edit_field" type="tex/x-handlebars-template">
<div class="row">
<form id="edit_form">
<div class="col-lg-4">
    <label >รหัส</label>
	<input type="text" id="e_code" name="code" value="{{ code }}" class="form-control input-sm"  />
</div>

<div class="col-lg-8">
	<label >ชื่อร้านค้า</label>
	<input type="text" id="e_name" name="name" value="{{ name }}" class="form-control input-sm" />
</div>

<div class="col-lg-4">
	<label >เบอร์โทรศัพท์</label>
	<input type="text" id="e_phone" name="phone" value="{{ phone }}" class="form-control input-sm" style="text-align:center;"  />
</div>

<div class="col-lg-8">
	<label >ที่อยู่</label>
	<input type="text" id="e_address" name="address" value="{{ address }}" class="form-control input-sm" />
</div>

<div class="col-lg-4">
	<label >จังหวัด</label>
	<select class="form-control input-sm" id="e_province" name="province" >{{{ province }}}</select>
</div>

<div class="col-lg-4">
	<label>รหัสไปรษณีย์</label>
	<input type="text" id="e_post_code" name="post_code" value="{{ post_code }}" class="form-control input-sm" />
</div>

<div class="col-lg-2">
	<label style="display:block;">สถานะ</label>
    <div class="btn-group">
    	<button type="button" class="btn btn-sm {{success}}" id="btn_e_active" onclick="edit_enable()"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-sm {{danger}}" id="btn_e_disactive" onclick="edit_disable()"><i class="fa fa-times"></i></button>
    </div>
</div>

<?php if($edit) : ?>
<div class="col-lg-2">
	<label >&nbsp;</label>
	<button type="button" id="btn_save" onclick="validField({{id}})" class="btn btn-success btn-xs btn-block"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
</div>
<?php endif; ?>
<input type="hidden" id="e_active" name="active" value="{{ active }}" />

</form>
</div><!--/ Row -->
</script>
<script id="template" type="text/x-handlebars-template">
	<tr id="row_{{ id }}">
    	<td style="vertical-align:middle;" align="center">{{ id }}</td>
        <td style="vertical-align:middle;"><span id="code_{{ id }}">{{ code }}</span></td>
        <td style="vertical-align:middle;"><span id="name_{{ id }}">{{ name }}</span></td>
		<td style="vertical-align:middle;"><span id="province_{{ id }}">{{ province }}</span></td>
		<td style="vertical-align:middle;"><span id="phone_{{ id }}">{{ phone }}</span></td>       
        <td style="vertical-align:middle;" align="center"><span id="active_{{ id }}">{{{ active }}}</td>              
        <td align="right" style="vertical-align:middle;">
		<?php if($edit) : ?><button type="button" class="btn btn-warning btn-minier" onclick="edit_row({{id}})"><i class="fa fa-pencil"></i></button><?php endif; ?>
        <?php if($delete) : ?> <button type="button" class="btn btn-danger btn-minier" onclick="confirm_delete({{id}}, '{{ name}}')"><i class="fa fa-trash"></i></button> <?php endif; ?>
		</td>
    </tr>
</script>
<script>
function removeEmpShop(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/removeFromShop/"+id,
		type:"POST", cache:"false", success: function(rs){
			var rs = $.trim(rs);
			if( rs == 'success' ){
				$("#empRow_"+id).remove();
				$("#empSearch").focus();
			}else if( rs == 'fail' ){
				swal('เกิดข้อผิดพลาด', 'ไม่สามารถลบพนักงานออกจากร้านได้ในขณะนี้ กรุณาลองใหม่อีกครั้งภายหลัง', 'error');
			}
		}
	});
}
function addToShop()
{
	var shop = $("#id_shop").val();
	var emp	= $("#id_employee").val();
	if( shop == '' ){ swal('ไม่พบไอดีร้าน กรุณาลองอีกครั้ง'); return false; }
	if( emp == '' ){ swal('ไม่พบไอดีพนังาน กรุณาเลือกพันกงานอีกครั้ง'); return false; }
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/addToShop",
		type:"POST", cache:"false", data:{ 'id_shop' : shop, 'id_employee' : emp },
		success: function(rs){
			load_out();
			var rs = $.trim(rs);
			if( rs == 'success'){
				$("#empSearch").val('');
				$("#id_employee").val('');
				getEmpTable(shop);
			}else if( rs == 'fail' ){
				swal('เกิดข้อผิดพลาด', 'ไม่สามารถเพิ่มพนักงานในร้านได้ กรุณาลองใหม่อีกครั้งภายหลัง', 'error');
			}
		}
	});
}

function addEmp(id)
{
	$("#id_shop").val(id);
	$.ajax({
		url:"<?php echo $this->home; ?>/shopEmp/"+id,
		type:"POST", cache:"false", success: function(rs){
			var rs = $.trim(rs);
			if( rs == 'noemployee' ){
				var html = '<div class="well well-sm">ยังไม่มีพนักงานในร้าน</div>';
				$("#empTable").html(html);
				$("#addEmp").modal('show');
			}else{
				var source 	= $("#emp_field").html();
				var data 		= $.parseJSON(rs);
				var output	= $("#empTable");
				render(source, data, output);
				$("#addEmp").modal('show');
			}
		}
	});
}

function getEmpTable(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/shopEmp/"+id,
		type:"POST", cache:"false", success: function(rs){
			var rs = $.trim(rs);
			if( rs == 'noemployee' ){
				var html = '<div class="well well-sm">ยังไม่มีพนักงานในร้าน</div>';
				$("#empTable").html(html);
			}else{
				var source 	= $("#emp_field").html();
				var data 		= $.parseJSON(rs);
				var output	= $("#empTable");
				render(source, data, output);
				$("#empSearch").focus();
			}
		}
	});	
}

$("#addEmp").on('shown.bs.modal', function(){ $("#empSearch").focus(); });
$("#empSearch").autocomplete({
	source: '<?php echo base_url(); ?>admin/tool/getEmployee',
	autoFocus: true,
	close: function(){
		var rs = $(this).val();
		if( rs == 'No data found' ){
			$(this).val('');
		}else{
			var rs = rs.split(' | ');
			$("#id_employee").val(rs[2]);		
			$(this).val(rs[1]);
		}
	}
});
		

function confirm_delete(id, shop)
{
	swal({
		  title: "แน่ใจนะ?",
		  text: "คุณกำลังจะลบ '"+shop+"' โปรดตรวจสอบให้แน่ใจว่าคุณต้องการลบจริงๆ",
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
				deleteShop(id, shop);
		  } 
		});
}

function deleteShop(id, shop)
{
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/deleteShop/"+id,
		type:"POST", cache:"false", success: function(rs)
		{
			load_out();
			var rs = $.trim(rs);
			if(rs == "success"){
				$("#row_"+id).remove();
				swal({ title: "สำเร็จ", text: "ลบ "+shop+" เรียบร้อยแล้ว", type : "success", timer: 1000 });
			}else if( rs == 'transection' ){
				swal("ไม่สำเร็จ", "ไม่สามารถลบ "+shop+" ได้ เนื่องจากมี Transection ที่เกี่ยวข้องเกิดขึ้นแล้ว", "error");
			}else{
				swal("ไม่สำเร็จ", "ลบ "+shop+" ไม่สำเร็จ", "error");
			}
		}
	});
}

function save()
{
	var code 	= $("#code").val();
	var name 	= $("#name").val();
	var prov		= $("#province").val();
	if(code == ""){ swal({ title : "ข้อมูลไม่ครบ", text :"รหัสร้านค้าไม่ถูกต้อง", type: "error" }); return false; }
	if(name == ""){ swal({ title : "ข้อมูลไม่ครบ", text :"ชื่อร้านค้าไม่ถูกต้อง", type: "error" }); return false; }
	if( prov == ''){ swal({ title: 'ข้อมูลไม่ครบ', text: 'กรุณาระบุจังหวัด', type: 'error' }); return false; }
	$.ajax({
		url:"<?php echo $this->home; ?>/validShop",
		type:"POST", cache: "false", data:{ "code" : code, "name" : name },
		success: function(ds){
			var ds = $.trim(ds);
			if( ds == 'ok' ){
				load_in();
				
				$.ajax({
					url:"<?php echo $this->home; ?>/addShop",
					type: "POST", cache: "false", data: $("#add_form").serialize(),
					success: function(rs)
					{
						load_out();
						var rs = $.trim(rs);
						if(rs == "fail" || rs == '')
						{
							swal("Error !!", "ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่ภายหลัง", "error");
							
						}else{
							
							var source 		= $("#template").html();
							var data 			= $.parseJSON(rs);
							var template 	= Handlebars.compile(source);
							var row 			= template(data);
							$("#rs").prepend(row);
							$("#nocontent").remove();
							clear_field();
							
						}
					}
				});
				
			}else if(ds == 'code'){
				
				swal("รหัสซ้ำ !!", "รหัสร้านค้านี้ถูกใช้ไปแล้ว", "error");
				
			}else if( ds == 'name'){
				
				swal("ร้านค้าซ้ำ !!", "ร้านค้านี้มีอยู่แล้ว", "error");
				
			}else{

				swal("Error !!", "ไม่สามารถตรวจสอบข้อมูลได้กรุณาลองใหม่อีกครั้งภายหลัง", "error");
				
			}
		}
	});				
}

function edit_row(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/getShop/"+id,
		type:"POST", cache: "false", 
		success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs != "fail")
			{
				var source 		= $("#edit_field").html();
				var data 			= $.parseJSON(rs);
				var output		= $("#editBody");
				render(source, data, output);
				$("#editModal").modal('show');				
			}else{
				swal("ไม่พบข้อมูล");	
			}
		}
	});
}

function validField(id)
{
	var code		= $("#e_code").val();
	var name 	= $("#e_name").val();
	if( code == ""){ swal("กรุณาระบุรหัสร้าน"); return false; }
	if( name == ""){ swal("กรุณาระบุชื่อร้าน"); return false; }
	$.ajax({
		url:"<?php echo $this->home; ?>/validShop",
		type: "POST", cache: "false", data:{ "id_shop" : id, "code" : code, "name" : name },
		success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs == "ok")
			{
				updateShop(id);
			}
			else if( rs == "code")
			{
				swal("รหัสซ้ำ", "รหัสนี้ถูกใช้ไปแล้ว กรุณากำหนดรหัสใหม่", "error");
			}
			else if( rs == "name" )
			{
				swal("ร้านค้าซ้ำ", "มีร้านนี้อยู่แล้ว กรุณาใช้ชื่ออื่น", "error");
			}
			else
			{
				swal("เกิดข้อผิดพลาด", "ไม่สามารถแก้ไขข้อมูลร้านค้าได้กรุณาลองใหม่ภายหลัง", "error");
			}
		}
	});
}

function updateShop(id)
{
	$("#editModal").modal("hide");
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/updateShop/"+id, 
		type: "POST", cache:"false", data: $("#edit_form").serialize(),
		success: function(rs)
		{
			load_out();
			var rs = $.trim(rs);
			if(rs == "success")
			{
				$("#code_"+id).text($("#e_code").val());
				$("#name_"+id).text($("#e_name").val());
				$("#phone_"+id).text($("#e_phone").val());
				$("#province_"+id).text($("#e_province").val());
				if( $("#e_active").val() == 1 ){ 
					var icon = "<?php echo isActived(1); ?>"; 
				}else{ 
					var icon = "<?php echo isActived(0); ?>"; 
				}
				$("#active_"+id).html(icon);
				swal({ title: "สำเร็จ", text : "ปรับปรุงข้อมูลเรียบร้อยแล้ว", type : "success", timer : 1000 });
				//$("#edit_form").remove();				
			}else{
				swal({ 
						title : "Error !!", 
						text : "ไม่สามารถแก้ไขรายการได้ กรุณาตรวจสอบความถูกต้องของข้อมูล", 
						type: "error", 
						showCancelButton: false}, 
						function(){ $("#editModal").modal("show"); 
					});	
			}
		}
	});
}

function clear_field()
{
	$("#code").val("");
	$("#name").val("");
	$("#address").val("");
	$("#province").val("");
	$("#post_code").val("");
	$("#phone").val('');
	enable();
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
function edit_disable()
{
	$("#btn_e_active").removeClass("btn-success");
	$("#btn_e_disactive").addClass("btn-danger");
	$("#e_active").val(0);
}

function edit_enable()
{
	$("#btn_e_disactive").removeClass("btn-danger");
	$("#btn_e_active").addClass("btn-success");
	$("#e_active").val(1);
}

function get_search()
{
	var txt = $("#search_text").val();
	if(txt != "")
	{
		$("#search_form").submit();
	}
}

$("#tab1").on('shown.bs.tab', function(e){ $("#search_text").focus(); });


$("#code").keyup(function(e) {
    if( e.keyCode == 13 ){
		$("#name").focus();
	}
});

$("#name").keyup(function(e){
	if( e.keyCode == 13 ){
		$("#phone").focus();
	}
});

$("#phone").keyup(function(e) {
    if( e.keyCode == 13 ){
		$("#address").focus();
	}
});

$("#address").keyup(function(e){
	if( e.keyCode == 13 ){
		$("#province").focus();
	}
});

$("#province").keyup(function(e) {
    if( e.keyCode == 13 ){
		$("#post_code").focus();
	}
});

$("#post_code").keyup(function(e) {
    if( e.keyCode == 13 ){
		$("#btn_save").focus();
	}
});

function clearFilter(){
	$.get('<?php echo $this->home; ?>/clearFilter');
	window.location.href = '<?php echo current_url(); ?>';
}
</script>
<?php endif; ?>
