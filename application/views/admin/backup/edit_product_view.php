<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<?php $tab1 = ""; $tab2 = ""; $tab3 = ""; ?>
<?php if(isset($tab)){ if($tab == "tab2") : $tab2 = "active"; elseif($tab == "tab3") : $tab3 = "active"; else : $tab1 = "active"; endif; }else{ $tab1 = "active"; } ?>
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tag'></i>&nbsp; <?php echo label(strtolower($this->title)); ?></h3>
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
<div class="tabbale">
<ul class="nav nav-tabs" id="myTab">
	<li class="<?php echo $tab1; ?>"><a aria-expanded="true" data-toggle="tab" href="#tab1"><i class="green ace-icon fa fa-tags"></i>&nbsp;<?php echo label("products"); ?></a></li>
    <li class="<?php echo $tab2; ?>"><a aria-expanded="true" data-toggle="tab" href="#tab2"><i class="green ace-icon fa fa-leaf"></i>&nbsp;<?php echo label("attribute"); ?></a></li>
    <li class="<?php echo $tab3; ?>"><a aria-expanded="true" data-toggle="tab" href="#tab3"><i class="green ace-icon fa fa-file-image-o"></i>&nbsp;<?php echo label("images"); ?></a></li>
</ul>
<div class="tab-content">
<div id="tab1" class="tab-pane fade <?php echo $tab1; ?> in ">
<?php echo form_open($this->home."/edit_product/".$id_product, "class='form-horizontal'"); ?>
<input type="hidden" name="edit" value="1"  />
<button type="button" id="btn_submit" style="display:none;">submit</button>
<input type="text" style="display:none" /> 
<?php if($product_data != false) : ?>
<?php foreach($product_data as $pd) : ?>
	<div class="row" <?php echo $access['edit']; ?>>
		<div class="profile-user-info profile-user-info-striped ">
            <div class="profile-info-row">
                <div class="profile-info-name">
                	<label><?php echo label("product_code"); ?></label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="product_code" id="product_code" class="input-xlarge" value="<?php echo $pd->product_code; ?>" autocomplete="off" required="required" /><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row">
                <div class="profile-info-name">
                	<label><?php echo label("product_name_thai"); ?></label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="product_name[thai]" id="product_name[thai]" class="input-xlarge" value="<?php echo $pd->product_name; ?>" autocomplete="off" required="required" /><span style="color:red">  *</span>
                </div>
                </div><!-- End group -->
                <?php if( multi_lang() ) : ?>
                <div class="profile-info-row">
                <div class="profile-info-name">
                	<label style="width:200px;"><?php echo label("product_name_english"); ?></label>
                </div>
                <div class="profile-info-value">
                <input type="text" name="product_name[english]" id="product_name[english]" class="input-xlarge" value="<?php echo $pd->product_name_en; ?>" autocomplete="off" />
                </div>
                </div><!-- End group -->
                <?php endif; ?>
            
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("default_category"); ?></label>
                </div>
                <div class="profile-info-value">
					<select name="default_category" id="default_category" class="form-control input-xlarge">
                    	<?php echo selectCategory($pd->default_category_id); ?>
                    </select>
                </div>
            </div><!-- End group -->
              <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name" style="vertical-align:text-top;">
                	<label ><?php echo label("category"); ?></label>
                </div>
                <div class="profile-info-value">
               		<label for="home">
                          <input type="checkbox" name="category[]" value="1"  <?php echo category_product_check(1, $cate_data); ?>  id="home" class="ace">
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
                                             <input type="checkbox" name="category[]" value="<?php echo $rs->id_category;?>" id="<?php echo $rs->category_name;?>" class="ace"  <?php echo category_product_check($rs->id_category, $cate_data); ?>>
                                             <span class="lbl"> <?php echo $rs->category_name."<br>"; ?></span>
                                        </label>
                                    </span>
                                </span>
                        	</div>
                            <?php $c =& get_instance(); $c->display_category($rs->id_category, $cate_data); ?>  
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
					 <input type="text" name="cost" id="cost" class="input-xlarge" value="<?php echo $pd->product_cost; ?>" /><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("price"); ?></label>
                </div>
                <div class="profile-info-value">
					 <input type="text" name="price" id="price" class="input-xlarge" value="<?php echo $pd->product_price; ?>" /><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            
             <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("weight"); ?></label>
                </div>
                <div class="profile-info-value">
					 <input type="text" name="weight" id="weight" class="input-xlarge" value="<?php echo $pd->product_weight; ?>" />&nbsp;<?php echo label("kgs"); ?><span style="color:red">  *</span>
                </div>
            </div><!-- End group -->
            
            
            
            <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("visible"); ?></label>
                </div>
                <div class="profile-info-value">
					 <label for="visible_yes" style="margin-right:20px">
                          <input type="radio" name="visible" value="1" id="visible_yes" <?php echo isChecked(1, $pd->show); ?> class="ace">
                    	 <span class="lbl"> <i class="fa fa-check fa-2x" style="color:#6C3"></i></span>
                    </label>
					 <label for="visible_no">
                          <input type="radio" name="visible" value="0" id="visible_no" <?php echo isChecked(0, $pd->show); ?> class="ace">
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
                          <input type="radio" name="active" value="1" id="active_yes" <?php echo isChecked(1, $pd->active); ?> class="ace">
                    	 <span class="lbl"> <i class="fa fa-check fa-2x" style="color:#6C3"></i></span>
                    </label>
					 <label for="active_no">
                          <input type="radio" name="active" value="0" id="active_no" <?php echo isChecked(0, $pd->active); ?> class="ace">
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
                     	<option value="default" <?php echo isSelected("default", $pd->under_zero); ?> ><?php echo label("default"); ?></option>
                        <option value="yes" <?php echo isSelected("yes", $pd->under_zero); ?>><?php echo label("allow"); ?></option>
                        <option value="no" <?php echo isSelected("no", $pd->under_zero); ?>><?php echo label("not_allow"); ?></option>
                      </select>
                </div>
            </div><!-- End group -->
            
             <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("description_thai"); ?></label>
                </div>
                <div class="profile-info-value">
					 <textarea name="description[thai]" class="form-control" placeholder="Product Description"><?php echo $pd->description; ?></textarea>
                </div>
            </div><!-- End group -->
            <?php if( multi_lang() ) : ?>
             <div class="profile-info-row"><!-- group -->
                <div class="profile-info-name">
                	<label><?php echo label("description_english"); ?></label>
                </div>
                <div class="profile-info-value">
					 <textarea name="description[english]" class="form-control" placeholder="Product Description"><?php echo $pd->description_en; ?></textarea>
                </div>
            </div><!-- End group -->
            <?php endif; ?>
		</div>
	</div><!-- End of row -->

