<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12" id="left-column">
  <div class="form-horizontal">
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
      <div class="col-lg-4 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control input-sm r" maxlength="50" id="code" value="<?php echo $item->code; ?>"  autocomplete="off" disabled />
        <input type="hidden" id="item-id" value="<?php echo $item->id; ?>">
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="code-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control input-sm r" maxlength="100" id="name" value="<?php echo $item->name; ?>" placeholder="Required" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="name-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">บาร์โค้ด</label>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <input type="text" class="form-control input-sm" maxlength="50" id="barcode" value="<?php echo $item->barcode; ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="barcode-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รุ่น</label>
      <div class="col-lg-4 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control input-sm r" maxlength="50" id="style" value="<?php echo $item->style_code; ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="style-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ทุน</label>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="cost" class="form-control input-sm text-right" value="<?php echo number($item->cost, 2); ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="cost-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ราคาขาย</label>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="price" class="form-control input-sm text-right" value="<?php echo number($item->price, 2); ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="price-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มหน่วยนับ</label>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control input-sm r" id="unit-group" onchange="genUnitSelection()">
          <option value="">เลือก</option>
          <?php echo select_unit_group($item->unit_group_id); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="unit-group-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยนับ</label>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control input-sm r" id="unit">
          <option value="">เลือก</option>
          <?php echo select_unit_by_group($item->unit_group_id, $item->unit_id); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="unit-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ภาษีซื้อ</label>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control input-sm r" id="purchase-vat-group">
          <?php echo select_purchase_vat_group($item->purchase_vat_code); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="purchase-vat-group-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ภาษีขาย</label>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <select class="form-control input-sm r" id="sale-vat-group">
          <?php echo select_sale_vat_group($item->sale_vat_code); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="sale-vat-group-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <label for="count-stock">
          <input type="checkbox" class="ace" id="count-stock" value="1" <?php echo $item->count_stock ? 'checked' : ''; ?> />
          <span class="lbl"> สินค้านับสต็อก</span>
        </label>
      </div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <label for="can-sell">
          <input type="checkbox" class="ace" id="can-sell" value="1" <?php echo $item->can_sell ? 'checked' : ''; ?> />
          <span class="lbl"> สินค้าสำหรับขาย</span>
        </label>
      </div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <label for="active">
          <input type="radio" class="ace" id="active" name="active" value="1" <?php echo $item->active ? 'checked' : ''; ?> />
          <span class="lbl"> Active</span>
        </label>

        <label for="inactive" class="margin-left-15">
          <input type="radio" class="ace" id="inactive" name="active" value="0" <?php echo !$item->active ? 'checked' : ''; ?> />
          <span class="lbl"> Inactive</span>
        </label>
      </div>
    </div>
  </div><!--/form-horizontal-->
</div><!--/left-column-->


<script id="unit-template" type="text/x-handlebars-template">
  <option value="">เลือก</option>
  {{#each units}}
    <option value="{{id}}" data-code="{{code}}" {{#if selected}}selected{{/if}}>{{name}}</option>
  {{/each}}
</script>