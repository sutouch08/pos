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
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; <?php echo label("cancle"); ?></button>
             </a>
             	<button class='btn btn-success' <?php echo $access['add']; ?> onclick="save();"><i class='fa fa-save'></i>&nbsp; <?php echo label("save"); ?></button>   	
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<?php echo form_open($this->home."/add_product", "class='form-horizontal'"); ?>
<input type="hidden" name="add" value="1"  />
<button type="button" id="btn_submit" style="display:none;">submit</button>
<input type="text" style="display:none" /> 
<div class="col-sm-12">
	<div class="row" <?php echo $access['add']; ?>>
		<div class="profile-user-info profile-user-info-striped ">
            <div class="profile-info-row">
                <div class="profile-info-name">
                	<label><?php echo label("product_code"); ?></label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="product_code" id="product_code" class="input-xlarge" autocomplete="off" required="required" /><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row">
                <div class="profile-info-name">
                	<label><?php echo label("product_name_thai"); ?></label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="product_name[thai]" id="product_name[thai]" class="input-xlarge" autocomplete="off" required="required" /><span style="color:red">  *</span>
                </div>
                </div><!-- End group -->
                <?php if( multi_lang() ) : ?>
                <div class="profile-info-row">
                <div class="profile-info-name">
                	<label style="width:200px;"><?php echo label("product_name_english"); ?></label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="product_name[english]" id="product_name[english]" class="input-xlarge" autocomplete="off" />
                </div>
                </div><!-- End group -->
                <?php endif; ?>
            
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("default_category"); ?></label>
                </div>
                <div class="profile-info-value">
					<select name="default_category" id="default_category" class="form-control input-xlarge">
                    	<?php echo selectCategory(); ?>
                    </select>
                </div>
            </div><!-- End group -->
              <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name" style="vertical-align:text-top;">
                	<label ><?php echo label("category"); ?></label>
                </div>
                <div class="profile-info-value">
               		<label for="home">
                          <input type="checkbox" name="category[]" value="1" id="home" class="ace">
                    	 <span class="lbl"> <?php echo "HOME"; ?></span>
                    </label>
               		<ul class='tree tree-selectable' style="margin-top:-10px; margin-left:7px; padding-top:10px;"><!--lavel1 -->
                    <?php if($cate != false ) : ?>
                    <?php foreach($cate as $rs):  ?>
                    	<li class="tree-branch tree-open">
                        	<div class="tree-branch-header">
                            	<span class="tree-branch-name">
                    				<span class="tree-label">
                                   		 <label for="<?php echo $rs->category_name;?>">
                                             <input type="checkbox" name="category[]" value="<?php echo $rs->id_category;?>" id="<?php echo $rs->category_name;?>" class="ace">
                                             <span class="lbl"> <?php echo $rs->category_name."<br>"; ?></span>
                                        </label>
                                    </span>
                                </span>
                        	</div>
                            <?php $c =& get_instance(); $c->display_category($rs->id_category); ?>  
                        </li>
                    <?php endforeach; ?>
                    <?php endif; ?>                    
                    </ul>
                </div>
            </div><!-- End group -->
            
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("cost"); ?></label>
                </div>
                <div class="profile-info-value">
					 <input type="text" name="cost" id="cost" class="input-xlarge" value="0.00" /><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("price"); ?></label>
                </div>
                <div class="profile-info-value">
					 <input type="text" name="price" id="price" class="input-xlarge" value="0.00" /><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("weight"); ?></label>
                </div>
                <div class="profile-info-value">
					 <input type="text" name="weight" id="weight" class="input-xlarge" value="0.00" />&nbsp;<?php echo label("kgs"); ?><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("visible"); ?></label>
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
                	<label><?php echo label("active"); ?></label>
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
                	<label><?php echo label("allow_under_zero"); ?></label>
                </div>
                <div class="profile-info-value">
					 <select name="allow_under_zero" class="form-control input-xlarge">
                     	<option value="default"><?php echo label("default"); ?></option>
                        <option value="yes"><?php echo label("allow"); ?></option>
                        <option value="no"><?php echo label("not_allow"); ?></option>
                      </select>
                </div>
            </div><!-- End group -->
            
             <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("description_thai"); ?></label>
                </div>
                <div class="profile-info-value">
					 <textarea name="description[thai]" class="form-control" placeholder="Product Description"></textarea>
                </div>
            </div><!-- End group -->
            <?php if( multi_lang() ) : ?>
             <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("description_english"); ?></label>
                </div>
                <div class="profile-info-value">
					 <textarea name="description[english]" class="form-control" placeholder="Product Description"></textarea>
                </div>
            </div><!-- End group -->
            <?php endif; ?>
		</div>
	</div><!-- End of row -->
</div>
<?php echo form_close(); ?>
<script>
function save()
{
	var code = $("#product_code").val();
	$.ajax({
		url:"<?php echo $this->home."/valid_code/"; ?>"+code, type:"GET",cache:false,
		success: function(rs){
			if(rs == 1 ){
				swal("รหัสซ้ำ","มีรหัสนี้อยู่ในระบบแล้ว","error");
			}else{
				var btn = $("#btn_submit");
				btn.attr("type", "submit");
				btn.click();
				btn.attr("type","button");
			}
		}
	});
}

</script>
<?php endif; ?>