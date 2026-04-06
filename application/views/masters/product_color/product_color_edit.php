<?php $this->load->view('include/header'); ?>
<?php $this->load->view('masters/product_color/style'); ?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <button type="button" class="btn btn-white btn-default" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
  </div>
</div><!-- End Row -->
<hr />
<div class="form-horizontal margin-top-30">
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="code" class="form-control input-sm" maxlength="20" value="<?php echo $code; ?>" autocomplete="off" />
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="code-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <input type="text" id="name" class="form-control input-sm" maxlength="50" value="<?php echo $name; ?>" autocomplete="off" />
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="name-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มสี</label>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <select class="form-control input-sm" id="group-id">
        <option value="">เลือกกลุ่มสี</option>
        <?php echo select_color_group($group_id); ?>
      </select>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3 padding-5">
      <button type="button" class="btn btn-sm btn-white btn-primary" title="Define new group" onclick="openColorGroupModal()"><i class="fa fa-plus"></i></button>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="group-id-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="padding-top:7px;">
      <label>
        <input type="radio" class="ace" name="active" value="1" <?php echo is_checked('1', $active); ?> />
        <span class="lbl">&nbsp; Active &nbsp;&nbsp;</span>
      </label>
      <label class="margin-left-20">
        <input type="radio" class="ace" name="active" value="0" <?php echo is_checked('0', $active); ?> />
        <span class="lbl">&nbsp; Inactive</span>
      </label>
    </div>
  </div>


  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"></label>
    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-12">
      <button type="button" class="btn btn-white btn-success btn-block" onclick="update()"><i class="fa fa-save"></i>&nbsp; Save</button>
    </div>
  </div>

  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
</div>

<div class="modal fade" id="color-group-modal" tabindex="-1" role="dialog" aria-labelledby="colorGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:400px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Color Group</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">Group Name</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
              <input type="text" id="group-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="group-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addColorGroup()">Add</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#group-id').select2({
    placeholder: 'เลือกกลุ่มสี',
    allowClear: true
  });
</script>
<script src="<?php echo base_url(); ?>scripts/masters/product_color.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>