<!DOCTYPE HTML>
<html>
<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
        
		<title><?php echo $this->title; ?></title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css" />
		<!-- page specific plugin styles -->
		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css" />
		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css " />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-ie.css" />
		<![endif]-->
		<!-- inline styles related to this page -->
		<!-- ace settings handler -->
		<script src="<?php echo base_url(); ?>assets/js/ace-extra.js"></script>
        <!-- basic scripts -->
		<!--[if !IE]>-->
		<!--<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery1.js'>"+"<"+"/script>");
		</script> -->
		<!-- <![endif]-->
		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  	<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js" ></script>
    <script src="<?php echo base_url(); ?>assets/js/ace/ace.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ace/elements.fileinput.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sweet-alert.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/handlebars-v3.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweet-alert.css">
    <style> .ui-helper-hidden-accessible { display:none; } .ui-autocomplete { z-index:100000; } </style>
		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
		<!--[if lte IE 8]>
		<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/respond.js"></script>
		<![endif]-->
	</head>

<!-- <body style='padding-top:0px;' onLoad="javascript:window.print();setFocus()"> -->
<body style='padding-top:0px; background-color:white;'>
<?php $paper_width = getConfig("PAPER_SIZE"); ?>
<div style="width:<?php echo $paper_width; ?>mm; padding:2px; margin-left:auto; margin-right:auto;">
    <div class="hidden-print" style="margin-bottom:25px; display:none;">
    		<button type="button" class="btn btn-primary btn-xs" id="btn_print" onClick="print_bill()" style="width:50%; float:left; margin-bottom:5px;"><i class="fa fa-print"></i>&nbsp; พิมพ์ ( space )</button>
    		<button type="button" class="btn btn-success btn-xs" id="btn_cancle" onClick="go_back()" style="width:50%; float:left; margin-bottom:5px;"><i class="fa fa-arrow-left"></i>&nbsp; กลับ ( esc )</button>
    </div>
    <center><img src="<?php echo base_url()."assets/images/logo.png"; ?>" style='width:150px; margin-bottom:15px;' /></center>
    
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:9px;" >
        <tr>
        <td align="left" style="width: 25%;">Date :</td>
        <td align="left"><?php echo thaiDate(NOW(), true);?></td>
        </tr>
       <tr>
        <td align="left" style="width: 25%;">No. :</td>
        <td align="left"><?php echo $order->reference;?></td>
        </tr>
        <tr>
        <td align="left">Staff :</td>
        <td align="left"><?php echo employee_name($order->id_employee);?></td>
        </tr>
        <tr>
    </table>   
    <hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />
    <?php 
		$total_qty = 0; 
		$total_price = 0;
		$total_amount = 0; 
		$discount = 0; 
	?>
    <table class="table" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:10px; margin-top:0px;">
        <thead>
        <th style="width:50%;">Items</th>
        <th style="width:15%; text-align:right;">Price</th>
        <th style="width:10%; text-align:right;">Qty</th>
        <th style="width:25%; text-align:right;">Amount</th>
        </thead>
        <?php foreach($detail as $ro) : ?>
        <tr height="20px">
            <td><?php echo $ro->item_code; ?></td>
            <td align="right"><?php echo number_format($ro->price,2); ?></td>
            <td align="right"><?php echo number_format($ro->qty); ?></td>
            <td align="right"><?php echo number_format($ro->price * $ro->qty,2); ?></td>
        </tr>
        <?php 
			$total_qty += $ro->qty;  
			$total_price += $ro->qty * $ro->price;
			$total_amount += $ro->total_amount; 
			$discount += $ro->total_discount; 
		?>
        <?php endforeach; ?>
        <tr height="20px">
            <td colspan="2" align="right">Total</td>
            <td align="right"><?php echo number_format($total_qty); ?></td>
            <td align="right"><?php echo number_format($total_price,2); ?></td>
        </tr>
        <?php if( $discount > 0 ) : ?>
        <tr height="20px">
            <td colspan="2" align="right">Discount</td>
            <td colspan="2" align="right"><?php echo number_format($discount, 2); ?></td>
        </tr>
        <tr height="20px">
            <td colspan="2" align="right">Grand Total</td>
            <td colspan="2" align="right"><?php echo number_format($total_amount, 2); ?></td>
        </tr>
        <?php endif; ?>
         
        <tr height="20px">
            <td colspan="2" align="right">Tender</td><td colspan="2" align="right"><?php echo number_format($payment->received, 2); ?></td>
        </tr>
        <tr height="20px">
            <td colspan="2" align="right">Return</td><td colspan="2" align="right"><?php echo number_format($payment->changed, 2); ?></td>
        </tr>
         <tr height="20px">
            <td colspan="2" align="right">Pay Mode</td><td colspan="2" align="right"><?php echo $payment->pay_by == 'credit_card' ? 'บัตรเครดิต' : 'เงินสด'; ?></td>
        </tr>
    </table>
    <center style="margin-bottom:10px;">********** THANK YOU **********</center>
    <center><img src="<?php echo base_url()."assets/barcode/barcode.php?text=".$order->reference; ?>" style='width:80%; height:50px; margin-bottom:5px;' /></center>
    
	
	</div>
<script>
	function print_bill()
	{
		window.print();
	}
	$(document).keyup(function(e){
		if(e.keyCode == 27)
		{
			window.close();
		}
		if(e.keyCode == 13)
		{
			print_bill();
		}
	});
	
	$(document).ready(function(e) {
        //print_bill();
    });
	
	function go_back()
	{
		window.location.href = "<?php echo $this->home; ?>";
	}
	
</script>
</body>
</html>