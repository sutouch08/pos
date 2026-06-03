<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 padding-top-5">
    <h3 class="title">
      <a href="javascript:goBack()"><i class="fa fa-chevron-left"></i></a>&nbsp; <?php echo $this->title; ?>
    </h3>
  </div>
</div><!-- End Row -->
<hr />
<form class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">User name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="uname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->uname; ?>" disabled />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="uname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Display name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="dname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->name; ?>" autofocus />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="dname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Profile</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="profile" autocomplete="off">
        <option value="">Please, select profile</option>
        <?php if ($this->_SuperAdmin) : ?>
          <option value="-1" <?php echo is_selected('-1', $user->id_profile); ?>>Super Admin</option>
        <?php endif; ?>
        <?php echo select_profile($user->id_profile); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="profile-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Employee</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="employee" autocomplete="off">
        <option value="">Please, select employee</option>
        <?php echo select_employee($user->emp_id); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="employee-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">พนักงานขาย</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="sale-id" autocomplete="off">
        <option value="">ไม่ระบุ</option>
        <?php echo select_saleman($user->sale_id); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Status</label>
    <div class="col-lg-3 col-md-3 col-sm-3-harf col-xs-12">
      <div class="radio">
        <label>
          <input type="radio" class="ace" name="status" value="1" <?php echo is_checked('1', $user->active); ?> />
          <span class="lbl padding-5"> Active</span>
        </label>
        <label>
          <input type="radio" class="ace" name="status" value="0" <?php echo is_checked('0', $user->active); ?> />
          <span class="lbl"> Suspend</span>
        </label>
      </div>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red"></div>
  </div>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <?php if($this->pm->can_edit) : ?>
    <div class="form-group">
      <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right"></label>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <button type="button" class="btn btn-white btn-success btn-100 btn-xs-block" onclick="update()"><i class="fa fa-save"></i>&nbsp; Save</button>       
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