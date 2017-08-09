<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Please sign in</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-part2.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-rtl.css" />
        <script src="<?php echo base_url(); ?>assets/js/sweet-alert.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.md5.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweet-alert.css">

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-ie.css" />
		<![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout blur-login" >
		<div class="main-container">
        <?php if($this->session->flashdata("error") != NULL) :?>
					<input type="hidden" id="error" value="<?php echo $this->session->flashdata("error"); ?>">
                <?php elseif( $this->session->flashdata("success") != NULL ) : ?>
                	<input type="hidden" id="success" value="<?php echo $this->session->flashdata("success"); ?>">
                <?php elseif( $this->session->flashdata("info") != NULL ) : ?>
                	<input type="hidden" id="info" value="<?php echo $this->session->flashdata("info"); ?>">
               <?php endif; ?>
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-github green"></i>
									<span class="red">POS</span>
									<span class="white" id="id-text2">Online</span>
								</h1>
								<h4 class="blue" id="id-company-text">&copy; <?php echo getConfig('COMPANY_NAME'); ?></h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Please Enter Your Information
											</h4>

											<div class="space-6"></div>

											<?php echo form_open("authentication/validate_credentials"); ?>
												<fieldset>
													<label class="block clearfix">
                                                    	<div id="user-group" class="form-group" style="margin-bottom:0px;">
														<span class="block input-icon input-icon-right">
															<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" autocomplete="off" />
															<i class="ace-icon fa fa-user"></i>
														</span>
                                                        </div>
													</label>

													<label class="block clearfix">
                                                    	<div id="pass-group" class="form-group" style="margin-bottom:0px;">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" id="password" class="form-control" placeholder="Password"  />
															<i class="ace-icon fa fa-lock"></i>
                                                            
														</span>
                                                        </div>
													</label>

													
                                                    <span id="warning-label" class="help-block text-warinig bigger-110 orange" style="visibility:hidden;">
                                                   	 <i class="fa fa-exclamation-triangle"></i><span id="warning-text" style="padding-left:10px;"> Invalid user name or password</span>
                                                    </span>
                                                   

													<div class="clearfix">
														<button type="button" id="login_btn" class="width-35 pull-right btn btn-sm btn-primary" onClick="checkLogin()">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											<?php echo form_close(); ?>

											
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div style="width:100%; text-align:center;">
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													I forgot my password
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

							</div><!-- /.position-relative -->

							<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Dark</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Blur</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Light</a>
								&nbsp; &nbsp; &nbsp;
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
			
function check_error(){
    if($("#error").length){
		var mess = $("#error").val();
		swal(mess);
	}else if($("#success").length){
		var mess = $("#success").val();
		swal({ title: "สำเร็จ", text: mess, timer: 1000, type: "success"});
	}else if($("#info").length){
		var mess = $("#info").val();
		swal({ title: "สำเร็จ", text: mess, html : true, type: "success"});
	}
}  

function checkLogin()
{
	var user_name	= $("#user_name").val();
	var password	= $("#password").val();
	if( password == '' && user_name == '' ){
		$("#warning-text").text('กรุณาป้อนชื่อผู้ใช้งานและรหัสผ่าน');
		$("#warning-label").css('visibility', '');
		$("#user-group").addClass('has-error');
		$("#pass-group").addClass('has-error');
	}else if( user_name == '' ){
		$("#warning-text").text('กรุณาป้อนชื่อผู้ใช้งาน');
		$("#warning-label").css('visibility', '');
		$("#user-group").addClass('has-error');
		$("#pass-group").removeClass('has-error');
	}else if( password == '' ){
		$("#warning-text").text('กรุณาป้อนรหัสผ่าน');
		$("#warning-label").css('visibility', '');
		$("#user-group").removeClass('has-error');
		$("#pass-group").addClass('has-error');
	}else{
		$("#warning-label").css('visibility', 'hidden');
		$("#user-group").removeClass('has-error');
		$("#pass-group").removeClass('has-error');
		var password = MD5(password);
		$.ajax({
			url:"<?php echo base_url(); ?>authentication/validate_credentials",
			type:"POST", cache:"false", data:{ 'user_name' : user_name, 'password' : password },
			success: function(rs){
				var rs = $.trim(rs);
				if( rs == 'success' ){
					window.location.href = '<?php echo base_url(); ?>welcome';
				}else if( rs == 'fail' ){
					$("#warning-text").text('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
					$("#warning-label").css('visibility', 'visible');
				}else{
					$("#warning-text").text('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
					$("#warning-label").css('visibility', 'visible');
				}
			}
		});
	}
}

$("#user_name").keyup(function(e) {
    if( e.keyCode == 13 ){
		$("#password").focus();
	}
});

$("#password").keyup(function(e){
	if( e.keyCode == 13 ){
		checkLogin();
	}
});
</script>
	</body>
</html>
