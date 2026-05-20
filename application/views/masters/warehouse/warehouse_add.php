<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <h3 class="title">
      <a href="<?php echo $this->home; ?>" class="pull-left margin-right-15">
        <i class="fa fa-chevron-left"></i>
      </a>
      <?php echo $this->title; ?>
    </h3>
  </div>
</div>
<hr />
<div class="form-horizontal">
  <div class="form-group margin-top-30">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">รหัส</label>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <input type="text" class="form-control input-sm" maxlength="8" id="code" value="" autocomplete="off" autofocus />
    </div>
    <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="code-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">ชื่อ</label>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
      <input type="text" class="form-control input-sm" maxlength="100" id="name" value="" autocomplete="off" />
    </div>
    <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="name-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">ประเภท</label>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
      <select class="form-control input-sm" id="role">
        <?php echo select_warehouse_role(); ?>
      </select>
    </div>
    <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="role-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">สถานะ</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10">
      <label class="fix-width-100">
        <input type="radio" class="ace" name="active" value="1" checked />
        <span class="lbl"> Active</span>
      </label>
      <label class="fix-width-100">
        <input type="radio" class="ace" name="active" value="0" />
        <span class="lbl"> Inactive</span>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">ติดลบได้</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10">
      <label class="fix-width-100">
        <input type="radio" class="ace" name="auz" value="0" checked />
        <span class="lbl"> No</span>
      </label>
      <label class="fix-width-100">
        <input type="radio" class="ace" name="auz" value="1" />
        <span class="lbl"> Yes</span>
      </label>
    </div>
  </div>
  <?php if ($this->pm->can_add) : ?>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="form-group">
      <div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12">
        <button type="button" class="btn btn-white btn-success btn-100" onclick="add()">
          <i class="fa fa-plus"></i>&nbsp; Add
        </button>
      </div>
    </div>
  <?php endif; ?>
</div>

<script src="<?php echo base_url(); ?>scripts/masters/warehouse.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>