<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if( !$this->session->userdata("id_user") ){ redirect(base_url()."authentication"); } ?>
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
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php  echo base_url();?>assets/css/jquery-ui-1.10.4.custom.min.css" />
    <link href="<?php echo base_url(); ?>assets/css/ace.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  	<script src="<?php  echo base_url();?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
</head>
<body style='padding-top:100px;'>

<div class="container">
    <div class="row"> 
                <div class="col-lg-3 col-lg-offset-4">
                <div class="row">
                <div class="col-lg-12">
                	<h3 style="text-align:center">Welcome</h3>
       			 </div>
                <div class="col-lg-12">
                	<button class="btn btn-success btn-xlg btn-block" onClick="goTo('<?php echo validMenu(1, 'shop/main'); ?>')">ขายสินค้า</button>
                </div>
                <div class="col-lg-12"><div class="space-6"></div></div>
                <div class="col-lg-12">
                	<button class="btn btn-primary btn-xlg btn-block" onClick="goTo('<?php echo validMenu(1, ''); ?>')">ผู้บริหาร</button>
                </div>
               <div class="col-lg-12"><div class="space-6"></div></div>
                <div class="col-lg-12">
                	<button class="btn btn-danger btn-xlg btn-block" onClick="goTo('<?php echo validMenu(1, 'admin/main'); ?>')">ผู้ดูแลระบบ</button>
                </div>
                 <div class="col-lg-12"><div class="space-6"></div></div>
                <div class="col-lg-12">
                	<button class="btn btn-link pull-right" onClick="logOut('<?php echo base_url(); ?>authentication/logout')">ออกจากระบบ</button>
                </div>
                </div>
               
                </div>
      
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/script/main.js"></script>
</body>
</html>