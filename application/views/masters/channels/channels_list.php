<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
</div>
<hr class="" />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>รหัส</label>
			<input type="text" class="form-control input-sm search" name="code" value="<?php echo $code; ?>" />
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>ชื่อ</label>
			<input type="text" class="form-control input-sm search" name="name" value="<?php echo $name; ?>" />
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label>สถานะ</label>
			<select class="form-control input-sm filter" name="active">
				<option value="all" <?php echo is_selected('all', $active); ?>>ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
				<option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="display-block not-show">button</label>
			<button type="submit" class="btn btn-xs btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
		</div>
		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="display-block not-show">button</label>
			<button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
		</div>
	</div>

	<input type="hidden" name="search" value="1" />
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>

<?php if ($this->pm->can_add) : ?>
	<?php $this->load->view('masters/channels/channels_add_control'); ?>
<?php endif; ?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
		<table class="table table-striped tableFixHead border-1" style="min-width:830px;">
			<thead>
				<tr>
					<th class="fix-width-80"></th>
					<th class="fix-width-40 middle text-center">#</th>
					<th class="fix-width-80 middle text-center">สถานะ</th>
					<th class="fix-width-150 middle">รหัส</th>
					<th class="fix-width-250 middle">ชื่อ</th>
					<th class="min-width-100"></th>
					<th class="fix-width-150">แก้ไขล่าสุด</th>
				</tr>
			</thead>
			<tbody id="data-table">
				<?php if (!empty($data)) : ?>
					<?php $no = $this->uri->segment($this->segment) + 1; ?>
					<?php foreach ($data as $rs) : ?>
						<tr id="row-<?php echo $rs->id; ?>">
							<td class="">
								<?php if ($this->pm->can_edit) : ?>
									<button type="button" class="btn btn-minier btn-warning" onclick="edit(<?php echo $rs->id; ?>)">
										<i class="fa fa-pencil"></i>
									</button>
								<?php endif; ?>
								<?php if ($this->pm->can_delete) : ?>
									<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?> | <?php echo $rs->name; ?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php endif; ?>
							</td>
							<td class="middle text-center no"><?php echo $no; ?></td>
							<td class="middle text-center"><?php echo is_active($rs->active); ?></td>
							<td class="middle"><?php echo $rs->code; ?></td>
							<td class="middle"><?php echo $rs->name; ?></td>
							<td class="middle"></td>
							<td class="middle"><?php echo thai_date($rs->date_upd, TRUE, '/'); ?></td>
						</tr>
						<?php $no++; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<script id="edit-row-template" type="text/x-handlebarsTemplate">
	<tr id="edit-row-{{id}}">
		<td colspan="2" class="middle text-center">
			<button type="button" class="btn btn-minier btn-success" onclick="update({{id}})">
				<i class="fa fa-save"></i> Save
			</button>
      <button type="button" class="btn btn-minier btn-default" onclick="cancel({{id}})">
        <i class="fa fa-close"></i>
      </button>
		</td>
		<td class="middle text-center">
			<label style="padding-top: 5px;">
				<input class="ace ace-switch ace-switch-6" id="status-{{id}}" type="checkbox" value="1" {{isChecked}} data-id="{{id}}" />
				<span class="lbl"></span>
			</label>
		</td>
		<td class="middle">
			<input type="text" class="form-control input-sm e" id="code-{{id}}" maxlength="20" value="{{code}}" disabled />
		</td>
		<td class="middle">
			<input type="text" class="form-control input-sm e" id="name-{{id}}" maxlength="100" value="{{name}}" data-id="{{id}}" data-name="{{name}}" />
		</td>		
		<td colspan="2" class="middle red padding-left-10" id="error-{{id}}"></td>
	</tr>		
</script>

<script id="row-template" type="text/x-handlebarsTemplate">
	<td class="middle">
		<?php if ($this->pm->can_edit) : ?>
			<button type="button" class="btn btn-minier btn-warning" onclick="edit({{id}})">
				<i class="fa fa-pencil"></i>
			</button>
		<?php endif; ?>
		<?php if ($this->pm->can_delete) : ?>
			<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete({{id}}, '{{code}} | {{name}}')">
				<i class="fa fa-trash"></i>
			</button>
		<?php endif; ?>
	</td>
	<td class="middle text-center no"></td>
	<td class="middle text-center">{{{is_active}}}</td>
	<td class="middle">{{code}}</td>
	<td class="middle">{{name}}</td>			
	<td class=""></td>
	<td class="middle">{{date_upd}}</td>
</script>

<script src="<?php echo base_url(); ?>scripts/masters/channels.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>