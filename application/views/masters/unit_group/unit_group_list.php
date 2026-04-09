<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <?php if ($this->pm->can_add) : ?>
      <button type="button" class="btn btn-white btn-success top-btn" onclick="addNew()"><i class="fa fa-plus"></i> เพิ่มใหม่</button>
    <?php endif; ?>
  </div>
</div><!-- End Row -->
<hr class="padding-5" />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
      <label>รหัส/ชื่อ</label>
      <input type="text" class="form-control input-sm search" name="code" value="<?php echo $code; ?>" />
    </div>

    <div class="col-lg-2 col-md-2-harf col-sm-2-harf col-xs-6 padding-5">
      <label>หน่วยมาตรฐาน</label>
      <select class="form-control input-sm filter" name="baseUnit">
        <option value="all" <?php echo is_selected('all', $baseUnit); ?>>ทั้งหมด</option>
        <?php echo select_unit($baseUnit ); ?>
      </select>
    </div>

    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
      <label class="not-show">buton</label>
      <button type="button" class="btn btn-xs btn-primary btn-block" onclick="getSearch()"><i class="fa fa-search"></i> Search</button>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
      <label class="not-show">buton</label>
      <button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i> Reset</button>
    </div>
  </div>
  <input type="hidden" name="search" value="1" />
  <input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>">
  <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>">
</form>
  <hr class="margin-top-15 padding-5">
<?php echo $this->pagination->create_links(); ?>

<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>

<div class="row">
  <div class="col-sm-12 col-xs-12 padding-5 table-responsive">
    <table class="table dataTable tableFixHead border-1">
      <thead>
        <tr>
          <th class="fix-width-100 middle"></th>
          <th class="fix-width-40 middle text-center">#</th>          
          <th class="fix-width-120 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code', '<?php echo $sort_code; ?>')">รหัส</th>
          <th class="fix-width-250 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name', '<?php echo $sort_name; ?>')">ชื่อ</th>
          <th class="fix-width-100 middle">หน่วยมาตรฐาน</th>
          <th class="min-width-100 middle"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data)) : ?>
          <?php $no = $this->uri->segment($this->segment) + 1; ?>
          <?php $unitNames = []; ?>
          <?php foreach ($data as $rs) : ?>
          <?php $unitName = isset($unitNames[$rs->baseUnit]) ? $unitNames[$rs->baseUnit] : unit_name($rs->baseUnit); ?>
          <?php $unitNames[$rs->baseUnit] = $unitName; ?>          
            <tr id="row-<?php echo $rs->id; ?>">
              <td class="middle">
                <button type="button" class="btn btn-minier btn-info" onclick="viewDetail(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>
                <?php if ($this->pm->can_edit) : ?>
                  <button type="button" class="btn btn-minier btn-warning" onclick="edit(<?php echo $rs->id; ?>)">
                    <i class="fa fa-pencil"></i>
                  </button>
                <?php endif; ?>
                <?php if ($this->pm->can_delete) : ?>
                  <button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>', '<?php echo $rs->name; ?>')">
                    <i class="fa fa-trash"></i>
                  </button>
                <?php endif; ?>
              </td>
              <td class="middle text-center no"><?php echo $no; ?></td>              
              <td class="middle"><?php echo $rs->code; ?></td>
              <td class="middle"><?php echo $rs->name; ?></td>
              <td class="middle"><?php echo $unitName; ?></td>
              <td></td>
            </tr>
            <?php $no++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="<?php echo base_url(); ?>scripts/masters/unit_group.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>