<?php endforeach; ?>
<?php else : ?>
<div class="col-lg-12"><h1 style="text-align:center">---------------  NO DATA  -----------------</h1></div>
<?php endif; ?>
<?php echo form_close(); ?>
</div>
<div id="tab2" class="tab-pane fade <?php echo $tab2; ?> in">
<?php if(!isset($attribute_data)) : ?>
<?php foreach($product_data as $pd) : ?>
<?php 
			$cost = $pd->product_cost; 
			$price = $pd->product_price;
			$weight = $pd->product_weight;
?>		
<?php endforeach; ?>	
<form id="attribute_form" method="post" action="<?php echo $this->home; ?>/add_attribute">
<input type="hidden" name="id_product" value="<?php echo $id_product; ?>"  />
	<h4 class="blue" align="left" style="margin-top:-5px">
    <?php echo label("generator_title_1"); ?>
    <a href="<?php echo $this->home."/generator/".$id_product; ?>" ><button type="button" class="btn btn-primary"><?php echo label("combinations_generator"); ?></button></a>
    <?php echo label("generator_title_2"); ?>
    </h4> 
    <hr class="blue" style="margin-top:-1px" />  
	<div class="profile-user-info profile-user-info-striped ">
            <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("reference")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"reference","id"=>"reference", "type"=>"text", "autocomplete"=>"off", "class"=>"input-xlarge", "required"=>"required"), ""); ?>
                </div>
            </div><!-- End group -->
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("cost")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"cost","id"=>"cost", "type"=>"text", "autocomplete"=>"off", "class"=>"input-medium", "required"=>"required"), $cost); ?>
                </div>
            </div><!-- End group -->
             <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("color")); ?>
                </div>
                <div class="profile-info-value">
                <select name="color" class="form-control input-xlarge">
                   <?php echo selectColor(); ?>
                </select>
                </div>
            </div><!-- End group -->
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("price")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"price","id"=>"price", "type"=>"text", "autocomplete"=>"off", "class"=>"input-medium", "required"=>"required"), $price); ?>
                </div>
            </div><!-- End group -->
            <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("size")); ?>
                </div>
                <div class="profile-info-value">
                    <select name="size" class="form-control input-xlarge">
                    <?php echo selectSize(); ?>
                    </select>
                </div>
            </div><!-- End group -->
            
             <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("weight")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"weight","id"=>"weight", "type"=>"text", "autocomplete"=>"off", "class"=>"input-medium", "required"=>"required"), $weight); ?>
                    <?php echo label("kgs"); ?>
                </div>
            </div><!-- End group -->
                        
            <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("attribute")); ?>
                </div>
                <div class="profile-info-value">
                	<select name="attribute" class="form-control input-xlarge">
                    <?php echo selectAttribute(); ?>
                    </select>
                </div>
            </div><!-- End group -->
           
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("barcode")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"barcode","id"=>"barcode", "type"=>"text", "autocomplete"=>"off", "class"=>"input-xlarge"), ""); ?>
                </div>
            </div><!-- End group -->
           
            
             <div class="col-lg-12" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("image")); ?>
                </div>
                <div class="profile-info-value" >
                <?php if($image_list != false) : ?>
                    <?php foreach($image_list as $im): ?>
                     <label for="<?php echo $im->id_image;?>">
						 <input type="radio" name="id_image" value="<?php echo $im->id_image;?>" id="<?php echo $im->id_image;?>" class="ace">
                         <span class="lbl">
                    	<img src="<?php echo image_path($im->id_image, 1); ?>"  />   
                        </span>
                     </label> 
                    <?php endforeach;?>
                <?php else : ?>
                <span> <?php echo label("no_image_available"); ?> </span>
                <?php endif; ?>
                </div>
            </div><!-- End group -->
             <div class="col-lg-12" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
               
                </div>
                <div class="profile-info-value" >
					<button  class='btn btn-success' <?php echo $access['add']; ?> type="button" onclick="valid_attribute()"><i class='fa fa-plus'></i>&nbsp; <?php echo label("add"); ?></button>
                    <button id="attribute_submit" class='btn btn-success' type="button" style="display:none">Submit</button>
                </div>
            </div><!-- End group -->
      </div>
   </form>
   <?php else : ?>	
   <?php foreach($attribute_data as $att) : ?>
