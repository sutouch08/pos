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
<hr />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
	<div class="row">
		<div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
			<label>Zone</label>
			<input type="text" class="form-control input-sm search-box" name="code" value="<?php echo $code; ?>" />
		</div>

		<div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
			<label>Name</label>
			<input type="text" class="form-control input-sm search-box" name="name" value="<?php echo $name; ?>" />
		</div>

		<div class="col-lg-3 col-md-6 col-sm-4-harf col-xs-6 padding-5">
			<label>Warehouse</label>
			<select class="form-control input-sm filter" name="warehouse_id" id="warehouse-id">
				<option value="all">ทั้งหมด</option>
				<?php echo select_warehouse($warehouse_id); ?>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-2 col-xs-6 padding-5">
			<label>Status</label>
			<select class="form-control input-sm filter" name="active">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
				<option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
				<?php if ($this->pm->can_approve) : ?>
					<option value="-1" <?php echo is_selected('-1', $active); ?>>Deleted</option>
				<?php endif; ?>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-2 col-xs-6 padding-5">
			<label>Pickface</label>
			<select class="form-control input-sm filter" name="pickface">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $pickface); ?>>Yes</option>
				<option value="0" <?php echo is_selected('0', $pickface); ?>>No</option>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-2 col-xs-6 padding-5">
			<label>Fastmove</label>
			<select class="form-control input-sm filter" name="fastmove">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $fastmove); ?>>Yes</option>
				<option value="0" <?php echo is_selected('0', $fastmove); ?>>No</option>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-2 col-xs-6 padding-5">
			<label>System</label>
			<select class="form-control input-sm filter" name="system">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $system); ?>>Yes</option>
				<option value="0" <?php echo is_selected('0', $system); ?>>No</option>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="submit" class="btn btn-xs btn-primary btn-block">Search</button>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()">Reset</button>
		</div>
	</div>
	<input type="hidden" name="search" value="1">
	<input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>">
	<input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>">
</form>
<hr class="margin-top-15 margin-bottom-15" />

<?php echo $this->pagination->create_links(); ?>
<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_warehouse = get_sort('warehouse_code', $order_by, $sort_by); ?>
<?php $sort_update = get_sort('update_at', $order_by, $sort_by); ?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
		<table class="table table-striped table-narrow dataTable border-1" style="min-width:1440px;">
			<thead>
				<tr>					
					<th class="fix-width-100 middle"></th>
					<th class="fix-width-40 middle text-center">#</th>
					<th class="fix-width-60 middle text-center">สถานะ</th>
					<th class="fix-width-200 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code', '<?php echo $sort_code; ?>')">รหัส</th>
					<th class="min-width-200 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name', '<?php echo $sort_name; ?>')">ชื่อ</th>
					<th class="fix-width-100 middle sorting <?php echo $sort_warehouse; ?>" id="sort-warehouse_code" onclick="sort('warehouse_code', '<?php echo $sort_warehouse; ?>')">คลังสินค้า</th>
					<th class="fix-width-60 middle text-center">Pickface</th>
					<th class="fix-width-60 middle text-center">Fast Move</th>
					<th class="fix-width-60 middle text-center">System</th>
					<th class="fix-width-150 middle sorting <?php echo $sort_update; ?>" id="sort-update" onclick="sort('update_at', '<?php echo $sort_update; ?>')">แก้ไขล่าสุด</th>
					<th class="fix-width-150 middle">แก้ไขโดย</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($list)) : ?>
					<?php $no = $this->uri->segment(4) + 1; ?>
					<?php foreach ($list as $rs) : ?>
					<?php $last_modify = empty($rs->update_at) ? thai_date($rs->create_at, TRUE) : thai_date($rs->update_at, TRUE); ?>
					<?php $modify_by = empty($rs->update_by) ? display_name($rs->create_by) : display_name($rs->update_by); ?>
						<tr id="row-<?php echo $rs->id; ?>">							
							<td class="middle">
								<button type="button" class="btn btn-minier btn-info" title="View" onclick="viewDetail(<?php echo $rs->id; ?>)">
									<i class="fa fa-eye"></i>
								</button>
								<?php if ($this->pm->can_edit) : ?>
									<button type="button" class="btn btn-minier btn-warning" title="Edit" onclick="edit(<?php echo $rs->id; ?>)">
										<i class="fa fa-pencil"></i>
									</button>
								<?php endif; ?>
								<?php if ( ! $rs->system && $rs->active != -1 && $this->pm->can_delete) : ?>
									<button type="button" class="btn btn-minier btn-danger" title="Delete" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php endif; ?>
								<?php if($rs->active == -1 && $this->pm->can_approve) : ?>
									<button type="button" class="btn btn-minier btn-success" title="Restore" onclick="restore(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>')">
										<i class="fa fa-refresh"></i>
									</button>
								<?php endif; ?>
							</td>
							<td class="middle text-center no"><?php echo $no; ?></td>
							<td class="middle text-center"><?php echo is_active($rs->active); ?></td>
							<td class="middle"><?php echo $rs->code; ?></td>
							<td class="middle"><?php echo $rs->name; ?></td>
							<td class="middle"><?php echo $rs->warehouse_code; ?></td>
							<td class="middle text-center"><?php echo is_active($rs->pickface, FALSE); ?></td>
							<td class="middle text-center"><?php echo is_active($rs->fastmove, FALSE); ?></td>
							<td class="middle text-center"><?php echo is_active($rs->system, FALSE); ?></td>
							<td class="middle"><?php echo $last_modify; ?></td>
							<td class="middle"><?php echo $modify_by; ?></td>
						</tr>
						<?php $no++; ?>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="11" class="text-center"><h5>--- ไม่พบรายการ ---</h5></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>


<script>
	$('#warehouse-id').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/zone.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>