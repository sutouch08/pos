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
      <input type="text" id="uname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->uname; ?>" disabled />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="uname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">Display name</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="dname" class="form-control input-sm" autocomplete="off" value="<?php echo $user->name; ?>" disabled />
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="dname-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right">New password</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="password" id="pwd" class="form-control input-sm" autocomplete="off" autofocus />
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
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right"></label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <label>
        <input type="checkbox" class="ace" id="force-reset" value="1" checked />
        <span class="lbl">&nbsp; &nbsp; User must change after login</span>
      </label>      
    </div>    
  </div>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-4-harf col-md-4-harf col-sm-4-harf col-xs-12 control-label no-padding-right"></label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <p class="pull-right">
        <button type="button" class="btn btn-sm btn-success" onclick="changePassword()"><i class="fa fa-save"></i> Change Password</button>
      </p>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>
  <input type="hidden" id="user-id" value="<?php echo $user->id; ?>" />
</form>

<script src="<?php echo base_url(); ?>scripts/users/users.js?v=<?php date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/users/user_add.js?v=<?php date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>