<form id="attribute_form" method="post" action="<?php echo $this->home; ?>/edit_attribute/<?php echo $att->id_product; ?>/<?php echo $att->id_product_attribute; ?>">
<input type="hidden" name="id_product" value="<?php echo $att->id_product; ?>" />
<input type="hidden" name="id_product_attribute" id="id_product_attribute" value="<?php echo $att->id_product_attribute; ?>" />
<input type="hidden" name="edit" value="1" />

	<div class="profile-user-info profile-user-info-striped ">
            <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("reference")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"reference","id"=>"reference", "type"=>"text", "autocomplete"=>"off", "class"=>"input-xlarge", "required"=>"required"), $att->reference); ?>
                </div>
            </div><!-- End group -->
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("cost")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"cost","id"=>"cost", "type"=>"text", "autocomplete"=>"off", "class"=>"input-medium", "required"=>"required"), $att->cost); ?>
                </div>
            </div><!-- End group -->
             <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("color")); ?>
                </div>
                <div class="profile-info-value">
                <select name="color" class="form-control input-xlarge">
                   <?php echo selectColor($att->id_color); ?>
                </select>
                </div>
            </div><!-- End group -->
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("price")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"price","id"=>"price", "type"=>"text", "autocomplete"=>"off", "class"=>"input-medium", "required"=>"required"), $att->price); ?>
                </div>
            </div><!-- End group -->
            <div class="col-lg-6" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("size")); ?>
                </div>
                <div class="profile-info-value">
                    <select name="size" class="form-control input-xlarge">
                    <?php echo selectSize($att->id_size); ?>
                    </select>
                </div>
            </div><!-- End group -->
            
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("weight")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"weight","id"=>"weight", "type"=>"text", "autocomplete"=>"off", "class"=>"input-medium", "required"=>"required"), $att->weight); ?>
                    <?php echo label("kgs"); ?>
                </div>
            </div><!-- End group -->
            
            <div class="col-lg-6"  style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("attribute")); ?>
                </div>
                <div class="profile-info-value">
                	<select name="attribute" class="form-control input-xlarge">
                    <?php echo selectAttribute($att->id_attribute); ?>
                    </select>
                </div>
            </div><!-- End group -->
            
            <div class="col-lg-6"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("barcode")); ?>
                </div>
                <div class="profile-info-value">
                    <?php echo form_input(array("name"=>"barcode","id"=>"barcode", "type"=>"text", "autocomplete"=>"off", "class"=>"input-xlarge"), $att->barcode); ?>
                </div>
            </div><!-- End group -->

             <div class="col-lg-12" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
                	<?php echo form_label( label("image")); ?>
                </div>
                <div class="profile-info-value" >
                <?php if($image_list != false) : ?>
                    <?php foreach($image_list as $im): ?>
                     <label for="<?php echo $im->id_image;?>">
						 <input type="radio" name="id_image" value="<?php echo $im->id_image;?>" id="<?php echo $im->id_image;?>" class="ace" <?php echo isChecked($id_image, $im->id_image); ?> >
                         <span class="lbl">
                    	<img src="<?php echo image_path($im->id_image, 1); ?>"  />   
                        </span>
                     </label> 
                    <?php endforeach;?>
                <?php else : ?>
                <span> <?php echo label("no_image_available"); ?> </span>
                <?php endif; ?>
                </div>
            </div><!-- End group -->
             <div class="col-lg-12" style="padding-left:0px;"><!-- group -->
                <div class="profile-info-name">
               
                </div>
                <div class="profile-info-value" >
					<button class='btn btn-success' <?php echo $access['edit']; ?> type="button" onclick="valid_edit_attribute()"><i class='fa fa-plus'></i>&nbsp; <?php echo label("save"); ?></button>
                    <button id="attribute_submit" class='btn btn-success' type="button" style="display:none">Submit</button>
                </div>
            </div><!-- End group -->
      </div>
   </form>
   <?php endforeach; ?>
  <?php endif; ?>  
  <br />
   <div class="row" style="margin:0px 10px 0px 10px">
   <table class='table table-striped' id="ac_chart">
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%;'><?php echo label("image"); ?></th>
            <th style='width:15%;'><?php echo label("reference"); ?></th>
            <th style="width:15%; "><?php echo label("barcode"); ?></th>
            <th style='width:10%; text-align:center'><?php echo label("color"); ?></th>
            <th style="width:10%; text-align:center"><?php echo label("size"); ?></th>
            <th style='width:10%; text-align:center;'><?php echo label("attribute"); ?></th>
            <th style='width:8%; text-align:right'><?php echo label("cost"); ?></th>
            <th style="width:8%; text-align:right"><?php echo label("price"); ?></th>
            <th style="width:8%; text-align:right"><?php echo label("weight"); ?></th>
            <th style='text-align:center;'><?php echo label("action"); ?></th>
           </tr>
      </thead>
      <tbody>
