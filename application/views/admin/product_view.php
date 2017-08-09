<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access 	= validAccess($id_menu);  ?>
<?php $view		= $access['view']; ?>
<?php $add 		= $access['add']; ?>
<?php $edit 		= $access['edit']; ?>
<?php $delete		= $access['delete']; ?>
<?php if(!$view) : ?>
<?php access_deny();  ?>
<?php else : ?>
<style>
label {
	margin-top:10px;
}
</style>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tags'></i>&nbsp; <?php echo $this->title; ?></h3>
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
                    <a href="<?php echo $this->home; ?>/clear_filter/"><button type="button" class="btn btn-warning btn-xs btn-block" id="btn_reset" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button></a>
                </div>
            </div><!--/ Row -->
        </div><!--/ tab1 -->
    </div><!-- tab content -->
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a aria-expanded="false" data-toggle="tab" href="#tab1"><i class="fa fa-search"></i>&nbsp; ค้นหาสินค้า</a></li>
        <li class=""><a aria-expanded="true" data-toggle="tab" href="javascript:viod(0)" onClick="showAddModal()"><i class="fa fa-plus"></i>&nbsp; เพิ่มสินค้าใหม่</a></li>
        <li class=""><a aria-expanded="true" data-toggle="tab" href="javascript:viod(0)" onClick="showFileModal()"><i class="fa fa-upload"></i>&nbsp; เพิ่มสินค้าจากไฟล์นำเข้า</a></li>
    </ul>
    <div class="row">
        <div class="col-lg-12" style="height:1px !important">
            <p class="pull-right" style="margin-top:-25px;">
            จำนวนแถวต่อหน้า 
            <input type="text" class="input-sm" id="set_rows" value="<?php echo $row; ?>" style="width:50px; text-align:center; margin-left:15px; margin-right:15px;" />
            <button class="btn btn-success btn-mini" onclick="set_rows()">บันทึก</button>
            </p>
        </div>
    </div>
</div><!-- tabable -->

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />

<div class='row'>
	<div class='col-xs-12' style="padding-bottom:20px;">
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ไอดี</th>
            <th style='width:10%;'>บาร์โค้ด</th>
             <th style="width:10%;">รหัสสินค้า</th>
             <th style="width:20%;">ชื่อสินค้า</th>
            <th style="width:10%; text-align:center">รุ่น</th>
            <th style="width:10%; text-align:center">หมวดหมู่</th>
            <th style="width:5%; text-align:center">ทุน</th>
            <th style="width:5%; text-align:center">ราคา</th>
            <th style="width:10%; text-align:center">กลุ่ม</th>
            <th style="width:3%; text-align:center">สถานะ</th>
            <th style="text-align:right">การกระทำ</th>
           </tr>
      </thead>
      <tbody id="rs">
<?php if($data != false) : ?>
        <?php foreach($data as $rs): ?>
        <?php 	$id = $rs->id_item; ?>
        		<tr style="font-size:10px;" id="row_<?php echo $id; ?>">
                    <td style="vertical-align:middle;" align="center"><?php echo $id; ?></td>
                    <td style="vertical-align:middle;"><span id="barcode_<?php echo $id; ?>"><?php echo $rs->barcode; ?></span></td>
                    <td style="vertical-align:middle;"><span id="item_code_<?php echo $id; ?>"><?php echo $rs->item_code; ?></span></td>
                    <td style="vertical-align:middle;"><span id="item_name_<?php echo $id; ?>"><?php echo $rs->item_name; ?></span></td>
                    <td style="vertical-align:middle;" align="center"><span id="style_<?php echo $id; ?>"><?php echo $rs->style; ?></span></td>
                    <td style="vertical-align:middle;" align="center"><span id="cate_<?php echo $id; ?>"><?php echo $rs->category; ?></span></td>
                    <td style="vertical-align:middle;" align="center"><span id="cost_<?php echo $id; ?>"><?php echo number_format($rs->cost,2); ?></span></td>
                    <td style="vertical-align:middle;" align="center"><span id="price_<?php echo $id; ?>"><?php echo number_format($rs->price,2); ?></span></td>
                     <td style="vertical-align:middle;" align="center"><span id="brand_<?php echo $id; ?>"><?php echo brandName($rs->id_brand); ?></span></td>
                    <td style="vertical-align:middle;" align="center"><span id="active_<?php echo $id; ?>"><?php echo isActived($rs->active); ?></span></td>                    
                    <td align="right" style="vertical-align:middle;">
                    <?php if($edit) : ?> <button type="button" class="btn btn-warning btn-minier" onclick="edit_row(<?php echo $id; ?>)"><i class="fa fa-pencil"></i></button> <?php endif; ?>
                    <?php if($delete) : ?> <button type="button" class="btn btn-danger btn-minier" onclick="confirm_delete(<?php echo $id; ?>)"><i class="fa fa-trash"></i></button> <?php endif; ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr id="nocontent"><td colspan="11" align="center" ><h4 class="title">-----  No item -----</h4></td></tr>
    <?php endif; ?>
		</table>
        <?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->

