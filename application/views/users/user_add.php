<?php $this->load->view('include/header'); ?>
<script>
  var USE_STRONG_PWD = <?php echo getConfig('USE_STRONG_PWD'); ?>;
</script>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h4 class="title"><?php echo $this->title; ?></h4>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
  </div>
</div><!-- End Row -->
<hr />
<form class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">User name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="uname" class="form-control input-sm" autocomplete="off" autofocus />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="uname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Display name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="dname" class="form-control input-sm" autocomplete="off" />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="dname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">New password</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="password" id="pwd" class="form-control input-sm" autocomplete="off" />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="pwd-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Confirm password</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="password" id="cm-pwd" class="form-control input-sm" autocomplete="off" />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="cm-pwd-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Profile</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="profile" autocomplete="off">
        <option value="">Please, select profile</option>
        <?php echo select_profile(); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="profile-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พนักงานขาย</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="sale-id" autocomplete="off">
        <option value="">พนักงานขาย(ถ้าเป็น)</option>
        <?php echo select_saleman(); ?>
      </select>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Status</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <div class="radio">
        <label>
          <input type="radio" class="ace" name="status" value="1" checked />
          <span class="lbl padding-5"> Active</span>
        </label>
        <label>
          <input type="radio" class="ace" name="status" value="0" />
          <span class="lbl"> Suspend</span>
        </label>
      </div>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red"></div>
  </div>

  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"></label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <p class="pull-right">
        <button type="button" class="btn btn-sm btn-success" onclick="add()"><i class="fa fa-save"></i> Save</button>
      </p>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>
  <input type="hidden" name="user_id" id="user_id" value="0" />
</form>

<script>
  $('#profile').select2();
  $('#sale-id').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/users/users.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/users/user_add.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>