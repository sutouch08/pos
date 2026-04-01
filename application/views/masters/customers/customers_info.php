<form class="form-horizontal">
  <div class="form-group margin-top-30">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <input type="text" class="form-control input-sm" value="<?php echo $ds->code; ?>" disabled />
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="code-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
      <input type="text" id="name" class="form-control input-sm" maxlength="100" value="<?php echo $ds->name; ?>" autocomplete="off" autofocus />
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="name-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เลขประจำตัว/Tax ID</label>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
      <input type="text" id="tax-id" class="form-control input-sm" maxlength="32" value="<?php echo $ds->tax_id; ?>" autocomplete="off" />
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มลูกค้า</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
      <select id="group" class="form-control input-sm">
        <option value="">เลือกรายการ</option>
        <?php echo select_customer_group($ds->group_code); ?>
      </select>
    </div>
    <?php if ($isAllow->group) : ?>
      <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
        <button type="button" class="btn btn-sm btn-white btn-success" title="create new group" onclick="newGroup()"><i class="fa fa-plus"></i></button>
      </div>
    <?php endif; ?>

    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="group-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เกรดลูกค้า</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
      <select id="grade" class="form-control input-sm">
        <option value="">เลือกรายการ</option>
        <?php echo select_customer_class($ds->class_code); ?>
      </select>
    </div>
    <?php if ($isAllow->class) : ?>
      <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
        <button type="button" class="btn btn-sm btn-white btn-success" title="create new grade" onclick="newGrade()"><i class="fa fa-plus"></i></button>
      </div>
    <?php endif; ?>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="class-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ประเภทลูกค้า</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
      <select id="kind" class="form-control input-sm">
        <option value="">เลือกรายการ</option>
        <?php echo select_customer_kind($ds->kind_code); ?>
      </select>
    </div>
    <?php if ($isAllow->kind) : ?>
      <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
        <button type="button" class="btn btn-sm btn-white btn-success" title="create new kind" onclick="newKind()"><i class="fa fa-plus"></i></button>
      </div>
    <?php endif; ?>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="kind-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชนิดลูกค้า</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
      <select id="type" class="form-control input-sm">
        <option value="">เลือกรายการ</option>
        <?php echo select_customer_type($ds->type_code); ?>
      </select>
    </div>
    <?php if ($isAllow->type) : ?>
      <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
        <button type="button" class="btn btn-sm btn-white btn-success" title="create new type" onclick="newType()"><i class="fa fa-plus"></i></button>
      </div>
    <?php endif; ?>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="type-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พื้นที่ขาย</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
      <select id="area" class="form-control input-sm">
        <option value="">เลือกรายการ</option>
        <?php echo select_customer_area($ds->area_code); ?>
      </select>
    </div>
    <?php if ($isAllow->area) : ?>
      <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 padding-0">
        <button type="button" class="btn btn-sm btn-white btn-success" title="create new area" onclick="newArea()"><i class="fa fa-plus"></i></button>
      </div>
    <?php endif; ?>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="area-error"></div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พนักงานขาย</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
      <select id="sale" class="form-control input-sm">
        <option value="">เลือกรายการ</option>
        <?php echo select_saleman($ds->sale_id); ?>
      </select>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="sale-error"></div>
  </div>

  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="padding-top:7px;">
      <label>
        <input type="radio" class="ace" name="active" value="1" <?php echo is_checked('1', $ds->active); ?> />
        <span class="lbl">&nbsp; Active &nbsp;&nbsp;</span>
      </label>
      <label class="margin-left-20">
        <input type="radio" class="ace" name="active" value="0" <?php echo is_checked('0', $ds->active); ?> />
        <span class="lbl">&nbsp; Inactive</span>
      </label>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="sale-error"></div>
  </div>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"></label>
    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-12">
      <button type="button" class="btn btn-sm btn-success btn-block" onclick="update()">Save</button>
    </div>
  </div>
  <input type="hidden" id="id" value="<?php echo $ds->id; ?>">
  <input type="hidden" id="code" value="<?php echo $ds->code; ?>">
</form>

<div class="modal fade" id="attribute-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 400px; max-width:95vw;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="attribute-modal-title">เพิ่มข้อมูล</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label no-padding-right">รหัส</label>
          <div class="col-lg-9 col-md-9 col-sm-10 col-xs-9">
            <input type="text" id="attribute-code" class="form-control input-sm input-medium" placeholder="" autocomplete="off" />
          </div>
          <div class="divider-hidden"></div>
          <label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 control-label no-padding-right">ชื่อ</label>
          <div class="col-lg-9 col-md-9 col-sm-10 col-xs-9">
            <input type="text" id="attribute-name" class="form-control input-sm input-xlarge" placeholder="" autocomplete="off" />
            <input type="hidden" id="attribute-type" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="saveAttribute()">Add</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#group').select2();
  $('#kind').select2();
  $('#type').select2();
  $('#grade').select2();
  $('#area').select2();
  $('#sale').select2();
</script>