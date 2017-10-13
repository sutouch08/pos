<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tint'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo $this->home; ?>">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
             	<button class='btn btn-success' <?php echo $access['edit']; ?> onclick="save();"><i class='fa fa-save'></i>&nbsp; บันทึก</button>   	
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<form id="data_form" method="post" action="<?php echo $this->home."/edit_color/".$id; ?>">
<input type="hidden" name="edit" value="1"  /><button type="button" id="btn_submit" style="display:none;">submit</button>
<input type="hidden" id="valid_code" value="0" />
<input type="hidden" id="valid_name" value="0" />
<input type="hidden" id="id_color" value="<?php echo $id; ?>" />
<div class='row'>
<div class='col-lg-3 col-lg-offset-4 col-xs-6 col-xs-offset-3'>
    <div class="col-xs-12">
    	<div class="input-group">
        	<span class="input-group-addon">รหัสสี</span>
            <input type="text" name="color_code" id="color_code" class="form-control" placeholder="รหัสสี เช่น AR, BL, 002 เป็นต้น" required="required" autofocus="autofocus" autocomplete="off" value="<?php echo $rs->color_code ; ?>"  />
        </div>
    </div>
    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12">
    	<div class="input-group">
        	<span class="input-group-addon">ชื่อสี</span>
            <input type="text" name="color_name" id="color_name" class="form-control" placeholder="ชื่อสี เช่น ดำ, แดง เป็นต้น" required="required" autofocus="autofocus" autocomplete="off" value="<?php echo $rs->color_name; ?>" />
        </div>
    </div>
    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12">
    	<div class="input-group">
        	<span class="input-group-addon">กลุ่มสี</span>
            <select name="id_color_group" class="form-control"><?php echo selectColorGroup($rs->id_color_group); ?></select>
        </div>
    </div>
        	
</div><!-- End col-lg-3 -->
</div><!-- End row -->
</form>
<?php endforeach; ?>
<?php endif; ?>
<script>
function save()
{
	var code = $("#valid_code").val();
	var name = $("#valid_name").val();
	if(code == 1 ){
		swal("รหัสซ้ำ","มีรหัสสีนี้อยู่ในระบบแล้ว","error");
	}else if(name == 1){
		swal("ชื่อซ้ำ","มีชื่อสีนี้อยู่ในระบบแล้ว","error");
	}else{
	var btn = $("#btn_submit");
	btn.attr("type", "submit");
	btn.click();
	btn.attr("type","button");
	}
}
$("#color_code").keyup(function(e) {
    var code = $(this).val();
	var id = $("#id_color").val();
	$.ajax({
		url:"<?php echo $this->home."/valid_code/"; ?>"+code+"/"+id, type:"GET", cache:false,
		success: function(rs){
			$("#valid_code").val(rs);
		}
	});			
});
$("#color_name").keyup(function(e){
	var name = $(this).val();
	var id = $("#id_color").val();
	$.ajax({
		url: "<?php echo $this->home."/valid_name/"; ?>"+name+"/"+id, type:"GET", cache:false,
		success: function(rs){
			$("#valid_name").val(rs);
		}
	});
});
</script>
<?php endif; ?>