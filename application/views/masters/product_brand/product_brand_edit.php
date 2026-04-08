<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <button type="button" class="btn btn-white btn-default top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
  </div>
</div><!-- End Row -->
<hr>
<div class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
    <div class="col-lg-1-harf col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="code" class="form-control input-sm" maxlength="20" placeholder="Allow (A-Z  0-9  -  _  .  @)" value="<?php echo $code; ?>" autocomplete="off" disabled />
    </div>
    <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="code-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="name" class="form-control input-sm" maxlength="100" value="<?php echo $name; ?>" autocomplete="off" />
    </div>
    <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="name-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="padding-top:7px;">
      <label>
        <input type="radio" class="ace" name="active" value="1" <?php echo $active == 1 ? 'checked' : ''; ?> />
        <span class="lbl">&nbsp; Active &nbsp;&nbsp;</span>
      </label>
      <label class="margin-left-20">
        <input type="radio" class="ace" name="active" value="0" <?php echo $active == 0 ? 'checked' : ''; ?> />
        <span class="lbl">&nbsp; Inactive</span>
      </label>
    </div>
  </div>

  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
    <div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-12">
      <button type="button" class="btn btn-white btn-success btn-block" onclick="update()"><i class="fa fa-plus"></i> &nbsp; Update</button>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>scripts/masters/product_brand.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>