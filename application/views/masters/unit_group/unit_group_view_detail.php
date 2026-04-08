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
      <input type="text" id="code" class="form-control input-sm" maxlength="20" value="<?php echo $data->code; ?>" autocomplete="off" disabled>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="code-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <input type="text" id="name" class="form-control input-sm" maxlength="100" value="<?php echo $data->name; ?>" autocomplete="off" disabled>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="name-error"></div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยมาตรฐาน</label>
    <div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-12">
      <select id="unit" class="form-control input-sm" disabled>
        <option value="">Select</option>
        <?php echo select_unit($data->baseUnit); ?>
      </select>
    </div>
    <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="unit-error"></div>
  </div>    
  <div class="form-group">
    <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยนับในกลุ่ม</label>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 table-responsive">
      <table class="tableFixHead table-bordered table-striped border-1" style="min-width:350px;">
        <thead>
          <tr>
            <th class="fix-width-40 text-center">#</th>
            <th class="fix-width-60 text-center">Alt. Qty</th>
            <th class="min-width-100 text-center">Alt. Uom</th>
            <th class="fix-width-20 text-center">=</th>
            <th class="fix-width-60 text-center">Base Qty</th>
            <th class="fix-width-100 text-center">Base Uom</th>            
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
              </tr>
              <?php $no++; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>  
</form>

<script>
  $('#unit').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/unit_group.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>