<?php if($attribute != false) : ?>
    <?php $i = 0;?>
        <?php foreach($attribute as $at): ?>
        <?php $i++; ?>
        		<tr style="font-size:12px;">
                    <td style="vertical-align:middle;"><img src="<?php echo product_attribute_image($at->id_product_attribute, 1); ?>"  /></td>
                    <td style="vertical-align:middle;"><?php echo $at->reference; ?></td>
                    <td style="vertical-align:middle;"><?php echo $at->barcode; ?></td>
                    <td align="center" style="vertical-align:middle;"><?php echo get_color($at->id_color); ?></td>
                    <td align="center" style="vertical-align:middle;"><?php echo get_size($at->id_size); ?></td>
                    <td align="center" style="vertical-align:middle;"><?php echo get_attribute($at->id_attribute); ?></td>
                    <td align="right" style="vertical-align:middle;"><?php echo $at->cost; ?></td>
                    <td align="right" style="vertical-align:middle;"><?php echo $at->price; ?></td>
                    <td align="right" style="vertical-align:middle;"><?php echo $at->weight; ?></td>
                    <td align="center" style="vertical-align:middle;">
                    	<a href="<?php echo $this->home; ?>/edit_attribute/<?php echo $at->id_product; ?>/<?php echo $at->id_product_attribute; ?>" >
                        	<button type="button" class="btn btn-warning" <?php echo $access['edit']; ?> ><i class="fa fa-pencil"></i></button></a>
                        
                            <button type="button" class="btn btn-danger" onclick="confirm_delete('คุณแน่ใจว่าต้องการลบรายการนี้','การกระทำนี้ไม่สามารถกู้คืนได้','<?php echo $this->home; ?>/delete_attribute/<?php echo $at->id_product; ?>/<?php echo $at->id_product_attribute; ?>','ใช่ ต้องการลบ','ยกเลิก');"  <?php echo $access['delete']; ?>><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr><td colspan="11" align="center" ><h1><?php echo label("empty_content"); ?></h1></td></tr>
    <?php endif; ?>
		</table>
        </div>
