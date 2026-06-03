<?php $this->load->view('include/header'); ?>
<script>
  var USE_STRONG_PWD = <?php echo getConfig('USE_STRONG_PWD'); ?>;
</script>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 padding-top-5">
    <h3 class="title">
      <a href="javascript:goBack()"><i class="fa fa-chevron-left"></i></a>&nbsp; <?php echo $this->title; ?>
    </h3>
  </div>
</div><!-- End Row -->
<hr />
<div class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">User name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="uname" class="form-control input-sm" maxlength="50" autocomplete="off" autofocus />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="uname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Display name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="dname" class="form-control input-sm" maxlength="100" autocomplete="off" />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="dname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">New password</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="password" id="pwd" class="form-control input-sm" autocomplete="off" />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="pwd-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Confirm password</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="password" id="cm-pwd" class="form-control input-sm" autocomplete="off" />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="cm-pwd-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Profile</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="profile" autocomplete="off">
        <option value="">Please, select profile</option>
        <?php if ($this->_SuperAdmin) : ?>
          <option value="-1">Super Admin</option>
        <?php endif; ?>
        <?php echo select_profile(); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="profile-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Employee</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="employee" autocomplete="off">
        <option value="">Please, select employee</option>
        <?php echo select_employee(); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="employee-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Salesperson</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="sale-id" autocomplete="off">
        <option value="">ไม่ระบุ</option>
        <?php echo select_saleman(); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Status</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="radio">
        <label>
          <input type="radio" class="ace" name="status" value="1" checked />
          <span class="lbl padding-5">&nbsp; Active</span>
        </label>
        <label>
          <input type="radio" class="ace" name="status" value="0" />
          <span class="lbl">&nbsp; Inactive</span>
        </label>
      </div>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red"></div>
  </div>

  <div class="form-group margin-top-15">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">&nbsp;</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label style="padding-top:7px; padding-left:10px;">
        <input type="checkbox" class="ace" id="force-reset" value="1" checked />
        <span class="lbl">&nbsp;&nbsp; force user to change password at next logon</span>
      </label>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red"></div>
  </div>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <?php if ($this->pm->can_add) : ?>
    <div class="form-group">
      <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">&nbsp;</label>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">        
        <button type="button" class="btn btn-white btn-success btn-100 btn-xs-block" onclick="add()"><i class="fa fa-plus"></i>&nbsp; Add</button>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
  $('#profile').select2();
  $('#employee').select2();
  $('#sale-id').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/users/users.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/users/user_add.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>