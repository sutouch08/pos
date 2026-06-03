<?php $this->load->view('include/header'); ?>
<script>
  var USE_STRONG_PWD = <?php echo getConfig('USE_STRONG_PWD'); ?>;
</script>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
</div><!-- End Row -->
<hr />
<div class="form-horizontal">
  <div class="form-group margin-top-30">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label no-padding-right">User name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="uname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->uname; ?>" disabled />
      <input type="hidden" id="uid" value="<?php echo $user->uid; ?>" />
    </div>
  </div>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label no-padding-right">รหัสผ่านปัจจุบัน</label>
    <div class="col-xs-12 col-sm-3">
      <span class="input-icon input-icon-right width-100">
        <input type="password" id="cu-pwd" class="form-control input-sm" autofocus />
        <i id="btn-cupwd" class="ace-icon fa fa-eye pointer" onclick="showPwd(this, 'cu-pwd')"></i>
      </span>
    </div>
    <div class="error-block col-lg-7 col-lg-offset-4 col-md-7 col-md-offset-4 col-sm-7 col-sm-offset-4 col-xs-12 red" style="padding-left:15px;" id="cu-pwd-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label no-padding-right">รหัสผ่านใหม่</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <span class="input-icon input-icon-right width-100">
        <input type="password" id="pwd" class="form-control input-sm" />
        <i id="btn-pwd" class="ace-icon fa fa-eye pointer" onclick="showPwd(this, 'pwd')"></i>
      </span>
    </div>
    <div class="error-block col-lg-7 col-lg-offset-4 col-md-7 col-md-offset-4 col-sm-7 col-sm-offset-4 col-xs-12 red" style="padding-left:15px;" id="pwd-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label no-padding-right">ยืนยันรหัสผ่านใหม่</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <span class="input-icon input-icon-right width-100">
        <input type="password" id="cm-pwd" class="form-control input-sm" />
        <i id="btn-cmpwd" class="ace-icon fa fa-eye pointer" onclick="showPwd(this, 'cm-pwd')"></i>
      </span>
    </div>
    <div class="error-block col-lg-7 col-lg-offset-4 col-md-7 col-md-offset-4 col-sm-7 col-sm-offset-4 col-xs-12 red" style="padding-left:15px;" id="cm-pwd-error"></div>
  </div>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label no-padding-right"></label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <button type="button" class="btn btn-white btn-success btn-100 btn-xs-block" onclick="changePassword()"><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</button>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>scripts/users/user_pwd.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>