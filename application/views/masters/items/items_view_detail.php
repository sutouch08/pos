<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <h3 class="title">
      <?php echo $this->title; ?>
    </h3>
  </div>
</div>
<hr>
<div class="row margin-top-30">
  <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12" id="left-column">
    <div class="form-horizontal">
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
        <div class="col-lg-4 col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control input-sm r" maxlength="50" value="<?php echo escapeQuote($item->code); ?>" autocomplete="off" readonly />
          <input type="hidden" value="<?php echo $item->id; ?>">
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="code-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
        <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control input-sm r" maxlength="100" value="<?php echo escapeQuote($item->name); ?>" placeholder="Required" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="name-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">บาร์โค้ด</label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <input type="text" class="form-control input-sm" maxlength="50" id="barcode" value="<?php echo $item->barcode; ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="barcode-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รุ่น</label>
        <div class="col-lg-4 col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control input-sm r" maxlength="50" id="style" value="<?php echo $item->style_code; ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="style-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ทุน</label>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <input type="text" class="form-control input-sm text-right" value="<?php echo number($item->cost, 2); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="cost-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ราคาขาย</label>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <input type="text" class="form-control input-sm text-right" value="<?php echo number($item->price, 2); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="price-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มหน่วยนับ</label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(unit_group_name($item->unit_group_id)); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="unit-group-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยนับ</label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(unit_name($item->unit_id)); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="unit-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ภาษีซื้อ</label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(purchase_vat_name($item->purchase_vat_code)); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="purchase-vat-group-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ภาษีขาย</label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(sale_vat_name($item->sale_vat_code)); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="sale-vat-group-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <label for="inventory-item">
            <?php echo $item->inventoryItem ? '<i class="fa fa-check-circle fa-lg green"></i>' : '<i class="fa fa-times-circle fa-lg red"></i>'; ?>
            <span class="lbl">&nbsp; สินค้านับสต็อก</span>
          </label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <label for="sale-item">
            <?php echo $item->saleItem ? '<i class="fa fa-check-circle fa-lg green"></i>' : '<i class="fa fa-times-circle fa-lg red"></i>'; ?>
            <span class="lbl">&nbsp; สินค้าสำหรับขาย</span>
          </label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <label for="purchase-item">
            <?php echo $item->purchaseItem ? '<i class="fa fa-check-circle fa-lg green"></i>' : '<i class="fa fa-times-circle fa-lg red"></i>'; ?>
            <span class="lbl">&nbsp; สินค้าสำหรับซื้อ</span>
          </label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <label for="active">
            <?php echo $item->active ? '<i class="fa fa-check-circle fa-lg green"></i>' : '<i class="fa fa-times-circle fa-lg red"></i>'; ?>
            <span class="lbl">&nbsp; <?php echo $item->active ? 'Active' : 'Inactive'; ?></span>
          </label>
        </div>
      </div>      
    </div><!--/form-horizontal-->
  </div><!--/left-column-->

  <div class="divider visible-xs"></div>

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="right-column">
    <div class="form-horizontal">
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สี</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(color_name($item->color_id)); ?>" autocomplete="off" readonly />          
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="color-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ไซส์</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(size_name($item->size_id)); ?>" autocomplete="off" readonly />          
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="size-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มหลัก</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(main_group_name($item->main_group_id)); ?>" autocomplete="off" readonly />          
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="main-group-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่ม</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(group_name($item->group_id)); ?>" autocomplete="off" readonly />          
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="group-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เพศ</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(gender_name($item->gender_id)); ?>" autocomplete="off" readonly />          
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="gender-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หมวดหมู่</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(category_name($item->category_id)); ?>" autocomplete="off" readonly />         
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="category-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ประเภท</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(kind_name($item->kind_id)); ?>" autocomplete="off" readonly />          
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="kind-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชนิด</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(type_name($item->type_id)); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="type-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ยี่ห้อ</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote(brand_name($item->brand_id)); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="brand-error"></div>
      </div>

      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ปี</label>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
          <input type="text" class="form-control input-sm" value="<?php echo escapeQuote($item->year); ?>" autocomplete="off" readonly />
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="year-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สร้างโดย</label>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="padding-top: 7px;">
          <?php echo display_name($item->create_by); ?>  At <?php echo thai_date($item->create_at, TRUE); ?>                       
        </div>
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="created-error"></div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">แก้ไขโดย</label>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="padding-top: 7px;">
          <?php if( ! empty($item->update_by)) : ?>            
            <?php echo display_name($item->update_by); ?>  At <?php echo thai_date($item->update_at, TRUE); ?>
          <?php else : ?>
              -
          <?php endif; ?>
        </div>                          
        <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="updated-error"></div>
      </div>
    </div><!--/form-horizontal-->
  </div><!--/col right-->
</div><!--/row-->
<script src="<?php echo base_url(); ?>scripts/masters/items.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>