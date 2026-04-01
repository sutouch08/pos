<div class="row">
  <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 padding-5">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0 table-responsive">
      <table class="table table-striped tableFixHead border-1">
        <thead>
          <tr>
            <th class="min-width-100" style="font-size:14px;">
              Bill To Address
            </th>
            <th class="fix-width-100 text-right">
              <button type="button" class="btn btn-minier btn-primary pull-right" onclick="newAddress('B')"><i class="fa fa-plus"></i> เพิ่มใหม่</button>
            </th>
          </tr>
        </thead>
        <tbody id="bill-to-list">
          <?php if (! empty($bill_to)) : ?>
            <?php foreach ($bill_to as $rs) : ?>
              <tr id="address-<?php echo $rs->id; ?>">
                <td class="middle min-width-100"><?php echo $rs->alias; ?> | <?php echo $rs->name; ?></td>
                <td class="middle fix-width-100 text-right">
                  <input type="hidden" id="address-data-<?php echo $rs->id; ?>" value="<?php echo htmlspecialchars(json_encode($rs)); ?>" data-id="<?php echo $rs->id; ?>" />
                  <button type="button" class="btn btn-minier btn-info" title="แสดงรายละเอียด" onclick="viewAddress(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>
                  <?php if ($this->pm->can_edit) : ?>
                    <button type="button" class="btn btn-minier btn-warning" title="แก้ไข" onclick="editAddress(<?php echo $rs->id; ?>)"><i class="fa fa-pencil"></i></button>
                  <?php endif; ?>
                  <?php if ($this->pm->can_delete) : ?>
                    <button type="button" class="btn btn-minier btn-danger" title="ลบ" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->alias; ?>')"><i class="fa fa-times"></i></button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr id="no-bill-to">
              <td colspan="2" class="text-center" style="font-size:14px;">No Bill To Address</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="divider"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0 table-responsive">
      <table class="table table-striped tableFixHead border-1">
        <thead>
          <tr>
            <th class="min-width-100" style="font-size:14px;">
              Ship To Address
            </th>
            <th class="fix-width-100 text-right">
              <button type="button" class="btn btn-minier btn-primary pull-right" onclick="newAddress('S')"><i class="fa fa-plus"></i> เพิ่มใหม่</button>
            </th>
          </tr>
        </thead>
        <tbody id="ship-to-list">
          <?php if (! empty($ship_to)) : ?>
            <?php foreach ($ship_to as $rs) : ?>
              <tr id="address-<?php echo $rs->id; ?>">
                <td class="middle min-width-100"><?php echo $rs->alias; ?> | <?php echo $rs->name; ?></td>
                <td class="middle fix-width-100 text-right">
                  <input type="hidden" id="address-data-<?php echo $rs->id; ?>" value="<?php echo htmlspecialchars(json_encode($rs)); ?>" data-id="<?php echo $rs->id; ?>" />
                  <button type="button" class="btn btn-minier btn-info" title="แสดงรายละเอียด" onclick="viewAddress(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>
                  <?php if ($this->pm->can_edit) : ?>
                    <button type="button" class="btn btn-minier btn-warning" title="แก้ไข" onclick="editAddress(<?php echo $rs->id; ?>)"><i class="fa fa-pencil"></i></button>
                  <?php endif; ?>
                  <?php if ($this->pm->can_delete) : ?>
                    <button type="button" class="btn btn-minier btn-danger" title="ลบ" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->alias; ?>')"><i class="fa fa-times"></i></button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr id="no-ship-to">
              <td colspan="2" class="text-center" style="font-size:14px;">No Ship To Address</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 padding-5 not-show" id="address-panel">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center font-size-16" id="address-title">Ship To Address</div>
    <div class="divider" style="margin-top:5px;"></div>
    <div class="form-horizontal">
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อเรียก</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="alias" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="alias-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ผู้รับ</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="consignee" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="consignee-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัสสาขา</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="branch-code" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
        </div>        
        <div class="help-block col-xs-12 col-sm-reset inline" id="branch-code-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อสาขา</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="branch-name" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
        </div>        
        <div class="help-block col-xs-12 col-sm-reset inline" id="branch-name-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ที่อยู่</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="address" class="form-control input-sm r ad" maxlength="250" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="address-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ตำบล/แขวง</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="sub-district" class="form-control input-sm r ad" maxlength="100" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="sub-district-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">อำเภอ/เขต</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="district" class="form-control input-sm r ad" maxlength="100" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="district-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">จังหวัด</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="province" class="form-control input-sm r ad" maxlength="100" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="province-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัสไปรษณีย์</label>
        <div class="col-lg-3 col-md-3-harf col-sm-6 col-xs-12">
          <input type="text" id="postcode" class="form-control input-sm ad" maxlength="12" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="postcode-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เบอร์โทร</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <input type="text" id="phone" class="form-control input-sm r ad" maxlength="20" value="" autocomplete="off" />
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="phone-error"></div>
      </div>

      <input type="hidden" id="address-type" class="ad" value="S" />
      <input type="hidden" id="address-id" class="ad" value="" />
      <div class="divider-hidden"></div>
      <div class="divider-hidden"></div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
          <button type="button" class="btn btn-sm btn-default" id="cancel-btn" onclick="clearFields()">Cancel</button>
          <button type="button" class="btn btn-sm btn-success pull-right btn-100" id="save-btn" onclick="saveAddress()">Save</button>
        </div>
        <div class="help-block col-xs-12 col-sm-reset inline" id="postcode-error"></div>
      </div>
    </div>
  </div>
</div>

<script id="address-template" type="text/x-handlebars-template">
  <tr id="address-{{id}}">
    <td class="middle min-width-100">{{alias}} | {{name}}</td>
    <td class="moddle fix-width-100 text-right">
      <input type="hidden" id="address-data-{{id}}" value="{{data}}" data-id="{{id}}" />
      <button type="button" class="btn btn-minier btn-info" title="แสดงรายละเอียด" onclick="viewAddress({{id}})"><i class="fa fa-eye"></i></button>
      <?php if ($this->pm->can_edit) : ?>
      <button type="button" class="btn btn-minier btn-warning" title="แก้ไข" onclick="editAddress({{id}})"><i class="fa fa-pencil"></i></button>
      <?php endif; ?>
      <?php if ($this->pm->can_delete) : ?>
      <button type="button" class="btn btn-minier btn-danger" title="ลบ" onclick="confirmDelete({{id}}, '{{alias}}')"><i class="fa fa-times"></i></button>
      <?php endif; ?>
    </td>
  </tr>
</script>

<script id="address-update-template" type="text/x-handlebars-template">
  <td class="middle min-width-100">{{alias}} | {{name}}</td>
  <td class="moddle fix-width-100 text-right">
    <input type="hidden" id="address-data-{{id}}" value="{{data}}" data-id="{{id}}" />
    <button type="button" class="btn btn-minier btn-info" title="แสดงรายละเอียด" onclick="viewAddress({{id}})"><i class="fa fa-eye"></i></button>
    <?php if ($this->pm->can_edit) : ?>
      <button type="button" class="btn btn-minier btn-warning" title="แก้ไข" onclick="editAddress({{id}})"><i class="fa fa-pencil"></i></button>
    <?php endif; ?>
    <?php if ($this->pm->can_delete) : ?>
      <button type="button" class="btn btn-minier btn-danger" title="ลบ" onclick="confirmDelete({{id}}, '{{alias}}')"><i class="fa fa-times"></i></button>
    <?php endif; ?>
  </td>
</script>