</div>

<div id="tab3" class="tab-pane fade <?php echo $tab3; ?> in">
	<form method="post" action="<?php echo $this->home; ?>/upload" enctype="multipart/form-data">
    <?php echo form_input(array("name"=>"id_product","id"=>"id_product", "type"=>"hidden"), $id_product); ?>
    
    <table style="width:100%; border:0px; margin-bottom:10px;">
    <tr><td width="50%">
		<label class="ace-file-input ace-file-multiple">
        <input multiple="" id="id-input-file-3" type="file" name="file[]" />
    </label>
    </td>
    <td style="padding-left:15px; vertical-align:text-bottom;">
    
       <button type="submit" class="btn btn-app btn-purple btn-xs" style='display:none;' id="upload"  ><i class="ace-icon fa fa-cloud-upload bigger-80"></i>Upload</button>
   </td></tr></table>
		<table class='table table-striped' id="ac_chart" style="width:100%" >
    	<thead>
    	<tr style='font-size:12px;'>
			<th style='width:60%;'><?php echo label("image"); ?></th>
            <th style='width:10%; text-align: right;'><?php echo label("position"); ?></th>
            <th style="width:10%; text-align: center"><?php echo label("cover"); ?></th>
            <th style='width:10%; text-align:  center;'><?php echo label("action"); ?></th>
           </tr>
		</thead>
		<tbody> 
        <?php if($image_list !=false) : ?>
		<?php foreach($image_list as $im): ?>
        		<tr style="font-size:12px;">
                    <td style="vertical-align:middle;"><img src="<?php echo image_path($im->id_image,1); ?>"  /> </td>
                    <td style="vertical-align:middle;" align="right"><?php echo $im->position; ?></td>
                    <td align="center" style="vertical-align:middle;">
                    <?php if($im->cover != "1") : ?>
                    	<a href="<?php echo $this->home."/setCover/".$id_product."/".$im->id_image; ?>" ><?php echo label("set_as_cover"); ?></a>
                    <?php else : ?>
                    	<span id="cover" ><i class="fa fa-check fa-2x green"></i></span>
                    <?php endif; ?>
                    </td>
                    <td align="center" style="vertical-align:middle;"> 
                    <a href="<?php echo $this->home; ?>/delete_image/<?php echo $im->id_image; ?>/<?php echo $id_product; ?>">
                            <button type="button" class="btn btn-danger" onclick="return confirm('<?php echo label("delete_confirm"); ?>');"  <?php echo $access['delete']; ?>><i class="fa fa-trash"></i></button>
                            </a>
                            </td>
            </tr>
         <?php endforeach; ?>
         <?php else : ?>
         <tr style="font-size:12px;">
                    <td colspan="4" style="vertical-align:middle; text-align:center"><h1><?php echo label("no_image_available"); ?></h1></td>
                   
            </tr>
         <?php endif; ?>
                </tbody>
		</table>    
		</form>
        <div id="loader" style="position:absolute; padding: 15px 25px 15px 25px; background-color:#fff; opacity:0.0; box-shadow: 0px 0px 25px #CCC; top:-20px; display:none;">
        <center><i class="fa fa-spinner fa-5x fa-spin blue"></i></center><center>Uploading</center></div>
