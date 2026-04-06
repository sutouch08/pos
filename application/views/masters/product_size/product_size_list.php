<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<?php if ($this->pm->can_add) : ?>
			<button type="button" class="btn btn-white btn-success top-btn" onclick="addNew()"><i class="fa fa-plus"></i> Add New</button>
		<?php endif; ?>
	</div>
</div><!-- End Row -->
<hr class="" />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>รหัส/ชื่อ</label>
			<input type="text" class="form-control input-sm sarch" name="code" value="<?php echo $code; ?>" autocomplete="off" autofocus />
		</div>

		<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label>สถานะ</label>
			<select class="form-control input-sm filter" name="active">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
				<option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
			</select>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>กลุ่มไซส์</label>
			<select class="form-control input-sm filter" name="group_id" id="group-id">
				<option value="">ทั้งหมด</option>
				<?php echo select_size_group($group_id); ?>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="button" class="btn btn-xs btn-primary btn-block" onclick="getSearch()"><i class="fa fa-search"></i> Search</button>
		</div>
		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
		</div>
	</div>
	<input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>">
	<input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>">
	<input type="hidden" name="search" value="1" />
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>

<!-- Sort list -->
<?php $sort_position = get_sort('position', $order_by, $sort_by); ?>
<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_member = get_sort('member', $order_by, $sort_by); ?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
		<table class="table tableFixHead dataTable border-1" style="min-width: 650px;">
			<thead>
				<tr>
					<th class="fix-width-60 middle"></th>
					<th class="fix-width-40 middle text-center">#</th>
					<th class="fix-width-60 middle text-center">สถานะ</th>
					<th class="fix-width-150 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code')">รหัส</th>
					<th class="fix-width-200 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name')">ชื่อ</th>
					<th class="fix-width-100 middle sorting <?php echo $sort_position; ?>" id="sort-position" onclick="sort('position')">ตำแหน่ง</th>
					<th class="fix-width-100 middle sorting <?php echo $sort_member; ?>" id="sort-member" onclick="sort('member')">สินค้า</th>
					<th class="min-width-100"></th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($data)) : ?>
					<?php $no = $this->uri->segment($this->segment) + 1; ?>
					<?php foreach ($data as $rs) : ?>
						<tr id="row-<?php echo $rs->id; ?>">
							<td class="middle">
								<?php if ($this->pm->can_edit) : ?>
									<button type="button" class="btn btn-minier btn-warning" onclick="edit('<?php echo $rs->id; ?>')">
										<i class="fa fa-pencil"></i>
									</button>
								<?php endif; ?>
								<?php if ($this->pm->can_delete) : ?>
									<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete('<?php echo $rs->id; ?>', '<?php echo escapeQuote($rs->name); ?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php endif; ?>
							</td>
							<td class="middle text-center no"><?php echo $no; ?></td>
							<td class="middle text-center"><?php echo is_active($rs->active); ?></td>
							<td class="middle"><?php echo $rs->code; ?></td>
							<td class="middle"><?php echo $rs->name; ?></td>
							<td class="middle"><?php echo $rs->position; ?></td>
							<td class="middle"><?php echo number($rs->member); ?></td>
							<td></td>
						</tr>
						<?php $no++; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$('#group-id').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/product_size.js"></script>

<?php $this->load->view('include/footer'); ?>