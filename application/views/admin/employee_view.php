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
                    <label for="search_detail">ค้นหาพนักงาน</label>
                    <input type="text" id="search_text" name="emp_search" placeholder="ระบุรายการค้นหา" class="form-control input-sm" value="<?php echo $emp_search; ?>" />
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <label for="btn_search" style="display:block;">&nbsp;</label>
                    <button type="button" class="btn btn-info btn-xs btn-block" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <label for="btn_reset" style="display:block;">&nbsp;</label>
                    <a href="<?php echo $this->home; ?>/clear_filter/"><button type="button" class="btn btn-warning btn-xs btn-block" id="btn_reset" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button></a>
                </div>
            </div><!--/ Row -->
        </div><!--/ tab1 -->
    
        <div id="tab2" class="tab-pane">
            <form id="add_form">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 padding-5">
                        <label >รหัส</label>
                        <input type="text" id="code" name="code" class="form-control input-sm" autofocus="autofocus"  />
                    </div>
                    
                    <div class="col-lg-3 col-md-4 col-sm-6 padding-5">
                        <label >ชื่อ</label>
                        <input type="text" id="first_name" name="first_name" class="form-control input-sm"  />
                    </div>
                    
                    <div class="col-lg-3 col-md-4 col-sm-6 padding-5">
                        <label >นามสกุล</label>
                        <input type="text" id="last_name" name="last_name" class="form-control input-sm" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 padding-5">
                        <label >เบอร์โทรศัพท์</label>
                        <input type="text" id="phone" name="phone" class="form-control input-sm" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 padding-5">
                        <label >ที่อยู่</label>
                        <input type="text" id="address" name="address" class="form-control input-sm"/>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 padding-5">
                        <label>จังหวัด</label>
                        <select id="province" name="province" class="form-control input-sm" ><?php echo selectProvince(); ?></select>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 col-sm-6 padding-5">
                        <label >รหัสไปรษณีย์</label>
                        <input type="text" id="post_code" name="post_code" class="form-control input-sm"/>
                    </div>
                    
                    
                    <div class="col-lg-3 col-md-4 col-sm-6 padding-5">
                        <label>อีเมล์</label>
                        <input type="text" id="email" name="email" class="form-control input-sm" placeholder="กำหนดอีเมล์ของพนักงาน (ไม่จำเป็น)" />
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 no-padding padding-5">
                        <label >วันที่เริ่มงาน</label>
                        <input type="text" id="start_date" name="start_date" class="form-control input-sm center" placeholder="วว-ดด-ปปปป"/>
                    </div>
                    
                    <div class="col-lg-2 col-md-3 col-sm-4 padding-5">
                        <label>วันเกิด</label>
                        <input type="text" id="birthday" name="birthday" class="form-control input-sm center" placeholder="วว-ดด-ปปปป"/>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 padding-5">
                        <label>สังกัด</label>
                        <input type="text" id="shop" name="shop" class="form-control input-sm center" placeholder="เลือกร้านค้า"/>
                    </div>
                    
                    <div class="col-lg-1 col-md-4 col-sm-6 padding-5">
                        <label style="display:block;">สถานะ</label>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-success" id="btn_active" onclick="enable()"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-sm" id="btn_disactive" onclick="disable()"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    
                    <?php if($add) : ?>
                    <div class="col-lg-1 col-md-2 col-sm-6 padding-5">
                        <label >&nbsp;</label>
                        <button type="button" id="btn_save" onclick="save()" class="btn btn-success btn-xs btn-block"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
                    </div>
                    <?php endif; ?>
                    <input type="hidden" id="active" name="active" value="1" />
                    <input type="hidden" name="id_shop" id="id_shop" />
                </div><!--/ Row -->
            </form>
        
        </div><!-- tab2 -->
    
    </div><!-- tab content -->
    <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a aria-expanded="false" data-toggle="tab" href="#tab1"><i class="fa fa-search"></i>&nbsp; ค้นหาพนักงาน</a></li>
    <li class="" onclick="set_focus('code')"><a aria-expanded="true" data-toggle="tab" href="#tab2"><i class="fa fa-plus"></i>&nbsp; เพิ่มพนักงานใหม่</a></li>
    </ul>
    <div class="row">
        <div class="col-lg-12" style="height:1px !important">
            <p class="pull-right" style="margin-top:-25px;">
            จำนวนแถวต่อหน้า 
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
                    <th style='width:10%;'>รหัส</th>
                     <th style="width:20%;">ชื่อ - สกุล</th>
                     <th style="width:20%;">อีเมล์</th>
                     <th style="width:10%;">เบอร์โทรศัพท์</th>
                     <th style="width:20%;">วันเริ่มงาน</th>
                    <th style="width:5%; text-align:center">สถานะ</th>
                    <th style="width:10%; text-align:right">การกระทำ</th>
                   </tr>
              </thead>
              <tbody id="rs">
                <?php if($data != false) : ?>
                <?php foreach($data as $rs): ?>
                <?php 	$id = $rs->id_employee; ?>
                        <tr id="row_<?php echo $id; ?>">
                            <td style="vertical-align:middle;" align="center"><?php echo $id; ?></td>
                            <td style="vertical-align:middle;"><span id="code_<?php echo $id; ?>"><?php echo $rs->code; ?></span></td>
                            <td style="vertical-align:middle;"><span id="name_<?php echo $id; ?>"><?php echo $rs->first_name." ".$rs->last_name; ?></span></td>
                            <td style="vertical-align:middle;"><span id="email_<?php echo $id; ?>"><?php echo $rs->email; ?></span></td>
                            <td style="vertical-align:middle;"><span id="phone_<?php echo $id; ?>"><?php echo $rs->phone; ?></span></td>
                            <td style="vertical-align:middle;"><span id="shop_<?php echo $id; ?>"><?php echo shopName($rs->id_shop); ?></span></td>
                            <td style="vertical-align:middle;" align="center"><span id="active_<?php echo $id; ?>"><?php echo isActived($rs->active); ?></span></td>  
                            <td align="right" style="vertical-align:middle;">
                            <?php if($edit) : ?> <button type="button" class="btn btn-warning btn-minier" onclick="edit_row(<?php echo $id; ?>)"><i class="fa fa-pencil"></i></button> <?php endif; ?>
                            <?php if($delete) : ?> <button type="button" class="btn btn-danger btn-minier" onclick="confirm_delete(<?php echo $id; ?>)"><i class="fa fa-trash"></i></button> <?php endif; ?>
                            </td>
                        </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr id="nocontent"><td colspan="11" align="center" ><h1><?php echo label("empty_content"); ?></h1></td></tr>
            	<?php endif; ?>
                </table>
                <?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->

