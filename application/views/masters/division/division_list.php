<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <h3 class="title">
      <?php echo $this->title; ?>
    </h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
  	<p class="pull-right top-p">
			<?php if($this->pm->can_add) : ?>
      <button type="button" class="btn btn-sm btn-success" onclick="addNew()"><i class="fa fa-plus"></i> Add new</button>
			<?php endif; ?>
    </p>
  </div>
</div><!-- End Row -->
<hr class="padding-5"/>
<form id="searchForm" method="post" action="<?php echo current_url(); ?>">
<div class="row">
	<div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-6">
    <label>Division</label>
    <input type="text" class="form-control input-sm search-box" name="name" value="<?php echo $name; ?>" />
  </div>

  <div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-6">
    <label>Department</label>
    <select class="form-control input-sm filter" name="department">
			<option value="all">ทั้งหมด</option>
			<?php echo select_department($department); ?>
		</select>
  </div>

	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6">
    <label>Status</label>
		<select class="form-control input-sm" name="status" onchange="getSearch()">
			<option value="all">ทั้งหมด</opton>
			<option value="1" <?php echo is_selected('1', $status); ?>>Active</option>
			<option value="0" <?php echo is_selected('0', $status); ?>>Inactive</option>
		</select>
  </div>

  <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3">
    <label class="display-block not-show">buton</label>
    <button type="submit" class="btn btn-xs btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
  </div>
	<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3">
    <label class="display-block not-show">buton</label>
    <button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
  </div>
</div>
<hr class="margin-top-15">
</form>
<?php echo $this->pagination->create_links(); ?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
		<table class="table table-striped table-bordered" style="min-width:800px;">
			<thead>
				<tr>
					<th class="fix-width-60 middle text-center">#</th>
					<th class="min-width-150 middle">Division</th>
					<th class="fix-width-200 middle">Department</th>
					<th class="fix-width-80 middle text-center">Status</th>
					<th class="fix-width-100 middle text-center">Create at</th>
					<th class="fix-width-100 middle text-center">Update at</th>
					<th class="fix-width-120"></th>
				</tr>
			</thead>
			<tbody>
<?php if(!empty($data))	: ?>
	<?php $no = $this->uri->segment($this->segment) + 1; ?>
	<?php foreach($data as $rs) : ?>
				<tr>
					<td class="middle text-center"><?php echo $no; ?></td>
					<td class="middle"><?php echo $rs->name; ?></td>
					<td class="middle"><?php echo $rs->department_name; ?></td>
					<td class="middle text-center"><?php echo is_active($rs->status); ?></td>
          <td class="middle text-center"><?php echo thai_date($rs->create_at, FALSE); ?></td>
          <td class="middle text-center"><?php echo thai_date($rs->update_at, FALSE); ?></td>
					<td class="text-right">
						<button type="button" class="btn btn-minier btn-info" title="Details" onclick="viewDetail(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>
					<?php if($this->pm->can_edit) : ?>
						<button type="button" class="btn btn-minier btn-warning" onclick="getEdit(<?php echo $rs->id; ?>)"><i class="fa fa-pencil"></i></button>
					<?php endif; ?>
					<?php if($this->pm->can_delete) : ?>
						<button type="button" class="btn btn-minier btn-danger" onclick="getDelete(<?php echo $rs->id; ?>, '<?php echo $rs->name; ?>')"><i class="fa fa-trash"></i></button>
					<?php endif; ?>
					</td>
				</tr>
				<?php $no++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?php $this->load->view('masters/division/division_modal'); ?>

<script src="<?php echo base_url(); ?>scripts/masters/division.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>
