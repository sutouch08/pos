<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
</div><!-- End Row -->
<hr />
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <div class="form-horizontal margin-top-30">
      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-12 control-label no-padding-right">ธนาคาร</label>
        <div class="col-lg-2-harf col-md-3 col-sm-4 col-xs-12">
          <input type="text" class="form-control input-sm e" value="<?php echo bank_name($data->bank_id); ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-12 control-label no-padding-right">เลขที่บัญชี</label>
        <div class="col-lg-2-harf col-md-3 col-sm-4 col-xs-12">
          <input type="text" id="acc-no" class="form-control input-sm e"
            maxlength="20" autocomplete="off" placeholder="000-0-00000-0"
            value="<?php echo $data->acc_no; ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-12 control-label no-padding-right">ชื่อบัญชี</label>
        <div class="col-lg-2-harf col-md-3 col-sm-4 col-xs-12">
          <input type="text" id="acc-name" class="form-control input-sm e"
            maxlength="100" autocomplete="off" value="<?php echo $data->acc_name; ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-12 control-label no-padding-right">สาขา</label>
        <div class="col-lg-2-harf col-md-3 col-sm-4 col-xs-12">
          <input type="text" id="branch" class="form-control input-sm e"
            maxlength="100" autocomplete="off" value="<?php echo $data->branch; ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-2 control-label no-padding-right">สถานะ</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10" style="padding-top:7px;">
          <label>
            <?php if($data->active == 1) : ?>
              <?php echo '<span class="green"><i class="fa fa-check-circle fa-lg"></i> &nbsp;Active</span>'; ?>
            <?php else : ?>
              <?php echo '<span class="red"><i class="fa fa-times-circle fa-lg"></i> &nbsp;Inactive</span>'; ?>
            <?php endif; ?>
          </label>                      
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-2 control-label no-padding-right">สร้างโดย</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10" style="padding-top:7px;">
          <p><?php echo $data->user; ?> วันที่ <?php echo thai_date($data->date_add, TRUE, '/'); ?></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-4-harf col-md-4-harf col-sm-4 col-xs-2 control-label no-padding-right">แก้ไขล่าสุด</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10" style="padding-top:7px;">
          <p><?php echo $data->update_user; ?> วันที่ <?php echo thai_date($data->date_upd, TRUE, '/'); ?></p>
        </div>
      </div>

    </div><!-- End Form -->
  </div><!-- End Col -->
</div><!-- End Row -->


<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url(); ?>scripts/masters/bank_account.js?v=<?php echo date('Ymd'); ?>"></script>


<script>
  $('#acc-no').mask('999-9-99999-9');
</script>

<?php $this->load->view('include/footer'); ?>