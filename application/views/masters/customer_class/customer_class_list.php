<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
</div><!-- End Row -->
<hr class="" />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 padding-5">
			<label>รหัส/ชื่อ</label>
			<input type="text" class="form-control input-sm" name="code" value="<?php echo $code; ?>" />
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="submit" class="btn btn-xs btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
		</div>
		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
		</div>
	</div>
	<input type="hidden" name="search" value="1">
	<input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>" />
  <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
</form>
<hr class="margin-top-15">

<?php echo $this->pagination->create_links(); ?>

<?php if ($this->pm->can_add) : ?>
	<?php $this->load->view('masters/customer_class/add_control'); ?>
<?php endif; ?>

<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_update = get_sort('update_at', $order_by, $sort_by); ?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
		<table class="table tableFixHead dataTable border-1" style="min-width:640px;">
			<thead>
				<tr>
					<th class="fix-width-80 middle"></th>
					<th class="fix-width-40 middle text-center">#</th>
					<th class="fix-width-150 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code', '<?php echo $sort_code; ?>')">รหัส</th>
					<th class="fix-width-200 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name', '<?php echo $sort_name; ?>')">ชื่อ</th>
					<th class="min-width-100 middle"></th>
					<th class="fix-width-150 middle sorting <?php echo $sort_update; ?>" id="sort-update_at" onclick="sort('update_at', '<?php echo $sort_update; ?>')">แก้ไขล่าสุด</th>
					<th class="fix-width-150 middle">แก้ไขโดย</th>
				</tr>
			</thead>
			<tbody id="data-table">
				<?php if (!empty($data)) : ?>
					<?php $no = $this->uri->segment($this->segment) + 1; ?>
					<?php foreach ($data as $rs) : ?>
					<?php $last_modified = empty($rs->update_at) ? thai_date($rs->create_at, TRUE, '/') : thai_date($rs->update_at, TRUE, '/'); ?>
					<?php $modified_by = empty($rs->update_by) ? display_name($rs->create_by) : display_name($rs->update_by); ?>
						<tr id="row-<?php echo $rs->id; ?>">
							<td class="middle">
								<?php if ($this->pm->can_edit) : ?>
									<button type="button" class="btn btn-minier btn-warning" onclick="edit('<?php echo $rs->id; ?>')">
										<i class="fa fa-pencil"></i>
									</button>
								<?php endif; ?>
								<?php if ($this->pm->can_delete) : ?>
									<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code . ' | ' . $rs->name; ?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php endif; ?>
							</td>
							<td class="middle text-center no"><?php echo $no; ?></td>
							<td class="middle"><?php echo $rs->code; ?></td>
							<td class="middle"><?php echo $rs->name; ?></td>
							<td class="middle"></td>
							<td class="middle"><?php echo $last_modified; ?></td>
							<td class="middle"><?php echo $modified_by; ?></td>
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
			<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete('{{id}}', '{{code}} | {{name}}')">
				<i class="fa fa-trash"></i>
			</button>
		<?php endif; ?>
	</td>
	<td class="middle text-center no"></td>	
	<td class="middle">{{code}}</td>
	<td class="middle">{{name}}</td>		
	<td class="middle"></td>
	<td class="middle">{{last_modified}}</td>
	<td class="middle">{{modified_by}}</td>
</script>

<script src="<?php echo base_url(); ?>scripts/masters/customer_class.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>