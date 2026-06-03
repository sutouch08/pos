<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 padding-top-5 text-center">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
</div><!-- End Row -->
<hr />
<form class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">User name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="uname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->uname; ?>" readonly />
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Display name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="dname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->name; ?>" readonly />
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Profile</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" class="form-control input-sm" value="<?php echo profile_name($user->id_profile); ?>" readonly />
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Employee</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" class="form-control input-sm" value="<?php echo employee_name($user->emp_id); ?>" readonly />
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">พนักงานขาย</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" class="form-control input-sm" value="<?php echo sale_name($user->sale_id); ?>" readonly />
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">สถานะ</label>
    <div class="col-lg-3 col-md-3 col-sm-3-harf col-xs-12 padding-top-7">
      <?php if ($user->active == 1) : ?>
        <span class="label label-success label-white middle"><i class="fa fa-check"></i> &nbsp; Active</span>
      <?php elseif ($user->active == -1) : ?>
        <span class="label label-inverse label-white middle"><i class="fa fa-minus-circle"></i> &nbsp; Deleted</span>
      <?php else : ?>
        <span class="label label-danger label-white middle"><i class="fa fa-times"></i> &nbsp; Inactive</span>
      <?php endif; ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">วันที่สร้าง</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10 font-size-12">
      <?php echo thai_date($user->create_at, TRUE); ?> โดย <b class="blue"><?php echo display_name($user->create_by); ?></b>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">แก้ไขล่าสุด</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10 font-size-12">
      <?php if ($user->update_at == NULL) : ?>
        -
      <?php else : ?>
        <?php echo thai_date($user->update_at, TRUE); ?> โดย <b class="blue"><?php echo display_name($user->update_by); ?></b>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($user->active == -1) : ?>
    <div class="form-group">
      <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">วันที่ลบ</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10 font-size-12">
        <?php if ($user->delete_at == NULL) : ?>
          -
        <?php else : ?>
          <?php echo thai_date($user->delete_at, TRUE); ?> โดย <b class="blue"><?php echo display_name($user->delete_by); ?></b>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="divider-hidden"></div>

  <?php if ($user->active == -1 && ($this->pm->can_delete && $this->pm->can_approve)) : ?>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="form-group">
      <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">&nbsp;</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <button type="button" class="btn btn-white btn-info btn-100" onclick="confirmRestore('<?php echo $user->uid; ?>', '<?php echo $user->uname; ?>')">
          <i class="fa fa-refresh"></i>&nbsp; Restore
        </button>
        <button type="button" class="btn btn-white btn-danger btn-100" onclick="confirmPermanentDelete('<?php echo $user->uid; ?>', '<?php echo $user->uname; ?>')">
          <i class="fa fa-trash"></i>&nbsp; Permanent Delete
        </button>
      </div>
    </div>
  <?php endif; ?>

  <input type="hidden" id="user-id" value="<?php echo $user->id; ?>" />
  <input type="hidden" name="uid" id="uid" value="<?php echo $user->uid; ?>" />
</form>

<script>
  $('#profile').select2();
  $('#sale-id').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/users/users.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/users/user_add.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>