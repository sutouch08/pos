<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<h3 class="title">
			<a href="<?php echo $this->home; ?>" class="pull-left margin-right-15">
				<i class="fa fa-chevron-left"></i>
			</a>
			<?php echo $this->title; ?>
		</h3>
	</div>
</div><!-- End Row -->
<hr />
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<div class="form-horizontal margin-top-30">
			<div class="form-group">
				<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ธนาคาร</label>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<select class="form-control input-sm e" id="bank">
						<option value="">เลือกธนาคาร</option>
						<?php echo select_bank(); ?>
					</select>
				</div>
				<div class="help-block col-xs-12 col-sm-reset inline red" id="bank-error"></div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เลขที่บัญชี</label>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="text" id="acc-no" class="form-control input-sm e" maxlength="20" autocomplete="off" placeholder="000-0-00000-0" />
				</div>
				<div class="help-block col-xs-12 col-sm-reset inline red" id="acc-no-error"></div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อบัญชี</label>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="text" id="acc-name" class="form-control input-sm e" maxlength="100" autocomplete="off" />
				</div>
				<div class="help-block col-xs-12 col-sm-reset inline red" id="acc-name-error"></div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สาขา</label>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="text" id="branch" class="form-control input-sm e" maxlength="100" autocomplete="off" />
				</div>
				<div class="help-block col-xs-12 col-sm-reset inline red" id="branch-error"></div>
			</div>

			<div class="divider-hidden"></div>

			<div class="form-group">
				<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-top:7px;">
					<label>
						<input type="radio" class="ace" name="status" value="1" checked />
						<span class="lbl">&nbsp; Active</span>
					</label>
					<label class="margin-left-15">
						<input type="radio" class="ace" name="status" value="0" />
						<span class="lbl">&nbsp; Inactive</span>
					</label>
				</div>
			</div>

		<?php if($this->pm->can_add) : ?>
			<div class="divider-hidden"></div>
			<div class="divider-hidden"></div>

			<div class="form-group">
				<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"></label>
				<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-12">
					<button type="button" class="btn btn-white btn-success btn-block" onclick="add()"><i class="fa fa-plus"></i> Add</button>
				</div>
			</div>
		<?php endif; ?>	
		</div><!-- End Form -->
	</div><!-- End Col -->
</div><!-- End Row -->


<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url(); ?>scripts/masters/bank_account.js?v=<?php echo date('Ymd'); ?>"></script>


<script>
	$('#bank').select2();
	$('#acc-no').mask('999-9-99999-9');
</script>

<?php $this->load->view('include/footer'); ?>