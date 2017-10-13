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
        	<a href="<?php echo $this->home."/color_group"; ?>">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
             	<button class='btn btn-success' <?php echo $access['edit']; ?> onclick="save();"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
             	
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<form id="data_form" method="post" action="<?php echo $this->home."/edit_group/".$id_color_group; ?>">
<input type="hidden" name="edit" value="1"  /><button type="button" id="btn_submit" style="display:none;">submit</button>
<?php if($data != "") : ?>
<?php foreach($data as $rs) : ?>
<div class='row'>
<div class='col-lg-3 col-lg-offset-4 col-xs-6 col-xs-offset-3'>
    <div class="col-xs-12">
    	<div class="input-group">
        	<span class="input-group-addon">ชื่อกลุ่มสี</span>
            <input type="hidden" id="id_color_group" name="id_color_group" value="<?php echo $rs->id_color_group; ?>"  />
            <input type="text" name="group_name" class="form-control" placeholder="Color Group" value="<?php echo $rs->group_name; ?>" required="required" autofocus="autofocus"  />
        </div>
    </div>
    <div class="col-xs-12">&nbsp;</div>
    <div class="col-xs-12">
    <div class="input-group">
    	<span class="input-group-addon" style="border:none; background-color:transparent;">Active</span>
        <div class="form-control" style="border:none;">
        <label style="margin-left:10px; margin-right:15px;"><input name="active" class="ace" type="radio" id="yes" value="1" <?php echo isChecked($rs->active, 1); ?> /><span class="lbl"> ใช่</span></label>
        <label style="margin-left:10px; margin-right:15px;"><input name="active" class="ace" type="radio" id="no" value="0" <?php echo isChecked($rs->active, 0); ?> /><span class="lbl"> ไม่ใช่</span></label>
        </div>
      </div>
    </div>
    	
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endforeach; ?>
<?php endif; ?>
</form>
<script>
function save()
{
	var btn = $("#btn_submit");
	btn.attr("type", "submit");
	btn.click();
	btn.attr("type","button");
}
</script>
<?php endif; ?>