<!------------------------------------------------- Modal  ----------------------------------------------------------->
<div class='modal fade' id='editer_modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>แก้ไขพนักงาน</h4>
		  </div>
		  <div class='modal-body' id="edit_modal">      
          
          </div><!--- modal-body -->
		</div>
	</div>
</div>
<!------------------------------------------------- END Modal  ----------------------------------------------------------->
<script id="edit_field" type="tex/x-handlebars-template">
<div class="row">
                <form id="edit_form">
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >รหัส</label>
                    <input type="text" id="e_code" name="code" class="form-control input-sm" autofocus="autofocus" value="{{ code }}" />
                </div>
                
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label>ชื่อ</label>
                    <input type="text" id="e_first_name" name="first_name" class="form-control input-sm" value="{{ first_name }}" />
                </div>
                
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >นามสกุล</label>
                    <input type="text" id="e_last_name" name="last_name" class="form-control input-sm" value="{{ last_name }}" />
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >เบอร์โทรศัพท์</label>
                    <input type="text" id="e_phone" name="phone" class="form-control input-sm" style="text-align:center;"  value="{{ phone }}" />
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >ที่อยู่</label>
                    <input type="text" id="e_address" name="address" class="form-control input-sm" value="{{ address }}" />
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >จังหวัด</label>
					<select id="e_province" name="province" class="form-control input-sm" >{{{ province }}}</select>
                </div>
                
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >รหัสไปรษณีย์</label>
                    <input type="text" id="e_post_code" name="post_code" class="form-control input-sm" value="{{ post_code }}"  />
                </div>
                
                
                <div class="col-lg-4 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label>อีเมล์</label>
                    <input type="text" id="e_email" name="email" class="form-control input-sm" value="{{ email }}" />
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label>วันที่เริ่มงาน</label>
                    <input type="text" id="e_start_date" name="start_date" class="form-control input-sm" placeholder="วว-ดด-ปปปป" style="text-align:center;" value="{{ start_date }}" />
                </div>
                
                <div class="col-lg-3 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >วันเกิด</label>
                    <input type="text" id="e_birthday" name="birthday" class="form-control input-sm" placeholder="วว-ดด-ปปปป" style="text-align:center;" value="{{ birthday }}" />
                </div>
				
				<div class="col-lg-6 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >สังกัด</label>
                    <input type="text" id="e_shop" name="e_shop" class="form-control input-sm" value="{{ shop }}" />
                </div>
                
                <div class="col-lg-3 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label style="display:block;">สถานะ</label>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm {{ enable }}" id="btn_e_active" onclick="edit_enable()"><i class="fa fa-check"></i></button>
                        <button type="button" class="btn btn-sm {{ disable }}" id="btn_e_disactive" onclick="edit_disable()"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                    <label >&nbsp;</label>
                    <button type="button" id="btn_e_save" onclick="update_row()" class="btn btn-success btn-xs btn-block"><i class="fa fa-save"></i>&nbsp; บันทึก</button>
                </div>
                <input type="hidden" id="e_active" name="active" value="{{ active }}" />
				<input type="hidden" id="id_employee" name="id_employee" value="{{ id }}" />
				<input type="hidden" id="e_id_shop" name="id_shop" value="{{ id_shop }}" />
                </form>
                </div><!--/ Row -->
