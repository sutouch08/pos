<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
	</div>
</div>
<hr />
<form class="form-horizontal" style="padding-top:30px;">
	<?php if ($auto_gen != 'off') : ?>
		<div class="form-group">
			<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Prefix</label>
			<div class="col-lg-2 col-md-2-harf col-sm-2-harf col-xs-9">
				<select id="prefix" class="form-control input-sm">
					<option value="">Select Prefix</option>
					<?php echo select_customer_code_prefix(); ?>
				</select>
			</div>
			<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3 padding-5">
				<button type="button" class="btn btn-sm btn-white btn-success btn-block" onclick="genCustomerCode()">Generate</button>
			</div>
			<div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-xs-12" id="prefix-error"></div>
		</div>
	<?php endif; ?>
	<?php $attr = $auto_gen == 'force' ? 'disabled' : ''; ?>
	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
		<div class="col-lg-2 col-md-2-harf col-sm-2-harf col-xs-12">
			<input type="text" class="form-control input-sm" id="code" maxlength="20" value="" placeholder="Allow a-z, A-Z, -, _, ., @" autocomplete="off" autofocus <?php echo $attr; ?> />
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-3 padding-5">
			<button type="button" class="btn btn-sm btn-white btn-default" title="Clear" onclick="clearInputCode()"><i class="fa fa-refresh"></i></button>
		</div>
		<div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="code-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
		<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
			<input type="text" id="name" class="form-control input-sm" maxlength="100" value="" autocomplete="off" />
		</div>
		<div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="name-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เลขประจำตัว/Tax ID</label>
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
			<input type="text" id="tax-id" class="form-control input-sm" maxlength="32" value="" autocomplete="off" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มลูกค้า</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<select id="group" class="form-control input-sm">
				<option value="">เลือกรายการ</option>
				<?php echo select_customer_group(); ?>
			</select>
		</div>
		<?php if ($isAllow->group) : ?>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
				<button type="button" class="btn btn-sm btn-white btn-success" title="create new group" onclick="newGroup()"><i class="fa fa-plus"></i></button>
			</div>
		<?php endif; ?>
		<div class="error-block col-xs-12 col-sm-reset inline red" id="group-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เกรดลูกค้า</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<select id="grade" class="form-control input-sm">
				<option value="">เลือกรายการ</option>
				<?php echo select_customer_class(); ?>
			</select>
		</div>
		<?php if ($isAllow->class) : ?>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
				<button type="button" class="btn btn-sm btn-white btn-success" title="create new grade" onclick="newGrade()"><i class="fa fa-plus"></i></button>
			</div>
		<?php endif; ?>
		<div class="help-block col-xs-12 col-sm-reset inline red" id="class-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ประเภทลูกค้า</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<select id="kind" class="form-control input-sm">
				<option value="">เลือกรายการ</option>
				<?php echo select_customer_kind(); ?>
			</select>
		</div>
		<?php if ($isAllow->kind) : ?>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
				<button type="button" class="btn btn-sm btn-white btn-success" title="create new kind" onclick="newKind()"><i class="fa fa-plus"></i></button>
			</div>
		<?php endif; ?>
		<div class="help-block col-xs-12 col-sm-reset inline red" id="kind-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชนิดลูกค้า</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<select id="type" class="form-control input-sm">
				<option value="">เลือกรายการ</option>
				<?php echo select_customer_type(); ?>
			</select>
		</div>
		<?php if ($isAllow->type) : ?>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
				<button type="button" class="btn btn-sm btn-white btn-success" title="create new type" onclick="newType()"><i class="fa fa-plus"></i></button>
			</div>
		<?php endif; ?>
		<div class="help-block col-xs-12 col-sm-reset inline red" id="type-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พื้นที่ขาย</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<select id="area" class="form-control input-sm">
				<option value="">เลือกรายการ</option>
				<?php echo select_customer_area(); ?>
			</select>
		</div>
		<?php if ($isAllow->area) : ?>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
				<button type="button" class="btn btn-sm btn-white btn-success" title="create new area" onclick="newArea()"><i class="fa fa-plus"></i></button>
			</div>
		<?php endif; ?>
		<div class="help-block col-xs-12 col-sm-reset inline red" id="area-error"></div>
	</div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พนักงานขาย</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
			<select id="sale" class="form-control input-sm">
				<option value="">เลือกรายการ</option>
				<?php echo select_saleman(); ?>
			</select>
		</div>
		<div class="help-block col-xs-12 col-sm-reset inline red" id="sale-error"></div>
	</div>

	<div class="divider-hidden"></div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="padding-top:7px;">
			<label>
				<input type="radio" class="ace" name="active" value="1" checked />
				<span class="lbl">&nbsp; Active &nbsp;&nbsp;</span>
			</label>
			<label class="margin-left-20">
				<input type="radio" class="ace" name="active" value="0" />
				<span class="lbl">&nbsp; Inactive</span>
			</label>
		</div>
		<div class="help-block col-xs-12 col-sm-reset inline red" id="sale-error"></div>
	</div>

	<div class="divider-hidden"></div>
	<div class="divider-hidden"></div>
	<div class="divider-hidden"></div>

	<div class="form-group">
		<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"></label>
		<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-12">
			<button type="button" class="btn btn-sm btn-success btn-block" onclick="add()">Add</button>
		</div>
	</div>
	<input type="hidden" id="auto-gen" value="<?php echo $auto_gen; ?>">
</form>

<div class="modal fade" id="attribute-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 400px; max-width:95vw;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="attribute-modal-title">เพิ่มข้อมูล</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label no-padding-right">รหัส</label>
					<div class="col-lg-9 col-md-9 col-sm-10 col-xs-9">
						<input type="text" id="attribute-code" class="form-control input-sm input-medium" placeholder="" autocomplete="off" />
					</div>
					<div class="divider-hidden"></div>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label no-padding-right">ชื่อ</label>
					<div class="col-lg-9 col-md-9 col-sm-10 col-xs-9">
						<input type="text" id="attribute-name" class="form-control input-sm input-xlarge" placeholder="" autocomplete="off" />
						<input type="hidden" id="attribute-type" value="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-sm btn-primary" onclick="saveAttribute()">Add</button>
			</div>
		</div>
	</div>
</div>

<script>
	$('#group').select2();
	$('#kind').select2();
	$('#type').select2();
	$('#grade').select2();
	$('#area').select2();
	$('#sale').select2();
</script>

<script src="<?php echo base_url(); ?>scripts/masters/customers.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>