</div>
</div><!-- end of tab contents -->
</div><!-- end of tabbable -->
<script>
function save()
{
	var code = $("#product_code").val();
	$.ajax({
		url:"<?php echo $this->home."/valid_code/"; ?>"+code+"/<?php echo $id_product; ?>", type:"GET",cache:false,
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

function valid_attribute()
{
	var code = $("#reference").val();
	$.ajax({
		url:"<?php echo $this->home."/valid_attribute/"; ?>"+code, type:"GET",cache:false,
		success: function(rs){
			if(rs == 1 ){
				swal("<?php echo error("duplicate_reference"); ?>", "<?php echo error("reference_in_system"); ?>","error");
			}else{
				var btn = $("#attribute_submit");
				btn.attr("type", "submit");
				btn.click();
				btn.attr("type","button");
			}
		}
	});
}

function valid_edit_attribute()
{
	var code = $("#reference").val();
	var id = $("#id_product_attribute").val();
	$.ajax({
		url:"<?php echo $this->home."/valid_attribute/"; ?>"+code+"/"+id, type:"GET",cache:false,
		success: function(rs){
			if(rs == 1 ){
				swal("<?php echo error("duplicate_reference"); ?>", "<?php echo error("reference_in_system"); ?>","error");
			}else{
				var btn = $("#attribute_submit");
				btn.attr("type", "submit");
				btn.click();
				btn.attr("type","button");
			}
		}
	});
}

$('#id-input-file-3').ace_file_input({
					style:'well',
					btn_choose:'<?php echo label("upload_image");?>',
					btn_change:null,
					no_icon:'ace-icon ace-icon fa fa-picture-o',
					droppable:true,
					thumbnail:'small'
					,
				});
$('#id-input-file-3').click(function(){
	$("#upload").attr("style","");
});

$("#upload").click(function(){
	var x = ($("#tab3").width()/2)-50;
	$("#loader").css("display","");
	$("#loader").css("left",x);
	$("#loader").animate({opacity:0.8, top:100},300);
});

</script>
<?php endif; ?>