<!------------------------------------------------- Modal  ----------------------------------------------------------->
<div class='modal fade' id='addModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:500px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>เพิ่มสินค้า</h4>
		  </div>
		  <div class='modal-body' id="addBody">      
          	<div class="row">
                <div class="col-lg-6">
                    <label >บาร์โค้ดสินค้า</label>
                    <input type="text" id="barcode" name="barcode" class="form-control input-sm" autofocus="autofocus" />
                </div>
                
                 <div class="col-lg-6">
                    <label>รหัสสินค้า</label>
                    <input type="text" id="item_code" name="item_code" class="form-control input-sm" />
                </div>
                
                 <div class="col-lg-12">
                    <label >ชื่อสินค้า</label>
                    <input type="text" id="item_name" name="item_name" class="form-control input-sm" />
                </div>
                 <div class="col-lg-6">
                    <label for="cash_in">รุ่นสินค้า</label>
                    <input type="text" id="style" name="style" class="form-control input-sm" />
                </div>
                 <div class="col-lg-6">
                    <label >หมวดหมู่</label>
                    <input type="text" id="cate" name="cate" class="form-control input-sm" />
                </div>
                 <div class="col-lg-6">
                    <label>กลุ่มสินค้า</label>
                    <select id="id_brand" name="id_brand" class="form-control input-sm">
                    <?php echo select_brand(); ?>
                    </select>
                </div>
                 <div class="col-lg-3">
                    <label>ราคาทุน</label>
                    <input type="text" id="cost" name="cost" class="form-control input-sm" />
                </div>
                
                <div class="col-lg-3">
                    <label>ราคาขาย</label>
                    <input type="text" id="price" name="price" class="form-control input-sm" />
                </div>
                
                 <div class="col-lg-6">
                    <label style="display:block;">สถานะ</label>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success" id="btn_active" onclick="enable()"><i class="fa fa-check"></i></button>
                        <button type="button" class="btn btn-sm" id="btn_disactive" onclick="disable()"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <?php if($add) : ?>
                 <div class="col-lg-12">
                    <label>&nbsp;</label>
                    <button type="button" id="btn_save" onclick="save()" class="btn btn-success btn-sm btn-block"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
                </div>
                <?php endif; ?>
                <input type="hidden" id="active" value="1" />
                
                </div><!--/ Row -->
          </div><!--- modal-body -->
		</div>
	</div>
</div>

<!------------------------------------------------- END Modal  ----------------------------------------------------------->
<!------------------------------------------------- Modal  ----------------------------------------------------------->
<div class='modal fade' id='editer_modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:500px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>แก้ไขสินค้า</h4>
		  </div>
		  <div class='modal-body' id="edit_modal">      
          
          </div><!--- modal-body -->
		</div>
	</div>
</div>

<!------------------------------------------------- END Modal  ----------------------------------------------------------->

<!------------------------------------------------- Modal  ----------------------------------------------------------->
<div class='modal fade' id='fileModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:500px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>นำเข้ารายการสินค้า</h4>
		  </div>
		  <div class='modal-body'>      
          <form id="myform" action="<?php echo $this->home; ?>/import_items" method="post" enctype="multipart/form-data">
            <div class="row">
            <div class="form-group">
            <div class="col-lg-8">
                <label>ไฟล์นำเข้ารายการสินค้า</label>
                <!-- #section:custom/file-input -->
                    <input id="user_file" type="file" name="user_file" class="input-sm">                                              
            </div>
            <div class="col-lg-4">
                <label style="display:block; visibility:hidden; margin-top:20px;">upload</label>
                <button type="button" class="btn btn-success btn-xs btn-block" id="btn_upload" onclick="upload()" ><i class="fa fa-upload"></i>&nbsp; นำเข้า</button>
            </div>
            </div>
            </div><!--/ Row -->
			</form>
          </div><!--- modal-body -->
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->


