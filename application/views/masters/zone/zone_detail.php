<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 padding-top-5 text-center">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
</div>
<hr />
<div class="form-horizontal">
  <div class="form-group margin-top-30">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">รหัส</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" class="form-control input-sm" maxlength="50" id="code" value="<?php echo $code; ?>" autocomplete="off" readonly />
      <input type="hidden" id="id" value="<?php echo $id; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">ชื่อ</label>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
      <input type="text" class="form-control input-sm" maxlength="100" id="name" value="<?php echo $name; ?>" autocomplete="off" readonly />
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">คลัง</label>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
      <input type="text" class="form-control input-sm" value="<?php echo warehouse_code_and_name($warehouse_id); ?>" readonly />
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">Pickface</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10">
      <label>
        <?php if ($pickface == 1) : ?>
          <?php echo '<span class="green"><i class="fa fa-check-circle fa-lg"></i> &nbsp;Yes</span>'; ?>
        <?php endif ?>
        <?php if ($pickface == 0) : ?>
          <?php echo '<span class="grey"><i class="fa fa-times-circle fa-lg"></i> &nbsp;No</span>'; ?>
        <?php endif; ?>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">Fast move</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-top-10">
      <label>
        <?php if ($fastmove == 1) : ?>
          <?php echo '<span class="green"><i class="fa fa-check-circle fa-lg"></i> &nbsp;Yes</span>'; ?>
        <?php endif ?>
        <?php if ($fastmove == 0) : ?>
          <?php echo '<span class="grey"><i class="fa fa-times-circle fa-lg"></i> &nbsp;No</span>'; ?>
        <?php endif; ?>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">สถานะ</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <label>
        <?php if ($active == 1) : ?>
          <?php echo '<span class="green"><i class="fa fa-check-circle fa-lg"></i> &nbsp;Active</span>'; ?>
        <?php endif ?>
        <?php if ($active == 0) : ?>
          <?php echo '<span class="red"><i class="fa fa-times-circle fa-lg"></i> &nbsp;Inactive</span>'; ?>
        <?php endif; ?>
        <?php if ($active == -1) : ?>
          <?php echo '<span class="red"><i class="fa fa-minus-circle fa-lg"></i> &nbsp;Deleted</span>'; ?>
        <?php endif; ?>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">สร้างโดย</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <p><?php echo display_name($create_by); ?> วันที่ <?php echo thai_date($create_at, TRUE, '/'); ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">แก้ไขล่าสุด</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <p><?php echo display_name($update_by); ?> วันที่ <?php echo thai_date($update_at, TRUE, '/'); ?></p>
    </div>
  </div>
  <?php if ($delete_at != NULL) : ?>
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">ลบโดย</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
        <p><?php echo display_name($delete_by); ?> วันที่ <?php echo thai_date($delete_at, TRUE, '/'); ?></p>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($active == -1 && ($this->pm->can_delete && $this->pm->can_approve)) : ?>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="form-group">
      <div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12">
        <button type="button" class="btn btn-white btn-info btn-100" onclick="restore(<?php echo $id; ?>)">
          <i class="fa fa-refresh"></i>&nbsp; Restore
        </button>
        <button type="button" class="btn btn-white btn-danger btn-100" onclick="confirmPermanentDelete(<?php echo $id; ?>, '<?php echo $code; ?>')">
          <i class="fa fa-trash"></i>&nbsp; Permanent Delete
        </button>
      </div>
    </div>
  <?php endif; ?>
</div>

<script src="<?php echo base_url(); ?>scripts/masters/zone.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>