<?php $this->load->view('include/header'); ?>
<?php $this->load->view('masters/unit_group/style'); ?>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <button type="button" class="btn btn-default btn-white top-btn" onclick="goBack()">
      <i class="fa fa-arrow-left"></i>&nbsp; กลับ
    </button>
  </div>
</div>
<hr>
<form class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
    <div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-12">
      <input type="text" id="code" class="form-control input-sm" maxlength="20" autocomplete="off" autofocus>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="code-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <input type="text" id="name" class="form-control input-sm" maxlength="100" autocomplete="off">
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="name-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยมาตรฐาน</label>
    <div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-12">
      <select id="unit" class="form-control input-sm">
        <option value="">Select</option>
        <?php echo select_unit(); ?>
      </select>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="unit-error"></div>
  </div>  
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="form-group">
    <div class="col-lg-1-harf col-lg-offset-3 col-md-1-harf col-md-offset-3 col-sm-1-harf col-sm-offset-3 col-xs-12">
      <button type="button" class="btn btn-white btn-success btn-block" onclick="add()">Add</button>
    </div>
  </div>
</form>

<script>
  $('#unit').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/unit_group.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>