<script id="edit_field" type="tex/x-handlebars-template">
	<div class="row">
            <div class="col-lg-6">
                <label >บาร์โค้ดสินค้า</label>
                <input type="text" id="edit_barcode"  class="form-control input-sm" value="{{ barcode }}" autofocus="autofocus" />
            </div>
            
            <div class="col-lg-6">
                <label >รหัสสินค้า</label>
                <input type="text" id="edit_item_code" class="form-control input-sm" value="{{ item_code }}" />
            </div>
            
            <div class="col-lg-12">
                <label >ชื่อสินค้า</label>
                <input type="text" id="edit_item_name"class="form-control input-sm" value="{{ item_name }}"  />
            </div>
            <div class="col-lg-6">
                <label >รุ่นสินค้า</label>
                <input type="text" id="edit_style" class="form-control input-sm" value="{{ style }}" />
            </div>
			 <div class="col-lg-6">
                <label >หมวดหมู่</label>
                <input type="text" id="edit_cate" class="form-control input-sm" value="{{ category }}" />
            </div>
			<div class="col-lg-6">
                <label >กลุ่มสินค้า</label>
                <select id="edit_id_brand" name="id_brand" class="form-control input-sm">
                {{{ option }}}
                </select>
            </div>
            <div class="col-lg-3">
                <label >ราคาทุน</label>
                <input type="text" id="edit_cost" class="form-control input-sm" value="{{ cost }}" />
            </div>
            
            <div class="col-lg-3">
                <label >ราคาขาย</label>
                <input type="text" id="edit_price" class="form-control input-sm" value="{{ price }}" />
            </div>
			 
            <div class="col-lg-6">
                <label style="display:block;">สถานะ</label>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm {{ enable }}" id="btn_edit_active" onclick="edit_enable()"><i class="fa fa-check"></i></button>
                    <button type="button" class="btn btn-sm {{ disable }}" id="btn_edit_disactive" onclick="edit_disable()"><i class="fa fa-times"></i></button>
                    <input type="hidden" id="edit_active" value="{{ active }}" />
                </div>
            </div>
            <div class="col-lg-12">
            	<label style="display:block; visibility:hidden;">update</label>
            	<button type="button" id="btn_edit_save" class="btn btn-success btn-sm btn-block" onclick="update_row()"><i class="fa fa-save"></i> บันทึก</button>
                <input type="hidden" id="id_item" value="{{ id_item }}" />
            </div>
	</div>			
</script>
<script id="template" type="text/x-handlebars-template">
	<tr style="font-size:10px;" id="row_{{ id }}">
    	<td style="vertical-align:middle;" align="center">{{ id }}</td>
        <td style="vertical-align:middle;"><span id="barcode_{{ id }}">{{ barcode }}</span></td>
        <td style="vertical-align:middle;"><span id="item_code_{{ id }}">{{ item_code }}</span></td>
        <td style="vertical-align:middle;"><span id="item_name_{{ id }}">{{ item_name }}</span></td>
        <td style="vertical-align:middle;" align="center"><span id="style_{{ id }}">{{ style }}</span></td>
		<td style="vertical-align:middle;" align="center"><span id="cate_{{ id }}">{{ category }}</span></td>
        <td style="vertical-align:middle;" align="center"><span id="cost_{{ id }}">{{ cost }}</span></td>
        <td style="vertical-align:middle;" align="center"><span id="price_{{ id }}">{{ price }}</span></td>
		<td style="vertical-align:middle;" align="center"><span id="brand_{{ id }}">{{ brand }}</span></td>
        <td style="vertical-align:middle;" align="center"><span id="active_{{ id }}">{{{ active }}}</span></td>                 
        <td align="right" style="vertical-align:middle;">
		<?php if($edit) : ?><button type="button" class="btn btn-warning btn-minier" onclick="edit_row({{id}})"><i class="fa fa-pencil"></i></button><?php endif; ?>
        <?php if($delete) : ?> <button type="button" class="btn btn-danger btn-minier" onclick="confirm_delete({{id}})"><i class="fa fa-trash"></i></button> <?php endif; ?>
		</td>
    </tr>
</script>

<script>
function showAddModal()
{
	$("#addModal").modal('show');	
}

function showFileModal()
{
	$("#fileModal").modal('show');	
}

$("#cate").autocomplete({
	source: '<?php echo base_url(); ?>admin/tool/getCategory',
	autoFocus: true
});
function upload()
{
	$("#fileModal").modal('hide');
	var file = $("#user_file").val();
	if( file == '' )
	{ 
		swal({ title: 'ไม่พบไฟล์', text:"กรุณาเลือกไฟล์", type: 'warning', showCancelButton: false }, function(){ $("#fileModal").modal('show'); }); 
	}
	else
	{
		load_in();
		$("#myform").submit();
	}
}


