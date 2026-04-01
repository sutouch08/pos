<?php $this->load->view('include/header'); ?>
<?php $this->load->view('masters/customers/style'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
	</div>
</div>
<hr />
<?php
$tab1 = $tab == 'infoTab' ? 'active in' : '';
$tab2 = $tab == 'addressTab' ? 'active in' : '';
?>
<div class="row">
	<div class="col-lg-1-harf col-md-2 col-sm-2 padding-5 padding-top-15 hidden-xs">
		<ul id="myTab1" class="setting-tabs width-100" style="margin-left:0px;">
			<li class="li-block <?php echo $tab1; ?>" onclick="changeURL('<?php echo $ds->id; ?>','infoTab')">
				<a href="#infoTab" data-toggle="tab" style="text-decoration:none;">ข้อมูลลูกค้า</a>
			</li>			
			<li class="li-block <?php echo $tab2; ?>" onclick="changeURL('<?php echo $ds->id; ?>','addressTab')">
				<a href="#addressTab" data-toggle="tab" style="text-decoration:none;">ที่อยู่</a>
			</li>
		</ul>
	</div>

	<div class="col-xs-12 padding-5 visible-xs">
		<ul id="myTab1" class="setting-tabs width-100" style="margin-left:0px;">
			<li class="li-block inline border-1 <?php echo $tab1; ?>" onclick="changeURL('<?php echo $ds->id; ?>','infoTab')">
				<a href="#infoTab" data-toggle="tab" style="text-decoration:none;">ข้อมูลลูกค้า</a>
			</li>			
			<li class="li-block inline border-1 <?php echo $tab2; ?>" onclick="changeURL('<?php echo $ds->id; ?>','addressTab')">
				<a href="#addressTab" data-toggle="tab" style="text-decoration:none;">ที่อยู่</a>
			</li>
		</ul>
	</div>

	<div class="divider visible-xs" style="margin-bottom:0px;"></div>

	<div class="col-lg-10-harf col-md-10 col-sm-10 col-xs-12 padding-5" id="content-block" style="min-height:600px; ">
		<div class="tab-content" style="border:0">
			<div class="tab-pane fade <?php echo $tab1; ?>" id="infoTab">
				<?php $this->load->view('masters/customers/customers_info'); ?>
			</div>			
			<div class="tab-pane fade <?php echo $tab2; ?>" id="addressTab">
				<?php $this->load->view('masters/customers/customers_address'); ?>
			</div>
		</div>
	</div><!--/ col-sm-9  -->
</div><!--/ row  -->

<input type="hidden" id="customer-code" value="<?php echo $ds->code; ?>">

<script src="<?php echo base_url(); ?>scripts/masters/customers.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/masters/address.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/masters/customer_address.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>