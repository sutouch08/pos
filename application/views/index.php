<?php if($this->session->userdata("id_user") == null && !$this->input->cookie("id_user")){ redirect(base_url()."authentication"); } ?>
<!DOCTYPE HTML>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../favicon.ico" />
    <title><?php if(isset($page_title)){ echo $page_title; }else{ echo "Welcome"; } ?></title>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/paginator.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootflat.min.css" rel="stylesheet">
     <link rel="stylesheet" href="<?php  echo base_url();?>assets/css/jquery-ui-1.10.4.custom.min.css" />
     <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    
  	<script src="<?php  echo base_url();?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/iCheck/icheck.js"></script>
     
    
    
    <!-- SB Admin CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/template.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/all.css?v=1.0.2" rel="stylesheet">
   

</head>
<body style='padding-top:0px;'>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style='position:relative;'>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
<!--            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; ??????????????????</a></li>     -->
			</ul>
         	<ul class='nav navbar-top-links navbar-right'>
            	<li><a style='color:#FFF; background-color:transparent;' href="<?php echo base_url(); ?>authentication/logout"><i class='fa fa-sign-out'></i> Sign out</a></li>
			</ul>
           </div> 
        </nav>
   </div>
    <!-- /#wrapper -->
<div class="container">
    <div class="row"> 
                <div class="col-lg-3 col-lg-offset-4">
                <div class="col-lg-12">
                	<h3 style="text-align:center">Welcome</h3>
       			 </div>
                <div class="col-lg-12">
                	<a href="shop/main"><button class="btn btn-success btn-block"><i class="fa fa-barcode fa-2x">&nbsp; POS</i></button></a>
                </div>
                <div class="col-lg-12">&nbsp;</div>
                <div class="col-lg-12">
                	<a href="#<?php // echo valid_menu(30,"management/index"); ?>"><button class="btn btn-primary btn-block"><i class="fa fa-pie-chart fa-2x">&nbsp; Management</i></button></a>
                </div>
                <div class="col-lg-12">&nbsp;</div>
                <div class="col-lg-12">
                	<a href="<?php echo valid_menu(1,"admin/main"); ?>"><button class="btn btn-danger btn-block"><i class="fa fa-gears fa-2x">&nbsp; Administrator</i></button></a>
                </div>
               
                </div>
      
    </div>
</div>
</body>
</html>