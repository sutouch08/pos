<?php 
if($data != false)
{
	foreach($data as $rs)
	{
		$language = $rs->language;
		$id_employee = $rs->id_employee;
	}
}else{
	$language = "thai";
	$id_employee = "";
}
 ?>
<form class="form-horizontal">
<!-------------------------  Tab Menu  --------------------------->
<div class="tabbable">
<ul class="nav nav-tabs padding-16">
<li class="active"><a data-toggle="tab" href="#edit-basic"><i class="green ace-icon fa fa-pencil-square-o bigger-125"></i><?php echo label("basic_info"); ?></a></li>
<li><a data-toggle="tab" href="#edit-settings"><i class="purple ace-icon fa fa-cog bigger-125"></i><?php echo label("setting"); ?></a></li>
<li><a data-toggle="tab" href="#edit-password"><i class="blue ace-icon fa fa-key bigger-125"></i><?php echo label("password"); ?></a></li>
</ul>
<!-------------------------  End Tab Menu  --------------------------->

<div class="tab-content profile-edit-tab-content">
	<div id="edit-basic" class="tab-pane in active">
		<h4 class="header blue bolder smaller">General</h4>
        <div class="row">
        	<div class="col-xs-12 col-sm-2">
            	<label class="ace-file-input ace-file-multiple">
                	<input type="file" name="avatar_img">
                    <span class="profile-picture">
                    <img id="avatar" class="editable img-responsive editable-click editable-empty"
                           alt="<?php echo getEmployeeNameByIdUser($this->session->userdata("id_user")); ?>" 
                            src="<?php 
											$img = "images/employee/".$this->session->userdata("id_user").".jpg";
											$avatar = "images/employee/profile-pic.jpg";
											if(file_exists($img))
											{
											 echo base_url().$img;
											}else{
											 echo base_url().$avatar;
											}													  
									?>" width="180px">
					</span>
                </label>
			</div>
            <div class="vspace-12-sm"></div>
            <div class="col-xs-12 col-sm-10">
            	<div class="form-group">
                	<label class="col-sm-4 control-label no-padding-right" for="form-field-username">Username</label>
                    <div class="col-sm-8">
                    	<input class="col-xs-12 col-sm-10" id="form-field-username" placeholder="Username" value="alexdoe" type="text">
					</div>
				</div>
                <div class="space-4"></div>
                <div class="form-group">
                	<label class="col-sm-4 control-label no-padding-right" for="form-field-first">Name</label>
                    <div class="col-sm-8">
                    	<input class="input-small" id="form-field-first" placeholder="First Name" value="Alex" type="text">
                        <input class="input-small" id="form-field-last" placeholder="Last Name" value="Doe" type="text">
					</div>
				</div>
			</div>
		</div>
<hr>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-date">Birth Date</label>

																<div class="col-sm-9">
																	<div class="input-medium">
																		<div class="input-group">
																			<input class="input-medium date-picker" id="form-field-date" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" type="text">
																			<span class="input-group-addon">
																				<i class="ace-icon fa fa-calendar"></i>
																			</span>
																		</div>
																	</div>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right">Gender</label>

																<div class="col-sm-9">
																	<label class="inline">
																		<input name="form-field-radio" class="ace" type="radio">
																		<span class="lbl middle"> Male</span>
																	</label>

																	&nbsp; &nbsp; &nbsp;
																	<label class="inline">
																		<input name="form-field-radio" class="ace" type="radio">
																		<span class="lbl middle"> Female</span>
																	</label>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-comment">Comment</label>

																<div class="col-sm-9">
																	<textarea id="form-field-comment"></textarea>
																</div>
															</div>

															<div class="space"></div>
															<h4 class="header blue bolder smaller">Contact</h4>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input id="form-field-email" value="alexdoe@gmail.com" type="email">
																		<i class="ace-icon fa fa-envelope"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-website">Website</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input id="form-field-website" value="http://www.alexdoe.com/" type="url">
																		<i class="ace-icon fa fa-globe"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Phone</label>

																<div class="col-sm-9">
																	<span class="input-icon input-icon-right">
																		<input class="input-medium input-mask-phone" id="form-field-phone" type="text">
																		<i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
																	</span>
																</div>
															</div>

															<div class="space"></div>
															<h4 class="header blue bolder smaller">Social</h4>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-facebook">Facebook</label>

																<div class="col-sm-9">
																	<span class="input-icon">
																		<input value="facebook_alexdoe" id="form-field-facebook" type="text">
																		<i class="ace-icon fa fa-facebook blue"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-twitter">Twitter</label>

																<div class="col-sm-9">
																	<span class="input-icon">
																		<input value="twitter_alexdoe" id="form-field-twitter" type="text">
																		<i class="ace-icon fa fa-twitter light-blue"></i>
																	</span>
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-gplus">Google+</label>

																<div class="col-sm-9">
																	<span class="input-icon">
																		<input value="google_alexdoe" id="form-field-gplus" type="text">
																		<i class="ace-icon fa fa-google-plus red"></i>
																	</span>
																</div>
															</div>
														</div>

														<div id="edit-settings" class="tab-pane">
															<div class="space-10"></div>

															<div>
                                                            <h4 class="header blue bolder smaller"><?php echo label("language"); ?></h4>
																<label class="inline">
                                                                <input name="language" id="thai" class="ace" type="radio" value="thai" <?php echo isChecked("thai", $language); ?> >
																	<span class="lbl">&nbsp; ภาษาไทย</span>
																</label>
                                                                <label class="inline" style="width:30px;"></label>
                                                                <label class="inline">
                                                                <input name="language" id="english" class="ace lang" type="radio" value="english" <?php echo isChecked("english", $language); ?>>
																	<span class="lbl">&nbsp;English</span>
																</label>
															</div>

															<div class="space-8"></div>

															<div>
																<label class="inline">
																	<input name="form-field-checkbox" class="ace" type="checkbox">
																	<span class="lbl"> Email me new updates</span>
																</label>
															</div>

															<div class="space-8"></div>

															<div>
																<label>
																	<input name="form-field-checkbox" class="ace" type="checkbox">
																	<span class="lbl"> Keep a history of my conversations</span>
																</label>

																<label>
																	<span class="space-2 block"></span>

																	for
																	<input class="input-mini" maxlength="3" type="text">
																	days
																</label>
															</div>
														</div>

														<div id="edit-password" class="tab-pane">
															<div class="space-10"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">New Password</label>

																<div class="col-sm-9">
																	<input id="form-field-pass1" type="password">
																</div>
															</div>

															<div class="space-4"></div>

															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">Confirm Password</label>

																<div class="col-sm-9">
																	<input id="form-field-pass2" type="password">
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="clearfix form-actions">
													<div class="col-md-offset-3 col-md-9">
														<button class="btn btn-info" type="button">
															<i class="ace-icon fa fa-check bigger-110"></i>
															Save
														</button>

														&nbsp; &nbsp;
														<button class="btn" type="reset">
															<i class="ace-icon fa fa-undo bigger-110"></i>
															Reset
														</button>
													</div>
												</div>
											</form>
<script type="text/javascript">
	function update_lang(lang)
	{
		$.ajax({
			url:"<?php echo $this->home."/update_lang/"; ?>"+lang,
			type:"GET", cache:false,
			success: function(rs){ }
		});
	}
			
	$("#thai").change(function(e) {
        var lang = $(this).val();
		update_lang(lang);
    });
	
	$("#english").change(function(e) {
        var lang = $(this).val();
		update_lang(lang);
    });
</script>                                            