<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tag'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo $this->home; ?>">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
             	<button class='btn btn-success' <?php echo $access['add']; ?> onclick="save();"><i class='fa fa-save'></i>&nbsp; บันทึก</button>   	
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<?php echo form_open($this->home."/add_category", "class='form-horizontal'"); ?>
<div class="col-sm-12">
	<div class="row" <?php echo $access['add']; ?>>
		<div class="profile-user-info profile-user-info-striped ">
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                <input type="hidden" name="add" value="1"  />
                <button type="button" id="btn_submit" style="display:none;">submit</button>
                <input type="text" style="display:none" />
				<input type="hidden" id="valid_name" value="0" /> 
                	<label>ชื่อหมวดหมู่</label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="category_name" id="category_name" class="input-xlarge" autocomplete="off" required="required" />
                </div>
            </div><!-- End group -->
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label>แสดงผล</label>
                </div>
                <div class="profile-info-value">
					 <label for="visible_yes" style="margin-right:20px">
                          <input type="radio" name="visible" value="1" id="visible_yes" checked class="ace">
                    	 <span class="lbl"> <i class="fa fa-check fa-2x" style="color:#6C3"></i></span>
                    </label>
					 <label for="visible_no">
                          <input type="radio" name="visible" value="0" id="visible_no" class="ace">
                    	 <span class="lbl"> <i class="fa fa-remove fa-2x" style="color:#F30"></i></span>
                    </label>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label>เปิดใช้งาน</label>
                </div>
                <div class="profile-info-value">
                	<label for="active_yes" style="margin-right:20px">
                          <input type="radio" name="active" value="1" id="active_yes" checked class="ace">
                    	 <span class="lbl"> <i class="fa fa-check fa-2x" style="color:#6C3"></i></span>
                    </label>
					 <label for="active_no">
                          <input type="radio" name="active" value="0" id="active_no" class="ace">
                    	 <span class="lbl"> <i class="fa fa-remove fa-2x" style="color:#F30"></i></span>
                    </label>
                </div>
            </div><!-- End group -->
              <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label>หมวดหมู่หลัก</label>
                </div>
                <div class="profile-info-value">
               		<label for="home">
                          <input type="radio" name="id_parent" value="1" id="home" checked="checked" class="ace">
                    	 <span class="lbl"> <?php echo "HOME"; ?></span>
                    </label>
               		<ul class='tree tree-selectable'><!--lavel1 -->
                    <?php if($cate != false ) : ?>
                    <?php foreach($cate as $rs):  ?>
                    	<li class="tree-branch tree-open">
                        	<div class="tree-branch-header">
                            	<span class="tree-branch-name">
                    				<span class="tree-label">
                                   		 <label for="<?php echo $rs->category_name;?>">
                                             <input type="radio" name="id_parent" value="<?php echo $rs->id_category;?>" id="<?php echo $rs->category_name;?>" class="ace">
                                             <span class="lbl"> <?php echo $rs->category_name."<br>"; ?></span>
                                        </label>
                                    </span>
                                </span>
                        	</div>
                            <?php $c =& get_instance(); $c->display_children($rs->id_category); ?>  
                        </li>
                    <?php endforeach; ?>
                    <?php endif; ?>                    
                    </ul>
                </div>
            </div><!-- End group -->
		</div>
	</div><!-- End of row -->
</div>
<?php echo form_close(); ?>
<script>
function save()
{
	var name = $("#valid_name").val();
	if(name == 1){
		swal("ชื่อซ้ำ","มีชื่อนี้อยู่ในระบบแล้ว","error");
	}else{
	var btn = $("#btn_submit");
	btn.attr("type", "submit");
	btn.click();
	btn.attr("type","button");
	}
}

$("#category_name").keyup(function(e){
	var name = $(this).val();
	$.ajax({
		url: "<?php echo $this->home."/valid_name/"; ?>"+name, type:"GET", cache:false,
		success: function(rs){
			$("#valid_name").val(rs);
		}
	});
});
</script>
<?php endif; ?>