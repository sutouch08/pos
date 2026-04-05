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
      <input type="text" id="code" class="form-control input-sm" maxlength="20" value="<?php echo $data->code; ?>" autocomplete="off" autofocus>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="code-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <input type="text" id="name" class="form-control input-sm" maxlength="100" value="<?php echo $data->name; ?>" autocomplete="off">
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="name-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยมาตรฐาน</label>
    <div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-12">
      <select id="unit" class="form-control input-sm">
        <option value="">Select</option>
        <?php echo select_unit($data->baseUnit); ?>
      </select>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="unit-error"></div>
  </div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="form-group">
    <div class="col-lg-1-harf col-lg-offset-3 col-md-1-harf col-md-offset-3 col-sm-1-harf col-sm-offset-3 col-xs-12">
      <button type="button" class="btn btn-white btn-success btn-block" onclick="update()">Update</button>
    </div>
  </div>
  <input type="hidden" name="id" id="id" value="<?php echo $data->id; ?>">
  <div class="divider"></div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยนับในกลุ่ม</label>
    <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 table-responsive">
      <table class="table table-bordered tableFixHead">
        <thead>
          <tr>
            <th class="fix-width-40 text-center">#</th>
            <th class="fix-width-50 text-center">Alt. Qty</th>
            <th class="fix-width-100 text-center">Alt. Uom</th>
            <th class="fix-width-20 text-center">=</th>
            <th class="fix-width-50 text-center">Base Qty</th>
            <th class="fix-width-100 text-center">Base Uom</th>
            <th class="fix-width-40"></th>
          </tr>
        </thead>
        <tbody id="unit-table">
          <?php if (! empty($details)) : ?>
            <?php $no = 1; ?>
            <?php foreach ($details as $rs) : ?>
                <tr id="unit-row-<?php echo $rs->id; ?>">
                  <td class="middle text-center no"><?php echo $no; ?></td>
                  <td class="middle text-center">
                    <input type="number" class="form-control input-xs text-label text-right alt-qty" id="alt-qty-<?php echo $rs->id; ?>" value="<?php echo round($rs->altQty, 4); ?>" readonly>
                  </td>
                  <td class="middle text-center"><?php echo unit_code($rs->unitId); ?></td>
                  <td class="middle text-center"> = </td>
                  <td class="middle text-center">
                    <input type="number" class="form-control input-xs text-label text-right base-qty" id="base-qty-<?php echo $rs->id; ?>" value="<?php echo round($rs->baseQty, 4); ?>" readonly>
                  </td>
                  <td class="middle text-center"><?php echo unit_code($data->baseUnit); ?></td>
                  <td class="middle text-center">
                    <?php if($no > 1) : ?>
                      <button type="button" class="btn btn-minier btn-danger" onclick="removeUnit(<?php echo $rs->id; ?>)"><i class="fa fa-times"></i></button>
                    <?php endif; ?>
                  </td>
                </tr>              
              <?php $no++; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
      <div class="divider"></div>
      <div class="row">
        <div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
          <label>Alt. Qty</label>
          <input type="number" class="form-control input-sm text-right" id="new-alt-qty">
        </div>
        <div class="col-lg-2-harf col-md-3 col-sm-3-harf col-xs-8 padding-5">
          <label>Alt. Uom</label>
          <select id="new-alt-unit" class="form-control input-sm">
            <option value="">Select</option>
            <?php echo select_unit(); ?>
          </select>
        </div>
        <div class="col-lg-harf col-md-harf col-sm-harf col-xs-12 padding-5">
          <label class="not-show hidden-xs">buton</label>
          <span class="form-control input-xs text-center text-label"> = </span>
        </div>
        <div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
          <label>Base Qty</label>
          <input type="number" class="form-control input-sm text-right" id="new-base-qty">
        </div>
        <div class="col-lg-2-harf col-md-3 col-sm-3-harf col-xs-8 padding-5">
          <label>Base Uom</label>
          <select id="new-base-unit" class="form-control input-sm" disabled>
            <option value="">Select</option>
            <?php echo select_unit($data->baseUnit); ?>
          </select>
        </div>
        <div class="divider-hidden"></div>
        <div class="divider-hidden"></div>
        <div class="col-lg-2 col-md-2-harf col-sm-2-harf col-xs-12 padding-5">
          <button type="button" class="btn btn-white btn-primary btn-block" onclick="addUnit()"><i class="fa fa-plus"></i>&nbsp; Add Unit</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script id="unit-template" type="text/x-handlebarsTemplate">
  <tr id="unit-row-{{id}}">
    <td class="middle text-center no">{{no}}</td>
    <td class="middle text-center">
      <input type="number" class="form-control input-xs text-label text-right alt-qty" id="alt-qty-{{id}}" value="{{altQty}}">
    </td>
    <td class="middle text-center">{{altUnitCode}}</td>
    <td class="middle text-center"> = </td>
    <td class="middle text-center">
      <input type="number" class="form-control input-xs text-label text-right base-qty" id="base-qty-{{id}}" value="{{baseQty}}">
    </td>
    <td class="middle text-center">{{baseUnitCode}}</td>
    <td class="middle text-center">
      <button type="button" class="btn btn-minier btn-danger" onclick="removeUnit({{id}})"><i class="fa fa-times"></i></button>
    </td>
  </tr>
</script>


<script>
  $('#unit').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/unit_group.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>