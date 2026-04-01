<?php $this->load->view('include/header'); ?>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
  </div>
</div><!-- End Row -->
<hr />
<form class="form-horizontal">
  <div class="form-group margin-top-30">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Code</label>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
      <input type="text" name="code" id="code" class="form-control input-sm e" maxlength="20" value="<?php echo $data->code; ?>" autocomplete="off" disabled/>
    </div>
    <span class="help-block col-xs-12 col-sm-reset inline red" id="code-error"></span>
  </div>


  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Name</label>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <input type="text" name="name" id="name" class="form-control input-sm e" maxlength="100" value="<?php echo $data->name; ?>" autocomplete="off" autofocus />
    </div>
      <span class="help-block col-xs-12 col-sm-reset inline red" id="name-error"></span>
  </div>

  <div class="divider-hidden"></div>


  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
    <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-12">
      <button type="button" class="btn btn-sm btn-success btn-block" onclick="update()"><i class="fa fa-save"></i> Save</button>
    </div>
  </div>
  <input type="hidden" id="id" value="<?php echo $data->id; ?>">
</form>

<script src="<?php echo base_url(); ?>scripts/masters/customer_kind.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
