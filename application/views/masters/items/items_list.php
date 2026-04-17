<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
    <?php if ($this->pm->can_add) : ?>
      <button type="button" class="btn btn-white btn-success top-btn" onclick="addNew()"><i class="fa fa-plus"></i> เพิ่มใหม่</button>
    <?php endif; ?>
  </div>
</div><!-- End Row -->
<hr class="" />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
  <div class="row">
    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>รหัส</label>
      <input type="text" class="form-control input-sm search" name="code" id="f-code" value="<?php echo $code; ?>" />
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>ชื่อ</label>
      <input type="text" class="form-control input-sm search" name="name" id="f-name" value="<?php echo $name; ?>" />
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>บาร์โค้ด</label>
      <input type="text" class="form-control input-sm search" name="barcode" id="f-barcode" value="<?php echo $barcode; ?>" />
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>สี</label>
      <input type="text" class="form-control input-sm search" name="color" id="f-color" value="<?php echo $color; ?>" />
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>ไซส์</label>
      <input type="text" class="form-control input-sm search" name="size" id="f-size" value="<?php echo $size; ?>" />
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>กลุ่ม</label>
      <select class="form-control input-sm filter" id="f-group" name="group">
        <option value="">ทั้งหมด</option>
        <?php echo select_product_group($group); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>เพศ</label>
      <select class="form-control input-sm filter" id="f-gender" name="gender">
        <option value="">ทั้งหมด</option>
        <?php echo select_product_gender($gender); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>หมวดหมู่</label>
      <select class="form-control input-sm filter" id="f-category" name="category">
        <option value="">ทั้งหมด</option>
        <?php echo select_product_category($category); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>ประเภท</label>
      <select class="form-control input-sm filter" id="f-kind" name="kind">
        <option value="">ทั้งหมด</option>
        <?php echo select_product_kind($kind); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>ชนิด</label>
      <select class="form-control input-sm filter" id="f-type" name="type">
        <option value="">ทั้งหมด</option>
        <?php echo select_product_type($type); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>ยี่ห้อ</label>
      <select class="form-control input-sm filter" id="f-brand" name="brand">
        <option value="">ทั้งหมด</option>
        <?php echo select_product_brand($brand); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
      <label>ปี</label>
      <select class="form-control input-sm filter" id="f-year" name="year">
        <option value="">ทั้งหมด</option>
        <?php echo select_years($year); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4 padding-5">
      <label>สถานะ</label>
      <select class="form-control input-sm filter" id="f-active" name="active">
        <option value="all">ทั้งหมด</option>
        <option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
        <option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
      </select>
    </div>

    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
      <label class="not-show">buton</label>
      <button type="button" class="btn btn-xs btn-primary btn-block" onclick="getSearch()"><i class="fa fa-search"></i> Search</button>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
      <label class="not-show">buton</label>
      <button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
    </div>
  </div>
  <input type="hidden" name="search" value="1">
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive padding-5">
    <table class="table dataTable tableFixHead table-bordered" style="min-width:1530px;">
      <thead>
        <tr>
          <th class="fix-width-120"></th>
          <th class="fix-width-40 middle text-center fix-header">#</th>
          <th class="fix-width-40 middle text-center">Sell</th>
          <th class="fix-width-40 middle text-center" style="padding:3px;">Active</th>
          <th class="fix-width-200 middle text-center">รหัส</th>
          <th class="min-width-200 middle text-center">สินค้า</th>
          <th class="fix-width-150 middle text-center">รุ่น</th>
          <th class="fix-width-150 middle text-center">บาร์โค้ด</th>
          <th class="fix-width-60 middle text-center">สี</th>
          <th class="fix-width-60 middle text-center">ไซส์</th>
          <th class="fix-width-80 middle text-center">ราคา</th>
          <th class="fix-width-150 middle text-center">กลุ่ม</th>
          <th class="fix-width-150 middle text-center">หมวดหมู่</th>
          <th class="fix-width-80 middle text-center">ปี</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data)) : ?>
          <?php $no = $this->uri->segment(4) + 1; ?>
          <?php foreach ($data as $rs) : ?>
            <tr id="row-<?php echo $rs->id; ?>">
              <td class="middle">
                <button type="button" class="btn btn-minier btn-info" onclick="viewDetail(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>
                <?php if ($this->pm->can_add) : ?>
                  <button type="button" class="btn btn-minier btn-primary" onclick="duplicate(<?php echo $rs->id; ?>)">
                    <i class="fa fa-copy"></i>
                  </button>
                <?php endif; ?>
                <?php if ($this->pm->can_edit) : ?>
                  <button type="button" class="btn btn-minier btn-warning" onclick="edit(<?php echo $rs->id; ?>)">
                    <i class="fa fa-pencil"></i>
                  </button>
                <?php endif; ?>
                <?php if ($this->pm->can_delete) : ?>
                  <button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>')">
                    <i class="fa fa-trash"></i>
                  </button>
                <?php endif; ?>
              </td>
              <td class="middle text-center no"><?php echo $no; ?></td>
              <td class="middle text-center"><?php echo is_active($rs->can_sell); ?></td>
              <td class="middle text-center"><?php echo is_active($rs->active); ?></td>
              <td class="middle"><?php echo $rs->code; ?></td>
              <td class="middle"><?php echo $rs->name; ?></td>
              <td class="middle"><?php echo $rs->style_code; ?></td>
              <td class="middle"><?php echo $rs->barcode; ?></td>
              <td class="middle text-center"><?php echo $rs->color_code; ?></td>
              <td class="middle text-center"><?php echo $rs->size_code; ?></td>
              <td class="middle text-right"><?php echo number($rs->price, 2); ?></td>
              <td class="middle"><?php echo $rs->group_name; ?></td>
              <td class="middle"><?php echo $rs->category_name; ?></td>
              <td class="middle text-center"><?php echo $rs->year; ?></td>
            </tr>
            <?php $no++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>


<?php $this->load->view('masters/items/import_items'); ?>
<?php $this->load->view('masters/items/item_duplicate_modal'); ?>
<?php $this->load->view('masters/items/item_attributes_modal'); ?>

<script>
  $('#f-group').select2();
  $('#f-gender').select2();
  $('#f-category').select2();
  $('#f-kind').select2();
  $('#f-type').select2();
  $('#f-brand').select2();
  $('#f-year').select2();
  $('#f-active').select2();
</script>
<script src="<?php echo base_url(); ?>scripts/masters/items.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/masters/items_attributes.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>