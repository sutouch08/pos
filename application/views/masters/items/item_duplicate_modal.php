<div class="modal fade" id="duplicate-modal" tabindex="-1" role="dialog" aria-labelledby="duplicateModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Duplicate Item</h4>
      </div>
      <div class="modal-body" style="height: 70vh; overflow-y: auto;">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
                <div class="col-lg-4 col-md-9 col-sm-9 col-xs-12">
                  <input type="text" class="form-control input-sm r" maxlength="50" id="code" value="" placeholder="Required" autocomplete="off" autofocus />
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="code-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
                <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
                  <input type="text" class="form-control input-sm r" maxlength="100" id="name" value="" placeholder="Required" autocomplete="off" />
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="name-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">บาร์โค้ด</label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control input-sm" maxlength="50" id="barcode" value="" autocomplete="off" />
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="barcode-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รุ่น</label>
                <div class="col-lg-4 col-md-9 col-sm-9 col-xs-12">
                  <input type="text" class="form-control input-sm r" maxlength="50" id="style" value="" autocomplete="off" />
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="style-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ทุน</label>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="cost" class="form-control input-sm text-right" value="" autocomplete="off" />
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="cost-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ราคาขาย</label>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="price" class="form-control input-sm text-right" value="" autocomplete="off" />
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="price-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มหน่วยนับ</label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control input-sm r" id="unit-group" onchange="genUnitSelection()">
                    <option value="">เลือก</option>
                    <?php echo select_unit_group($default_unit_group); ?>
                  </select>
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="unit-group-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หน่วยนับ</label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control input-sm r" id="unit">
                    <option value="">เลือก</option>
                    <?php echo select_unit_by_group($default_unit_group, NULL); ?>
                  </select>
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="unit-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ภาษีซื้อ</label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control input-sm r" id="purchase-vat-group">
                    <?php echo select_purchase_vat_group(); ?>
                  </select>
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="purchase-vat-group-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ภาษีขาย</label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control input-sm r" id="sale-vat-group">
                    <?php echo select_sale_vat_group(); ?>
                  </select>
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="sale-vat-group-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label for="count-stock">
                    <input type="checkbox" class="ace" id="count-stock" value="1" checked />
                    <span class="lbl"> สินค้านับสต็อก</span>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label for="can-sell">
                    <input type="checkbox" class="ace" id="can-sell" value="1" checked />
                    <span class="lbl"> สินค้าสำหรับขาย</span>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label for="active">
                    <input type="radio" class="ace" id="active" name="active" value="1" checked />
                    <span class="lbl"> Active</span>
                  </label>

                  <label for="inactive" class="margin-left-15">
                    <input type="radio" class="ace" id="inactive" name="active" value="0" />
                    <span class="lbl"> Inactive</span>
                  </label>
                </div>
              </div>
            </div><!--/form-horizontal-->
          </div><!--/col-lg-5-->

          <div class="divider visible-xs"></div>

          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="right-column">
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สี</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="color">
                    <option value="">เลือก</option>
                    <?php echo select_color(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_color']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มสีใหม่" onclick="showAttributeModal('color')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="color-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ไซส์</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="size">
                    <option value="">เลือก</option>
                    <?php echo select_size(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_size']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มไซส์ใหม่" onclick="showAttributeModal('size')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="size-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มหลัก</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="main-group">
                    <option value="">เลือก</option>
                    <?php echo select_product_main_group(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_main_group']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มกลุ่มหลักใหม่" onclick="showAttributeModal('main-group')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="main-group-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่ม</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="group">
                    <option value="">เลือก</option>
                    <?php echo select_product_group(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_group']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มกลุ่มใหม่" onclick="showAttributeModal('group')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="group-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เพศ</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="gender">
                    <option value="">เลือก</option>
                    <?php echo select_product_gender(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_gender']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มเพศใหม่" onclick="showAttributeModal('gender')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="gender-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">หมวดหมู่</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="category">
                    <option value="">เลือก</option>
                    <?php echo select_product_category(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_category']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มหมวดหมู่ใหม่" onclick="showAttributeModal('category')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="category-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ประเภท</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="kind">
                    <option value="">เลือก</option>
                    <?php echo select_product_kind(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_kind']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มประเภทใหม่" onclick="showAttributeModal('kind')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="kind-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชนิด</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="type">
                    <option value="">เลือก</option>
                    <?php echo select_product_type(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_type']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มชนิดใหม่" onclick="showAttributeModal('type')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="type-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ยี่ห้อ</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="brand">
                    <option value="">เลือก</option>
                    <?php echo select_product_brand(); ?>
                  </select>
                </div>
                <?php if ($perm['can_add_brand']) : ?>
                  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-2 padding-0">
                    <button type="button" class="btn btn-white btn-sm btn-primary" title="เพิ่มยี่ห้อใหม่" onclick="showAttributeModal('brand')"><i class="fa fa-plus"></i></button>
                  </div>
                <?php endif; ?>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="brand-error"></div>
              </div>

              <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ปี</label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
                  <select class="form-control input-sm r" id="year">
                    <option value="">เลือก</option>
                    <?php echo select_years(date('Y')); ?>
                  </select>
                </div>
                <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="year-error"></div>
              </div>

            </div><!--/form-horizontal-->
          </div><!--/col-lg-4-->
        </div><!--/row-->
      </div><!--/modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addDuplicate()">Add</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#unit-group').select2();
  $('#unit').select2();
  $('#color').select2();
  $('#size').select2();
  $('#main-group').select2();
  $('#group').select2();
  $('#gender').select2();
  $('#category').select2();
  $('#kind').select2();
  $('#type').select2();
  $('#brand').select2();
  $('#year').select2();
</script>