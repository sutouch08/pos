<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>	
</div><!-- End Row -->
<hr />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
	<div class="row">
		<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>รหัส</label>
			<input type="text" class="form-control input-sm search" name="code" value="<?php echo $code; ?>" />
		</div>

		<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>ชื่อ</label>
			<input type="text" class="form-control input-sm search" name="name" value="<?php echo $name; ?>" />
		</div>

		<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>กลุ่ม</label>
			<select class="form-control input-sm filter" id="group-id" name="group">
				<option value="all">ทั้งหมด</option>
				<option value="NULL" <?php echo is_selected("NULL", $group); ?>>ไม่ระบุ</option>
				<?php echo select_color_group($group); ?>
			</select>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>สถานะ</label>
			<select class="form-control input-sm filter" name="active">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
				<option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="not-show">buton</label>
			<button type="button" class="btn btn-xs btn-primary btn-block" onclick="getSearch()"><i class="fa fa-search"></i> Search</button>
		</div>
		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="not-show">buton</label>
			<button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
		</div>
	</div>
	<input type="hidden" name="search" value="1" />
	<input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>" />
	<input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>

<?php if ($this->pm->can_add) : ?>
	<?php $this->load->view('masters/product_color/product_color_control'); ?>
<?php endif; ?>

<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_group = get_sort('group_name', $order_by, $sort_by); ?>
<?php $sort_member = get_sort('member', $order_by, $sort_by); ?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
		<table class="table table-striped dataTable tableFixHead border-1">
			<thead>
				<tr>
					<th class="fix-width-80 middle"></th>
					<th class="fix-width-40 middle text-center">#</th>
					<th class="fix-width-50 middle text-center">สถานะ</th>
					<th class="fix-width-150 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code')">รหัส</th>
					<th class="fix-width-250 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name')">ชื่อ</th>
					<th class="fix-width-150 middle sorting <?php echo $sort_group; ?>" id="sort-group_name" onclick="sort('group_name')">กลุ่ม</th>
					<th class="fix-width-100 middle text-center sorting <?php echo $sort_member; ?>" id="sort-member" onclick="sort('member')">สินค้า</th>
					<th class="min-width-100 middle text-right"></th>
				</tr>
			</thead>
			<tbody id="color-table">
				<?php if (!empty($data)) : ?>
					<?php $no = $this->uri->segment(4) + 1; ?>
					<?php foreach ($data as $rs) : ?>
						<tr id="row-<?php echo $rs->id; ?>">
							<td class="middle">
								<?php if ($this->pm->can_edit) : ?>
									<button type="button" class="btn btn-minier btn-warning" onclick="edit('<?php echo $rs->id; ?>')">
										<i class="fa fa-pencil"></i>
									</button>
								<?php endif; ?>
								<?php if ($this->pm->can_delete) : ?>
									<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete('<?php echo $rs->id; ?>', '<?php echo $rs->name; ?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php endif; ?>
							</td>
							<td class="middle text-center no"><?php echo $no; ?></td>
							<td class="middle text-center"><?php echo is_active($rs->active); ?></td>
							<td class="middle"><?php echo $rs->code; ?></td>
							<td class="middle"><?php echo $rs->name; ?></td>
							<td class="middle"><?php echo $rs->group_name; ?></td>
							<td class="middle text-center"><?php echo number($rs->member); ?></td>
							<td></td>
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
		<td class="middle text-center">
			<button type="button" class="btn btn-minier btn-success" onclick="update({{id}})">
				<i class="fa fa-save"></i> Save
			</button>
		</td>
		<td colspan="2" class="middle text-center">
			<label style="padding-top: 5px;">
				<input class="ace ace-switch ace-switch-6" id="active-{{id}}" type="checkbox" value="1" {{isChecked}} data-id="{{id}}" />
				<span class="lbl"></span>
			</label>
		</td>
		<td class="middle">
			<input type="text" class="form-control input-sm e" id="code-{{id}}" maxlength="20" value="{{code}}" data-id="{{id}}" data-code="{{code}}" />
		</td>
		<td class="middle">
			<input type="text" class="form-control input-sm e" id="name-{{id}}" maxlength="100" value="{{name}}" data-id="{{id}}" data-name="{{name}}" />
		</td>
		<td class="middle">
			<select class="form-control input-sm" id="group-id-{{id}}" data-id="{{id}}" data-group-id="{{group_id}}">
				<option value="">ไม่ระบุ</option>
				<?php echo select_color_group(); ?>
			</select>
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
			<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete('{{id}}', '{{name}}')">
				<i class="fa fa-trash"></i>
			</button>
		<?php endif; ?>
	</td>
	<td class="middle text-center no"></td>
	<td class="middle text-center">{{{is_active}}}</td>
	<td class="middle">{{code}}</td>
	<td class="middle">{{name}}</td>
	<td class="middle">{{group_name}}</td>	
	<td class="middle text-center">{{{member}}}</td>
	<td></td>
</script>

<script>
	$('#group-id').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/product_color.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>