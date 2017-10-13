<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<script src="<?php echo base_url()."assets/js/jquery.slimscroll.js"; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url()."assets/css/bootstrap-multiselect.css"; ?>" />
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:10px;'></h3>
    </div>
    
    <div class="col-lg-6">
    	<p class='pull-right'>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:10px;' />

<div class='row'>
	<div class='col-xs-12'>
<!-- ******************************************************************  Start  ************************************************-->
<div class="widget-box">
	<div class="widget-header widget-header-blue widget-header-flat">
		<h4 class="widget-title lighter"><i class='fa fa-qrcode'></i>&nbsp; <?php echo label("combinations_generator"); ?></h4>
	</div>
    <div class="widget-body">
	<div class="widget-main">
	<!-- #section:plugins/fuelux.wizard -->
		<div id="fuelux-wizard-container">
			<div>
			<!-- #section:plugins/fuelux.wizard.steps -->
				<ul class="steps">
                	<li data-step="1" class="active" id="li1">
						<span class="step">1</span>
						<span class="title"><?php echo label("choose_format"); ?></span>
					</li>
                    <li data-step="2" id="li2">
						<span class="step">2</span>
						<span class="title"><?php echo label("choose_attribute"); ?></span>
					</li>
                    <li data-step="3" id="li3">
						<span class="step">3</span>
						<span class="title"><?php echo label("choose_images"); ?></span>
					</li> 
					<li data-step="4" id="li4">
						<span class="step">4</span>
						<span class="title"><?php echo label("start_generate"); ?></span>
					</li>  
				</ul>
			<!-- /section:plugins/fuelux.wizard.steps -->
			</div>
	<hr>

			<!-- #section:plugins/fuelux.wizard.container -->
            <form class="form-horizontal" role="form">
            <input type="hidden" id="color_c" value="0" />
            <input type="hidden" id="size_c" value="0" />
            <input type="hidden" id="attr_c" value="0"  />
			<div class="step-content pos-rel">
            	
				<div class="step-pane active" data-step="1" id="step1">
                	<div class="form-group">
                    	<label class="col-xs-6 col-sm-1 control-label no-padding-right" for="main_code"><?php echo label("main_code"); ?></label>
                        <div class="col-xs-12 col-sm-2"><input type="text" name="main_code" id="main_code" class="col-xs-12 col-sm-12" value="<?php echo get_product_code($data); ?>" /></div>
                        <label class="col-xs-6 col-sm-1 control-label no-padding-right" for="separator"><?php echo label("separator"); ?></label>
                        <div class="col-xs-12 col-sm-2">
                        	<select name="separator" id="separator" class="input-small">
                            	<option value="-">		-	 </option>
                                <option value="/">		/	 </option>
                                <option value=":">		:	 </option>
                                <option value="">	  none </option>
                            </select>
                        </div>
                        <label class="col-xs-6 col-sm-1 control-label no-padding-right" for="attribute_group"><?php echo label("use_attribute"); ?></label>
                        <div class="col-xs-12 col-sm-4">
                        	<div class="col-xs-6 col-sm-4">
                            	<div class="checkbox">
                                <label><input type="checkbox" class="ace" name="color" id="color" value="1" /><span class="lbl">&nbsp;<?php echo label("color"); ?></span></label>
                                </div>
                           </div>
                           
                           <div class="col-xs-6 col-sm-4">
                            	<div class="checkbox">
                                <label><input type="checkbox" class="ace" name="size" id="size" value="2" /><span class="lbl">&nbsp;<?php echo label("size"); ?></span></label>
                                </div>
                           </div>
                           
                           <div class="col-xs-6 col-sm-4">
                            	<div class="checkbox">
                                <label><input type="checkbox" class="ace" name="attribute" id="attribute" value="3" /><span class="lbl">&nbsp;<?php echo label("attrubute"); ?></span></label>
                                </div>
                           </div>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                    	<label class="col-xs-6 col-sm-1 control-label no-padding-right"><?php echo label("number"); ?></label>
                        <label class="col-xs-6 col-sm-1 control-label no-padding-right"><?php echo label("color"); ?></label>
                        <div class="col-xs-12 col-sm-1">
                        	<select name="color_no" id="color_no" class="input-small" disabled="disabled">
                            	<option value="1" selected="selected">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <label class="col-xs-6 col-sm-1 control-label no-padding-right"><?php echo label("size"); ?></label>
                        <div class="col-xs-12 col-sm-1">
                        	<select name="size_no" id="size_no" class="input-small" disabled="disabled">
                            	<option value="1">1</option>
                                <option value="2" selected="selected">2</option>
                                <option value="3" >3</option>
                            </select>
                        </div>
                        <label class="col-xs-6 col-sm-1 control-label no-padding-right"><?php echo label("attribute"); ?></label>
                        <div class="col-xs-12 col-sm-1">
                        	<select name="attribute_no" id="attribute_no" class="input-small" disabled="disabled">
                            	<option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3" selected="selected">3</option>
                            </select>
                        </div>
                    </div><!-- / form-group -->  
                </div><!-- / setp1 -->
                
                <div class="step-pane" data-step="2" id="step2">
                <div class="col-xs-12 col-sm-12">
                	<div class="col-xs-6 col-sm-4" id="color_box" style="display:none;">
                    	<div class="col-xs-2 col-sm-12"><div class="center"><h3 class="blue lighter"><?php echo label("color"); ?></h3></div></div>
                        <div class="col-xs-6 col-sm-3 scoller" style="border:1px solid #999;">
                         <?php if($color != false) : ?>
                         	<ul class="multiselect-container">
                         	<?php foreach($color as $c) : ?>
                            
                            	<li>
                                	<label class="checkbox"><input class="ace color" type="checkbox" name="colors[]" value="<?php echo $c->id_color; ?>" />
                                    <span class="lbl"></span>&nbsp;<?php echo $c->color_code. " : ". $c->color_name; ?>
                                	</label>
                                </li>
                            
                            <?php endforeach; ?>
                         	</ul>
                         <?php else: ?>
                         	<div class="center"><h3 class="blue lighter"><?php echo label("empty_content"); ?></h3></div>
                         <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-6 col-sm-4" id="size_box" style="display:none;">
                    	<div class="col-xs-2 col-sm-12"><div class="center"><h3 class="blue lighter"><?php echo label("size"); ?></h3></div></div>
                        <div class="col-xs-6 col-sm-3 scoller" style="border:1px solid #999;">
                            <?php if($size != false) : ?>
                         	<ul class="multiselect-container">
                         	<?php foreach($size as $s) : ?>
                            
                            	<li>
                                	<label class="checkbox"><input class="ace size" type="checkbox" name="sizes[]" value="<?php echo $s->id_size; ?>" />
                                    <span class="lbl"></span>&nbsp;<?php echo $s->size_code. " : ". $s->size_name; ?>
                                	</label>
                                </li>
                            
                            <?php endforeach; ?>
                         	</ul>
                         <?php else: ?>
                         	<div class="center"><h3 class="blue lighter"><?php echo label("empty_content"); ?></h3></div>
                         <?php endif; ?>
                        </div>
                    </div>
                 
                    <div class="col-xs-6 col-sm-4"  id="attribute_box" style="display:none;">
                    	<div class="col-xs-2 col-sm-12"><div class="center"><h3 class="blue lighter"><?php echo label("attribute"); ?></h3></div></div>
                        <div class="col-xs-6 col-sm-3 scoller" style="border:1px solid #999;">
                            <?php if($color != false) : ?>
                         	<ul class="multiselect-container">
                         	<?php foreach($attribute as $a) : ?>
                            
                            	<li>
                                	<label class="checkbox"><input class="ace attribute" type="checkbox" name="attributes[]" value="<?php echo $a->id_attribute; ?>" />
                                    <span class="lbl"></span>&nbsp;<?php echo $a->attribute_code. " : ". $a->attribute_name; ?>
                                	</label>
                                </li>
                            
                            <?php endforeach; ?>
                         	</ul>
                         <?php else: ?>
                         	<div class="center"><h3 class="blue lighter"><?php echo label("empty_content"); ?></h3></div>
                         <?php endif; ?>
                        </div>
                    </div>
                    </div>
                   <div class="col-xs-12 col-sm-12" style="margin-bottom:15px;">&nbsp;</div>
                </div><!-- / setp2 -->
                
                <div class="step-pane" data-step="3" id="step3">
                    
                </div><!-- / setp3 -->
                <div class="step-pane" data-step="4" id="step4">
                                                            
                </div><!-- / setp4 --> 
                
			</div><!-- / content -->
            </form>
			
		</div><!-- /section:plugins/fuelux.wizard.container -->
		<hr>
		<div class="wizard-actions">
		<!-- #section:plugins/fuelux.wizard.buttons -->
			<button id="prev_btn" disabled="disabled" class="btn btn-prev"><i class="ace-icon fa fa-arrow-left"></i>Prev</button>
            <button id="next_btn" class="btn btn-success btn-next" data-last="Finish">Next<i class="ace-icon fa fa-arrow-right icon-on-right"></i></button>
		<!-- /section:plugins/fuelux.wizard.buttons -->
		</div>
		<!-- /section:plugins/fuelux.wizard -->
		</div><!-- /.widget-main -->
	</div><!-- /.widget-body -->