function confirm_delete(id)
{
	swal({
		  title: "แน่ใจนะ?",
		  text: "คุณกำลังจะลบสินค้า โปรดตรวจสอบให้แน่ใจว่าคุณต้องการลบจริง ๆ",
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
				delete_row(id);
		  } 
		});
}

function delete_row(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/delete_item/"+id,
		type:"GET", cache:"false", success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs == "success")
			{
				$("#row_"+id).remove();
				swal({ title: "สำเร็จ", text: "ลบสินค้าเรียบร้อยแล้ว", type : "success", timer: 1000 });
			}
			else
			{
				swal("ไม่สำเร็จ", "ลบสินค้าไม่สำเร็จ", "error");
			}
		}
	});
}

function edit_row(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/get_item/"+id,
		type:"GET", cache: "false", 
		success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs != "fail")
			{
				var source 		= $("#edit_field").html();
				var data 			= $.parseJSON(rs);
				var template 	= Handlebars.compile(source);
				var row 			= template(data);
				var output		= $("#edit_modal");
				render(source, data, output);
				$("#edit_cate").autocomplete({
						source: '<?php echo base_url(); ?>admin/tool/getCategory',
						autoFocus: true
					});
				$("#editer_modal").modal("show");
				$('#editer_modal').on('shown.bs.modal', function (e) { $("#edit_barcode").focus(); });
				
			}else{
				swal("ไม่พบข้อมูล");	
			}
		}
	});
}

function update_item(id, barcode, item_code, item_name, style, cate, cost, price, id_brand, brand, active)
{
	$("#editer_modal").modal("hide");
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/update_item", type: "POST", cache:"false",
		data: { "id" : id, "barcode" : barcode, "item_code" : item_code, "item_name" : item_name, "style" : style, "category" : cate, "cost" : cost, "price" : price, "id_brand" : id_brand, "active" : active },
		success: function(rs)
		{
			load_out();
			var rs = $.trim(rs);
			if(rs == "success")
			{
				$("#barcode_"+id).text(barcode);
				$("#item_code_"+id).text(item_code);
				$("#item_name_"+id).text(item_name);
				$("#style_"+id).text(style);
				$("#cate_"+id).text(cate);
				$("#cost_"+id).text(cost);
				$("#price_"+id).text(price);
				$("#brand_"+id).text(brand);
				if(active == 1 ){ var icon = "<i class='fa fa-check' style='color:green;'></i>"; }else{ var icon = "<i class='fa fa-times' style='color:red;'></i>"; }
				$("#active_"+id).html(icon);
				swal({ title: "สำเร็จ", text : "ปรับปรุงข้อมูลเรียบร้อยแล้ว", type : "success", timer : 1000 });
			}else if(rs == "missing_data"){
				swal({ title : "Error !!", text : "เกิดความผิดพลาดระหว่างการส่งข้อมูล", type: "error", showCancelButton: false}, function(){ $("#editer_modal").modal("show"); });
			}else{
				swal({ title : "Error !!", text : "ไม่สามารถแก้ไขรายการได้ กรุณาตรวจสอบความถูกต้องของข้อมูล", type: "error", showCancelButton: false}, function(){ $("#editer_modal").modal("show"); });	
			}
		}
	});
}


function update_row()
{
	var id				= $("#id_item").val();	
	var barcode	= $.trim($("#edit_barcode").val());
	var item_code 	= $.trim($("#edit_item_code").val());
	var item_name	= $.trim($("#edit_item_name").val());
	var style 		= $.trim($("#edit_style").val());
	var cate			= $.trim($("#edit_cate").val());
	var cost			= $.trim($("#edit_cost").val());
	var price			= $.trim($("#edit_price").val());
	var id_brand	= $("#edit_id_brand").val();
	var brand		= $("#edit_id_brand :selected").text();
	var active		= $("#edit_active").val();
	if(id == ""){ swal("ไม่พบ ID สินค้า"); return false; }
	if(barcode == ""){ swal("กรุณากำหนดบาร์โค้ด"); return false; }
	if(item_code == ""){ swal("กรุณากำหนดรหัสสินค้า"); return false; }
	if(item_name == ""){ swal("กรุณากำหนดชื่อสินค้า"); return false; }
	if(style == ""){ swal("กรุณากำหนดรุ่น"); return false; }
	if(isNaN(parseFloat(cost))){ swal("ราคาทุนไม่ถูกต้อง"); return false; }
	if(isNaN(parseFloat(price))){ swal("ราคาขายไม่ถูกต้อง"); return false; }
	$.ajax({
		url:"<?php echo $this->home; ?>/valid_barcode/"+barcode+"/"+id,
		type: "GET", cache: "false", 
		success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs == "ok")
			{
				update_item(id, barcode, item_code, item_name, style, cate, cost, price, id_brand, brand, active);
			}
			else
			{
				swal("บาร็โค้ดซ้ำ");
			}
		}
	});
}
$("#addModal").on('shown.bs.modal', function(){ $("#barcode").focus(); });