</script>
<script id="template" type="text/x-handlebars-template">
	<tr id="row_{{ id }}">
    	<td style="vertical-align:middle;" align="center">{{ id }}</td>
        <td style="vertical-align:middle;"><span id="code_{{ id }}">{{ code }}</span></td>
        <td style="vertical-align:middle;"><span id="name_{{ id }}">{{ name }}</span></td>
        <td style="vertical-align:middle;"><span id="email_{{ id }}">{{ email }}</span></td>
		<td style="vertical-align:middle;"><span id="phone_{{ id }}">{{ phone }}</span></td>
		<td style="vertical-align:middle;"><span id="start_{{ id }}">{{ start_date }}</span></td>        
        <td style="vertical-align:middle;" align="center"><span id="active_{{ id }}">{{{ active }}}</td>                   
        <td align="right" style="vertical-align:middle;">
		<?php if($edit) : ?><button type="button" class="btn btn-warning btn-minier" onclick="edit_row({{id}})"><i class="fa fa-pencil"></i></button><?php endif; ?>
        <?php if($delete) : ?> <button type="button" class="btn btn-danger btn-minier" onclick="confirm_delete({{id}})"><i class="fa fa-trash"></i></button> <?php endif; ?>
		</td>
    </tr>
</script>

<script>
$("#shop").autocomplete({
	source: '<?php echo base_url(); ?>admin/tool/getShop',
	autoFocus: true,
	close: function(){
		var rs = $(this).val();
		if( rs == 'No data found' )
		{
			$(this).val('');
			$("#id_shop").val('');
		}
		else
		{
			var rs = rs.split(' | ');
			$(this).val(rs[1]); // [0] = code [1] = name	[2] = id_shop
			$("#id_shop").val(rs[2]);
		}
	}
});

$("#birthday").mask("99-99-9999");
$("#start_date").mask("99-99-9999");

function confirm_delete(id)
{
	swal({
		  title: "แน่ใจนะ?",
		  text: "คุณกำลังจะลบพนักงาน โปรดตรวจสอบให้แน่ใจว่าคุณต้องการลบจริง ๆ",
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
		url:"<?php echo $this->home; ?>/delete_employee/"+id,
		type:"GET", cache:"false", success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs == "success")
			{
				$("#row_"+id).remove();
				swal({ title: "สำเร็จ", text: "ลบพนักงานเรียบร้อยแล้ว", type : "success", timer: 1000 });
			}
			else if( rs == 'transection' )
			{
				swal("ไม่อนุญาติให้ลบ", "พนักงานมีความเกี่ยวข้องกับระบบไม่อนุญาติให้ลบ", "error");
			}
			else
			{
				swal("ไม่สำเร็จ", "ลบพนักงานไม่สำเร็จ", "error");
			}
		}
	});
}

function edit_row(id)
{
	$.ajax({
		url:"<?php echo $this->home; ?>/get_employee/"+id,
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
				$("#e_birthday").mask("99-99-9999");
				$("#e_start_date").mask("99-99-9999");
				$("#editer_modal").modal("show");
				$("#e_shop").autocomplete({
					source: '<?php echo base_url(); ?>admin/tool/getShop',
					autoFocus: true,
					close: function(){
						var rs = $(this).val();
						if( rs == 'No data found' )
						{
							$(this).val('');
							$("#e_id_shop").val('');
						}
						else
						{
							var rs = rs.split(' | ');
							$(this).val(rs[1]); // [0] = code [1] = name	[2] = id_shop
							$("#e_id_shop").val(rs[2]);
						}
					}
				});	
			}else{
				swal("ไม่พบข้อมูล");	
			}
		}
	});
}

