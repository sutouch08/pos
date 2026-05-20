<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <h3 class="title text-center"><?php echo $this->title; ?></h3>     
  </div>
</div>
<hr />
<div class="form-horizontal">
  <div class="form-group margin-top-30">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">รหัส</label>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-9">
      <input type="text" class="form-control input-sm" maxlength="8" id="code" value="<?php echo $data->code; ?>" autocomplete="off" readonly />
    </div>  
  </div>  
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">ชื่อ</label>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-9">
      <input type="text" class="form-control input-sm" maxlength="100" id="name" value="<?php echo $data->name; ?>" autocomplete="off" readonly />
    </div>    
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">ประเภท</label>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-9">
      <input type="text" class="form-control input-sm" value="<?php echo warehouse_role_name($data->role); ?>" readonly />
    </div>    
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">สถานะ</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <label>
        <?php if ($data->active == 1) : ?>
          <?php echo '<span class="green"><i class="fa fa-check-circle fa-lg"></i> &nbsp;Active</span>'; ?>
        <?php endif ?>
        <?php if ($data->active == 0) : ?>
          <?php echo '<span class="red"><i class="fa fa-times-circle fa-lg"></i> &nbsp;Inactive</span>'; ?>
        <?php endif; ?>
        <?php if ($data->active == -1) : ?>
          <?php echo '<span class="red"><i class="fa fa-minus-circle fa-lg"></i> &nbsp;Deleted</span>'; ?>
        <?php endif; ?>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">ติดลบได้</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <label>
        <?php if ($data->auz == 1) : ?>
          <?php echo '<span class="red">&nbsp;Yes</span>'; ?>
        <?php else : ?>
          <?php echo '<span class="green">&nbsp;No</span>'; ?>
        <?php endif; ?>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">สร้างโดย</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <p><?php echo display_name($data->create_by); ?> วันที่ <?php echo thai_date($data->create_at, TRUE, '/'); ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">แก้ไขล่าสุด</label>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
      <p><?php echo display_name($data->update_by); ?> วันที่ <?php echo thai_date($data->update_at, TRUE, '/'); ?></p>
    </div>
  </div>
  <?php if($data->delete_at != NULL) : ?>
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">ลบโดย</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-9" style="padding-top:7px;">
        <p><?php echo display_name($data->delete_by); ?> วันที่ <?php echo thai_date($data->delete_at, TRUE, '/'); ?></p>
      </div>
    </div>
  <?php endif; ?>  
  
  <?php if($data->active == -1 && ($this->pm->can_delete && $this->pm->can_approve)) : ?>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="divider-hidden"></div>
    <div class="form-group">
      <div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12">
        <button type="button" class="btn btn-white btn-info btn-100" onclick="restore(<?php echo $data->id; ?>)">
          <i class="fa fa-refresh"></i>&nbsp; Restore
        </button>
        <button type="button" class="btn btn-white btn-danger btn-100" onclick="confirmPermanentDelete(<?php echo $data->id; ?>, '<?php echo $data->code; ?>')">
          <i class="fa fa-trash"></i>&nbsp; Permanent Delete
        </button>
      </div>
    </div>
  <?php endif; ?>
</div>

<input type="hidden" name="id" id="id" value="<?php echo $data->id; ?>">

<script src="<?php echo base_url(); ?>scripts/masters/warehouse.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>