</div><!-- /.widget-box -->


<!-- *****************************************************************  End  **************************************************-->    	
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<script>
$(document).ready(function(e) {
    var color_c = $("#color_c").val();
	var size_c = $("#size_c").val();
 	var attr_c = $("#attr_c").val();
	if(color_c == 0){ $("#color").prop("checked", false); }
	if(size_c == 0){ $("#size").prop("checked", false); }
	if(attr_c == 0){ $("#attribute").prop("checked", false); }
		
});

 
</script>
<script>
	var S1 = $("#step1");
	var S2 = $("#step2");
	var S3 = $("#step3");
	var S4 = $("#step4");
	var li1 = $("#li1");
	var li2 = $("#li2");
	var li3 = $("#li3");
	var li4 = $("#li4");
	var step = 1;
	function gotoStep()
	{
		if(step >4){ step = 4; }
		switch(step){
			case 1 :
				S1.addClass("active");
				S2.removeClass("active");
				S3.removeClass("active");
				S4.removeClass("active");
				li1.addClass("active");
				li2.removeClass("active");
				li3.removeClass("active");
				li4.removeClass("active");
				$("#prev_btn").attr("disabled","disabled");
				break;
			case 2 :
				S1.removeClass("active");
				S2.addClass("active");
				S3.removeClass("active");
				S4.removeClass("active");
				li1.addClass("active");
				li2.addClass("active");
				li3.removeClass("active");
				li4.removeClass("active");
				$("#prev_btn").removeAttr("disabled");
				break;
			case 3 :
				S1.removeClass("active");
				S2.removeClass("active");
				S3.addClass("active");
				S4.removeClass("active");
				li1.addClass("active");
				li2.addClass("active");
				li3.addClass("active");
				li4.removeClass("active");
				$("#prev_btn").removeAttr("disabled");
				$("#next_btn").html("Next <i class=\"ace-icon fa fa-arrow-right icon-on-right\"></i>");
				$("#next_btn").removeAttr("disabled");
				break;
			case 4 :
				S1.removeClass("active");
				S2.removeClass("active");
				S3.removeClass("active");
				S4.addClass("active");
				li1.addClass("active");
				li2.addClass("active");
				li3.addClass("active");
				li4.addClass("active");
				$("#prev_btn").removeAttr("disabled");
				$("#next_btn").html("Finish <i class=\"ace-icon fa fa-arrow-right icon-on-right\"></i>");
				$("#next_btn").attr("disabled", "disabled");
				break;
			default :
				S1.removeClass("active");
				S2.removeClass("active");
				S3.removeClass("active");
				S4.addClass("active");
				$("#prev_btn").removeAttr("disabled");
				break;
		}
	}
	
	function valid_step(){
		switch(step){
			case 1 :
				var isCheck = $("#color_c").val() + $("#size_c").val() + $("#attr_c").val();
				var mainCode = $("#main_code").val();
				if(mainCode ==""){
					swal("<?php echo label("error200"); ?>","<?php echo label("error202"); ?>","error");
					$("#main_code").focus();
					return false;
				}else if(isCheck < 1){
					swal("<?php echo label("error200"); ?>","<?php echo label("error203"); ?>","error");
					return false;
				}else{
					return true;
				}
			break;
			case 2 :
				var c = $("#color_c").val();
				var s = $("#size_c").val();
				var a = $("#attr_c").val();
				var isCheck =  c+s+a;  
				var valid_c = $('input[name="colors[]"]:checked').length;
				var valid_s = $('input[name="sizes[]"]:checked').length;
				var valid_a = $('input[name="attributes[]"]:checked').length;
				if(c>0 && valid_c<1){ 
					swal("<?php echo label("error200"); ?>","<?php echo label("error203"); ?>","error"); 
					return false;
				}else if(s>0 && valid_s<1){ 
					swal("<?php echo label("error200"); ?>","<?php echo label("error203"); ?>","error");
					return false;
				}else if(a>0 && valid_a<1){
					swal("<?php echo label("error200"); ?>","<?php echo label("error203"); ?>","error");
					return false;
				}else{
					return true;
				}
			break;
			case 3 :
				return true;
			break;
			default :
				return false;
			break;
		}//switch	
	}// function 
	$("#next_btn").click(function(e) {
		if(valid_step()){
        	step++;
			gotoStep();
		}
    });
	$("#prev_btn").click(function(e) {
        step--;
		gotoStep();
    });
	$("#color").change(function(e) {
        if($(this).is(":checked")){
			$("#color_no").removeAttr("disabled");
			$("#color_box").css("display","");
			$(".color").removeAttr("disabled");
			$("#color_c").val(1);
		}else if($(this).is(":not(:checked)")){
			$("#color_no").attr("disabled", "disabled");
			$("#color_box").css("display","none");
			$(".color").attr("disabled","disabled");
			$("#color_c").val(0);
		}
    });
	$("#size").change(function(e) {
        if($(this).is(":checked")){
			$("#size_no").removeAttr("disabled");
			$("#size_box").css("display","");
			$(".size").removeAttr("disabled");
			$("#size_c").val(1);
		}else if($(this).is(":not(:checked)")){
			$("#size_no").attr("disabled", "disabled");
			$("#size_box").css("display","none");
			$(".size").attr("disabled","disabled");
			$("#size_c").val(0);
		}
    });
	$("#attribute").change(function(e) {
        if($(this).is(":checked")){
			$("#attribute_no").removeAttr("disabled");
			$("#attribute_box").css("display","");
			$(".attribute").removeAttr("disabled");
			$("#attr_c").val(1);
		}else if($(this).is(":not(:checked)")){
			$("#attribute_no").attr("disabled", "disabled");
			$("#attribute_box").css("display","none");
			$(".attribute").attr("disabled", "disabled");
			$("#attr_c").val(0);
		}
    });
	$(".scoller").slimScroll({
		height: '400px',
		width: '100%',
		color: '#AAA',
		opacity: '0.3',
		railVisible: false,
		alwaysVisible: false,
		size: '10px', 
		distance: '10px'
		}); 
</script>
<?php endif; ?>