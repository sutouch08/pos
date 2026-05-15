<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <?php if($this->pm->can_add) : ?>
      <button type="button" class="btn btn-white btn-success top-btn" onclick="addNew()"><i class="fa fa-plus"></i> Add New</button>
    <?php endif; ?>
  </div>
</div>
<hr>
<form action="<?php echo current_url(); ?>" method="post" id="search-form">
  <div class="row">
    <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-5 padding-5">
      <label>รหัส</label>
      <input type="text" class="form-control input-sm search" name="code" value="<?php echo $code; ?>" />
    </div>
    <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-5 padding-5">
      <label>ชื่อ</label>
      <input type="text" class="form-control input-sm search" name="name" value="<?php echo $name; ?>" />
    </div>
    <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-5 padding-5">
      <label>ตำแหน่ง</label>
      <select class="form-control input-sm filter" name="position" id="position">
        <option value="all">ทั้งหมด</option>
        <?php echo select_position($position); ?>
      </select>
    </div>
    <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-5 padding-5">
      <label>แผนก</label>
      <select class="form-control input-sm filter" name="department" id="department">
        <option value="all">ทั้งหมด</option>
        <?php echo select_department($department); ?>
      </select>
    </div>
    <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-5 padding-5">
      <label>สถานะการจ้าง</label>
      <select class="form-control input-sm filter" name="status">
        <option value="all">ทั้งหมด</option>
        <option value="normal" <?php echo is_selected('normal', $status); ?>>ปกติ</option>
        <option value="probation" <?php echo is_selected('probation', $status); ?>>ทดลองงาน</option>
        <option value="suspend" <?php echo is_selected('suspend', $status); ?>>พักงาน</option>
        <option value="resign" <?php echo is_selected('resign', $status); ?>>ลาออก</option>
        <option value="terminated" <?php echo is_selected('terminated', $status); ?>>เลิกจ้าง</option>
        <option value="retired" <?php echo is_selected('retired', $status); ?>>เกษียณ</option>
      </select>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
      <label>สถานะ</label>
      <select class="form-control input-sm filter" name="active">
        <option value="all">ทั้งหมด</option>
        <option value="1" <?php echo is_selected('1', $active); ?>>Active</option>
        <option value="0" <?php echo is_selected('0', $active); ?>>Inactive</option>
      </select>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
      <label class="not-show">search</label>
      <button type="submit" class="btn btn-xs btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
      <label class="not-show">search</label>
      <button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-refresh"></i> Clear</button>
    </div>
  </div><!-- End Row -->
  <input type="hidden" name="search" value="1" />
  <input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>" />
  <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>
<?php $sort_code = get_sort('code', $order_by, $sort_by); ?>
<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_position = get_sort('position_id', $order_by, $sort_by); ?>
<?php $sort_department = get_sort('department_id', $order_by, $sort_by); ?>
<?php $sort_update = get_sort('update_at', $order_by, $sort_by); ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
    <table class="table table-striped tableFixHead dataTable border-1" style="min-width:1180px;">
      <thead>
        <tr>
          <th class="fix-width-80 middle"></th>
          <th class="fix-width-50 middle text-center">#</th>
          <th class="fix-width-80 middle text-center">สถานะ</th>
          <th class="fix-width-100 middle sorting <?php echo $sort_code; ?>" id="sort-code" onclick="sort('code', '<?php echo $sort_code; ?>')">รหัส</th>
          <th class="min-width-200 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name', '<?php echo $sort_name; ?>')">ชื่อ</th>
          <th class="fix-width-150 middle sorting <?php echo $sort_position; ?>" id="sort-position_id" onclick="sort('position_id', '<?php echo $sort_position; ?>')">ตำแหน่ง</th>
          <th class="fix-width-150 middle sorting <?php echo $sort_department; ?>" id="sort-department_id" onclick="sort('department_id', '<?php echo $sort_department; ?>')">แผนก</th>
          <th class="fix-width-100 middle">การจ้าง</th>          
          <th class="fix-width-150 sorting <?php echo $sort_update; ?>" id="sort-update_at" onclick="sort('update_at', '<?php echo $sort_update; ?>')">แก้ไขล่าสุด</th>
          <th class="fix-width-120">แก้ไขโดย</th>
        </tr>
      </thead>
      <tbody id="data-table">
        <?php if(!empty($data)) : ?>
          <?php $no = $this->uri->segment($this->segment) + 1; ?>
          <?php foreach($data as $rs) : ?>
          <?php $last_modified = empty($rs->update_at) ? thai_date($rs->create_at, TRUE, '/') : thai_date($rs->update_at, TRUE, '/'); ?>
          <?php $modified_by = empty($rs->update_by) ? display_name($rs->create_by) : display_name($rs->update_by); ?>
            <tr id="row-<?php echo $rs->id; ?>">
              <td class="middle">
                <?php if($this->pm->can_edit) : ?>
                  <button type="button" class="btn btn-minier btn-warning" onclick="edit(<?php echo $rs->id; ?>)">
                    <i class="fa fa-pencil"></i>
                  </button>
                <?php endif; ?>
                <?php if($this->pm->can_delete) : ?>
                  <button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->code; ?>')">
                    <i class="fa fa-trash"></i>
                  </button>
                <?php endif; ?>
              </td>
              <td class="middle text-center no"><?php echo $no; ?></td>
              <td class="middle text-center"><?php echo is_active($rs->active); ?></td>
              <td class="middle"><?php echo $rs->code; ?></td>
              <td class="middle"><?php echo $rs->firstName.' '.$rs->lastName; ?></td>
              <td class="middle"><?php echo $rs->position_name; ?></td>
              <td class="middle"><?php echo $rs->department_name; ?></td>
              <td class="middle"><?php echo employee_status_text($rs->status); ?></td>
              <td class="middle"><?php echo $last_modified; ?></td>
              <td class="middle"><?php echo $modified_by; ?></td>
            </tr>
            <?php $no++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="<?php echo base_url(); ?>scripts/masters/employee.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>