<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<?php if ($this->pm->can_add) : ?>
			<button type="button" class="btn btn-white btn-success top-btn" onclick="addNew()"><i class="fa fa-plus"></i> เพิ่มใหม่</button>
		<?php endif; ?>
	</div>
</div><!-- End Row -->
<hr />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
	<div class="row">
		<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>รหัส</label>
			<input type="text" class="form-control input-sm" name="code" id="code" value="<?php echo $code; ?>" />
		</div>

		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
			<label>ชื่อ</label>
			<input type="text" class="form-control input-sm" name="name" id="name" value="<?php echo $name; ?>" />
		</div>

		<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-4 padding-5">
			<label>ประเภท</label>
			<select class="form-control input-sm filter" name="role" id="role" onchange="getSearch()">
				<option value="all">ทั้งหมด</option>
				<?php echo select_warehouse_role($role); ?>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
			<label>สถานะ</label>
			<select class="form-control input-sm filter" name="active" id="active" onchange="getSearch()">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
				<option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
				<?php if($this->pm->can_approve) : ?>
					<option value="-1" <?php echo is_selected('-1', $active); ?>>Deleted</option>
				<?php endif; ?>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
			<label>ติดลบได้</label>
			<select class="form-control input-sm filter" name="auz" id="auz" onchange="getSearch()">
				<option value="all">ทั้งหมด</option>
				<option value="1" <?php echo is_selected('1', $auz); ?>>Yes</option>
				<option value="0" <?php echo is_selected('0', $auz); ?>>No</option>
			</select>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="submit" class="btn btn-xs btn-primary btn-block">Search</button>
		</div>

		<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
			<label class="display-block not-show">buton</label>
			<button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()">Reset</button>
		</div>
	</div>
	<input type="hidden" name="search" value="1" />
	<input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>" />
	<input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
</form>
<hr class="padding-5 margin-top-15">
<?php echo $this->pagination->create_links(); ?>
<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_role = get_sort('role', $order_by, $sort_by); ?>
<?php $sort_update = get_sort('update_at', $order_by, $sort_by); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
		<table class="table table-striped table-narrow dataTable border-1" style="min-width: 1150px;">
			<thead>
				<tr>
					<th class="fix-width-100 middle"></th>
					<th class="fix-width-40 middle text-center">#</th>
					<th class="fix-width-60 middle text-center">สถานะ</th>
					<th class="fix-width-120 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code', '<?php echo $sort_code; ?>')">รหัส</th>
					<th class="min-width-250 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name', '<?php echo $sort_name; ?>')">ชื่อ</th>
					<th class="fix-width-120 middle sorting <?php echo $sort_role; ?>" id="sort-role" onclick="sort('role', '<?php echo $sort_role; ?>')">ประเภท</th>
					<th class="fix-width-80 middle text-center">ติดลบได้</th>
					<th class="fix-width-80 middle text-center">โซน</th>
					<th class="fix-width-150 middle sorting <?php echo $sort_update; ?>" id="sort-update_at" onclick="sort('update_at', '<?php echo $sort_update; ?>')">แก้ไขล่าสุด</th>
					<th class="fix-width-150 middle ">แก้ไขโดย</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($list)) : ?>
					<?php $no = $this->uri->segment($this->segment) + 1; ?>
					<?php $roleName = warehouse_role_name_array(); ?>
					<?php foreach ($list as $rs) : ?>
						<?php $last_modified = empty($rs->update_at) ? thai_date($rs->create_at, TRUE) : thai_date($rs->update_at, TRUE); ?>
						<?php $modified_by = empty($rs->update_by) ? display_name($rs->create_by) : display_name($rs->update_by); ?>
						<tr id="row-<?php echo $rs->id; ?>">
							<td class="middle">
								<button type="button" class="btn btn-minier btn-info" title="View details" onclick="viewDetail(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>
								<?php if ($this->pm->can_edit) : ?>
									<button type="button" class="btn btn-minier btn-warning" title="Edit warehouse" onclick="edit(<?php echo $rs->id; ?>)"><i class="fa fa-pencil"></i></button>
								<?php endif; ?>
								<?php if ($rs->active != -1 && $this->pm->can_delete) : ?>
									<button type="button" class="btn btn-minier btn-danger" title="Delete warehouse" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php endif; ?>
								<?php if ($rs->active == -1 && $this->pm->can_approve) : ?>
									<button type="button" class="btn btn-minier btn-success" title="Restore this warehouse" onclick="restore(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>')">
										<i class="fa fa-refresh"></i>
									</button>
								<?php endif; ?>
							</td>
							<td class="middle text-center no"><?php echo $no; ?></td>
							<td class="middle text-center">
								<?php echo $rs->active == -1 ? '<i class="fa fa-minus-circle fa-lg grey" title="Deleted"></i>' : is_active($rs->active); ?>
							</td>
							<td class="middle"><?php echo $rs->code; ?></td>
							<td class="middle"><?php echo $rs->name; ?></td>
							<td class="middle"><?php echo empty($roleName[$rs->role]) ? '' : $roleName[$rs->role]; ?></td>
							<td class="middle text-center"><?php echo $rs->auz ? 'Yes' : 'No'; ?></td>
							<td class="middle text-center"><?php echo number($rs->zone_count); ?></td>
							<td class="middle"><?php echo $last_modified; ?></td>
							<td class="middle"><?php echo $modified_by; ?></td>
						</tr>
						<?php $no++; ?>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="12" class="middle text-center"><h5>ไม่พบข้อมูล</h5></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<script src="<?php echo base_url(); ?>scripts/masters/warehouse.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>