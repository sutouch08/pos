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
  <div class="col-lg-2 col-md-2 col-sm-1-harf col-xs-6">
    <label>Username</label>
    <input type="text" class="form-control input-sm search-box" name="uname" value="<?php echo $uname; ?>" />
  </div>

  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
    <label>Display name</label>
    <input type="text" class="form-control input-sm search-box" name="dname" value="<?php echo $dname; ?>" />
  </div>

	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
    <label>User Group</label>
    <select class="form-control input-sm" name="group_id" onchange="getSearch()">
			<option value="all">ทั้งหมด</opton>
				<?php echo select_user_group($group_id); ?>
		</select>
  </div>

	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
    <label>Sales Person</label>
    <select class="form-control input-sm" name="sale_id" onchange="getSearch()">
    	<option value="all">ทั้งหมด</option>
			<?php echo select_saleman($sale_id); ?>
    </select>
  </div>

	<div class="col-lg-1-harf col-md-1 col-sm-1-harf col-xs-6">
    <label>Status</label>
		<select class="form-control input-sm" name="active" onchange="getSearch()">
			<option value="all">ทั้งหมด</opton>
			<option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
			<option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
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
					<th class="fix-width-150 middle">User name</th>
					<th class="min-width-100 middle">Display name</th>
					<th class="fix-width-150 middle text-center">User Group</th>
					<th class="min-width-100 middle">Sales Person</th>
					<th class="fix-width-60 middle text-center">Status</th>
					<th class="fix-width-120"></th>
				</tr>
			</thead>
			<tbody>
<?php if(!empty($data))	: ?>
	<?php $no = $this->uri->segment($this->segment) + 1; ?>
	<?php foreach($data as $rs) : ?>
				<tr>
					<td class="middle text-center"><?php echo $no; ?></td>
					<td class="middle"><?php echo $rs->uname; ?></td>
					<td class="middle"><?php echo $rs->display_name; ?></td>
					<td class="middle text-center"><?php echo $rs->group_name; ?></td>
					<td class="middle"><?php echo $rs->sale_name; ?></td>
					<td class="middle text-center"><?php echo is_active($rs->active); ?></td>
					<td class="text-right">
						<button type="button" class="btn btn-minier btn-info" title="Details" onclick="viewDetail('<?php echo $rs->id; ?>')"><i class="fa fa-eye"></i></button>
					<?php if($this->pm->can_add OR $this->pm->can_edit) : ?>
						<button type="button" class="btn btn-minier btn-purple" title="Reset password" onclick="getReset('<?php echo $rs->id; ?>')"><i class="fa fa-key"></i></button>
					<?php endif; ?>
					<?php if($this->pm->can_edit) : ?>
						<button type="button" class="btn btn-minier btn-warning" onclick="getEdit('<?php echo $rs->id; ?>')"><i class="fa fa-pencil"></i></button>
					<?php endif; ?>
					<?php if($this->pm->can_delete) : ?>
						<button type="button" class="btn btn-minier btn-danger" onclick="getDelete('<?php echo $rs->id; ?>', '<?php echo $rs->uname; ?>')"><i class="fa fa-trash"></i></button>
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

<?php $this->load->view('users/user_add_modal'); ?>
<?php $this->load->view('users/user_reset_pwd'); ?>

<script>
	var USE_STRONG_PWD = <?php echo getConfig('USE_STRONG_PWD'); ?>;
</script>

<script src="<?php echo base_url(); ?>scripts/users/users.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>
