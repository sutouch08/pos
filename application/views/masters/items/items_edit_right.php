<div class="divider visible-xs"></div>

<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="right-column">
  <div class="form-horizontal">
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สี</label>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-10">
        <select class="form-control input-sm r" id="color">
          <option value="">เลือก</option>
          <?php echo select_color($item->color_id); ?>
        </select>
      </div>
      <?php if ($can_add_color) : ?>
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
          <?php echo select_size($item->size_id); ?>
        </select>
      </div>
      <?php if ($can_add_size) : ?>
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
          <?php echo select_product_main_group($item->main_group_id); ?>
        </select>
      </div>
      <?php if ($can_add_main_group) : ?>
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
          <?php echo select_product_group($item->group_id); ?>
        </select>
      </div>
      <?php if ($can_add_group) : ?>
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
          <?php echo select_product_gender($item->gender_id); ?>
        </select>
      </div>
      <?php if ($can_add_gender) : ?>
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
          <?php echo select_product_category($item->category_id); ?>
        </select>
      </div>
      <?php if ($can_add_category) : ?>
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
          <?php echo select_product_kind($item->kind_id); ?>
        </select>
      </div>
      <?php if ($can_add_kind) : ?>
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
          <?php echo select_product_type($item->type_id); ?>
        </select>
      </div>
      <?php if ($can_add_type) : ?>
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
          <?php echo select_product_brand($item->brand_id); ?>
        </select>
      </div>
      <?php if ($can_add_brand) : ?>
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
          <?php echo select_years($item->year); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-offset-3 col-xs-12" id="year-error"></div>
    </div>
  </div><!--/form-horizontal-->
</div><!--/col right-->