function update_employee(id)
{
	$("#editer_modal").modal("hide");
	var shop = $('#e_shop').val();
	if( shop == '' ){ $("#id_shop").val(0); }
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/update", type: "POST", cache:"false",
		data: $("#edit_form").serialize(),
		success: function(rs)
		{
			load_out();
			var rs = $.trim(rs);
			if(rs == "success")
			{
				$("#code_"+id).text($("#e_code").val());
				$("#name_"+id).text($("#e_first_name").val()+" "+$("#e_last_name").val());
				$("#email_"+id).text($("#e_email").val());
				$("#phone_"+id).text($("#e_phone").val());
				$("#shop_"+id).text($("#e_shop").val());
				if($("#e_active").val() == 1 ){ var icon = "<i class='fa fa-check' style='color:green;'></i>"; }else{ var icon = "<i class='fa fa-times' style='color:red;'></i>"; }
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
	var id				= $("#id_employee").val();
	var code			= $("#e_code").val();
	var first_name 	= $("#e_first_name").val();
	var last_name	= $("#e_last_name").val();
	if( id == "" ){ swal("ไม่พบ ID ของพนักงาน"); return false; }
	if( code == ""){ swal("กรุณาระบุรหัสพนักงาน"); return false; }
	if( first_name == ""){ swal("กรุณาระบุชื่อพนักงาน"); return false; }
	$.ajax({
		url:"<?php echo $this->home; ?>/valid_data/"+code+"/"+first_name+"/"+last_name+"/"+id,
		type: "GET", cache: "false", 
		success: function(rs)
		{
			var rs = $.trim(rs);
			if(rs == "ok")
			{
				update_employee(id);
			}
			else if( rs == "duplicate_name")
			{
				swal("ชื่อพนักงานซ้ำ");
			}
			else if( rs == "duplicate_code" )
			{
				swal("รหัสพนักงานซ้ำ");
			}
			else
			{
				swal("ไม่สามารถแก้ไขข้อมูลพนักงานได้");
			}
		}
	});
}

function save()
{
	var code 		= $("#code").val();
	var first_name 	= $("#first_name").val();
	if(code == ""){ swal({ title : "ข้อมูลไม่ครบ", text :"รหัสพนักงานไม่ถูกต้อง", type: "error" }); return false; }
	if(first_name == ""){ swal({ title : "ข้อมูลไม่ครบ", text :"ชื่อพนักงานจำเป็นต้องกรอก", type: "error" }); return false; }
	$("#btn_save").attr("disabled", "disabled");
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/add_employee",
		type: "POST", cache: "false", data: $("#add_form").serialize(),
		success: function(rs)
		{
			load_out();
			$("#btn_save").attr("disabled", "disabled");
			var rs = $.trim(rs);
			if(rs == "fail")
			{
				swal("Error !!", "ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่ภายหลัง", "error");
				$("#btn_save").removeAttr("disabled");
			}else if( rs == "duplicate_code"){
				swal("รหัสพนักงานซ้ำ !!", "ไม่อนุญาติให้รหัสพนักงานซ้ำกัน", "error");	
				$("#btn_save").removeAttr("disabled");
			}else if( rs == "duplicate_name"){
				swal("พนักงานซ้ำ !!", "ชื่อพนักงานมีอยู่ในระบบแล้ว", "error");	
				$("#btn_save").removeAttr("disabled");
			}else{
				var source 		= $("#template").html();
				var data 			= $.parseJSON(rs);
				var template 	= Handlebars.compile(source);
				var row 			= template(data);
				$("#rs").prepend(row);
				clear_field();
				$("#btn_save").removeAttr("disabled");
			}
		}
	});
}

function clear_field()
{
	$("#code").val("");
	$("#first_name").val("");
	$("#last_name").val("");
	$("#phone").val("");
	$("#address").val("");
	$("#province").val("");
	$("#post_code").val("");
	$("#email").val("");
	$("#start_date").val("");
	$("#birthday").val("");
	$("#shop").val('');
	$("#id_shop").val('');
	enable();
	$("#code").focus();	
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

$("#shop").autocomplete({
	source: '<?php echo base_url(); ?>admin/tool/getShopNameAndId',
	autoFocus: true,
	close: function(event, ui){
		var rs = $.trim($(this).val());
		if( rs != 'ไม่พบข้อมูล'){
			var arr 		= rs.split(' | ');
			var name	 	= arr[1];
			var id			= arr[2];
			$(this).val(name);
			$("#id_shop").val(id);
		}
	}
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

function set_focus(name)
{
	$("#"+name).focus();
}



</script>

<?php endif; ?>