function save()
{
	var barcode 	= $("#barcode").val();
	var item_code 	= $("#item_code").val();
	var item_name 	= $("#item_name").val();
	var style			= $("#style").val();
	var cate			= $("#cate").val();
	var cost			= $("#cost").val();
	var price 		= $("#price").val();
	var id_brand	= $("#id_brand").val();
	var active		= $("#active").val();
	if( barcode == ""){ swal("กรุณากำหนดบาร์โค้ด"); return false; }
	if( item_code == ""){ swal("กรุณากำหนดรหัสสินค้า"); return false; }
	if( item_name == ""){ swal("กรุณากำหนดชื่อสินค้า"); return false; }
	if( style == ""){ swal("กรุณากำหนดรุ่น"); return false; }
	if( cate == ''){ swal('กรุณากำหนดหมวดหมู่'); return false; }
	if(isNaN(parseFloat(cost))){ swal("ราคาทุนไม่ถูกต้อง"); return false; }
	if(isNaN(parseFloat(price))){ swal("ราคาขายไม่ถูกต้อง"); return false; }
	$("#btn_save").attr("disabled", "disabled");
	$("#addModal").modal('hide');
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/add_item",
		type: "POST", cache: "false", data: { "barcode" : barcode, "item_code" : item_code, "item_name" : item_name, "style" : style, "category" : cate, "cost" : cost, "price" : price, "id_brand" : id_brand, "active" : active },
		success: function(rs)
		{
			load_out();
			$("#btn_save").attr("disabled", "disabled");
			var rs = $.trim(rs);
			if(rs == "fail")
			{
				swal("Error !!", "ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่ภายหลัง", "error");
				$("#btn_save").removeAttr("disabled");
				$("#addModal").modal('show');
			}else if( rs == "duplicate_barcode"){
				swal("บาร์โค้ดซ้ำ !!", "ไม่อนุญาติให้บาร์โค้ดซ้ำกัน", "error");	
				$("#btn_save").removeAttr("disabled");
				$("#addModal").modal('show');
			}else{
				var source 		= $("#template").html();
				var data 			= $.parseJSON(rs);
				var template 	= Handlebars.compile(source);
				var row 			= template(data);
				$("#rs").prepend(row);
				clear_field();
				$("#btn_save").removeAttr("disabled");
				swal({ 
						title: 'เพิ่มสินค้าเรียบร้อยแล้ว', 
						text: ' ต้องการเพิ่มรายการสินค้าอื่นอีกหรือไม่ ?', 
						type: 'success',
						cancelButtonText: 'ไม่',
						confirmButtonText: 'ใช่',
						showCancelButton: true  }, function(){ $("#addModal").modal('show'); } 
						);				
			}
		}
	});
}

function clear_field()
{
	$("#barcode").val("");
	$("#item_code").val("");
	$("#item_name").val("");
	$("#style").val("");
	$("#cost").val("");
	$("#price").val("");
	$("#id_brand").val(1);
	enable();
	$("#barcode").focus();	
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
	$("#btn_edit_active").removeClass("btn-success");
	$("#btn_edit_disactive").addClass("btn-danger");
	$("#edit_active").val(0);
}

function edit_enable()
{
	$("#btn_edit_disactive").removeClass("btn-danger");
	$("#btn_edit_active").addClass("btn-success");
	$("#edit_active").val(1);
}
$("#barcode").keyup(function(e) {
    if(e.keyCode == 13){ $("#item_code").focus(); }
});
$("#item_code").keyup(function(e) {
    if(e.keyCode == 13){ $("#item_name").focus(); }
});
$("#item_name").keyup(function(e) {
    if(e.keyCode == 13){ $("#style").focus(); }
});
$("#style").keyup(function(e) {
    if(e.keyCode == 13){ $("#cost").focus(); }
});
$("#cost").keyup(function(e) {
    if(e.keyCode == 13){ $("#price").focus(); }
});
$("#price").keyup(function(e) {
    if(e.keyCode == 13){ $("#btn_save").focus(); }
});

function next_field(em, el)
{
	em.keyup(function(e){ if(e.keyCode == 13){ el.focus(); } }); 
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
</script>

<?php endif; ?>