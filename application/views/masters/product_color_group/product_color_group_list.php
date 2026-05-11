<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <h3 class="title"><?php echo $this->title; ?></h3>
  </div>
</div>
<hr>
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
  <div class="row">
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 padding-5">
      <label>กลุ่ม</label>
      <input type="text" class="form-control input-sm search" name="name" value="<?php echo $name; ?>" autocomplete="off" />
    </div>
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 padding-5">
      <label class="not-show">buton</label>
      <button type="button" class="btn btn-xs btn-primary btn-block" onclick="getSearch()"><i class="fa fa-search"></i>&nbsp; Search</button>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 padding-5">
      <label class="not-show">buton</label>
      <button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i class="fa fa-retweet"></i>&nbsp; Clear</button>
    </div>
  </div>
  <input type="hidden" name="search" value="1" />
  <input type="hidden" name="order_by" id="order_by" value="<?php echo $order_by; ?>" />
  <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>
<?php if ($this->pm->can_add) : ?>
  <?php $this->load->view('masters/product_color_group/product_color_group_control'); ?>
<?php endif; ?>

<?php $sort_name = get_sort('name', $order_by, $sort_by); ?>
<?php $sort_update = get_sort('date_upd', $order_by, $sort_by); ?>
<?php $sort_user = get_sort('update_user', $order_by, $sort_by); ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
    <table class="table table-striped tableFixHead dataTable border-1">
      <thead>
        <tr>
          <th class="fix-width-80 middle"></th>
          <th class="fix-width-40 middle text-center">#</th>
          <th class="fix-width-200 middle sorting <?php echo $sort_name; ?>" id="sort-name" onclick="sort('name', '<?php echo $sort_name; ?>')">กลุ่ม</th>
          <th class="fix-width-80 middle text-center">members</th>
          <th class="min-width-100"></th>
          <th class="fix-width-150 middle sorting <?php echo $sort_update; ?>" id="sort-date_upd" onclick="sort('date_upd', '<?php echo $sort_update; ?>')">แก้ไขล่าสุด</th>
          <th class="fix-width-150 middle sorting <?php echo $sort_user; ?>" id="sort-update_user" onclick="sort('update_user', '<?php echo $sort_user; ?>')">แก้ไขโดย</th>
        </tr>
      </thead>
      <tbody id="group-table">
        <?php if (!empty($data)) : ?>
          <?php $no = intval($this->uri->segment($this->segment)) + 1; ?>
          <?php foreach ($data as $rs) : ?>
            <tr id="row-<?php echo $rs->id; ?>">
              <td class="middle">
                <?php if ($this->pm->can_edit) : ?>
                  <button type="button" class="btn btn-minier btn-warning" onclick="edit(<?php echo $rs->id; ?>)">
                    <i class="fa fa-pencil"></i>
                  </button>
                <?php endif; ?>
                <?php if ($this->pm->can_delete) : ?>
                  <button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete(<?php echo $rs->id; ?>,'<?php echo $rs->name; ?>')">
                    <i class="fa fa-trash"></i>
                  </button>
                <?php endif; ?>
              </td>
              <td class="middle text-center no"><?php echo $no; ?></td>
              <td class="middle"><?php echo $rs->name; ?></td>
              <td class="middle text-center"><?php echo $rs->member; ?></td>
              <td class=""></td>
              <td class="middle"><?php echo thai_date($rs->date_upd, TRUE, '/'); ?></td>
              <td class="middle"><?php echo $rs->update_user; ?></td>
            </tr>
            <?php $no++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script id="edit-row-template" type="text/x-handlebarsTemplate">
  <tr id="edit-row-{{id}}">		
		<td colspan="2" class="middle text-center">
      <button type="button" class="btn btn-minier btn-success" onclick="update({{id}})"><i class="fa fa-save"></i> Save</button>
      <button type="button" class="btn btn-minier btn-default" onclick="cancel({{id}})"><i class="fa fa-times"></i></button>
    </td>
		<td class="middle">
			<input type="text" class="form-control input-xs" id="name-{{id}}" maxlength="100" value="{{name}}" data-id="{{id}}" />
		</td>			
		<td colspan="4" class="middle red padding-left-10" id="error-{{id}}"></td>
	</tr>		
</script>

<script id="row-template" type="text/x-handlebarsTemplate">
  <td class="middle">
		<?php if ($this->pm->can_edit) : ?>
			<button type="button" class="btn btn-minier btn-warning" onclick="edit({{id}})">
				<i class="fa fa-pencil"></i>
			</button>
		<?php endif; ?>
		<?php if ($this->pm->can_delete) : ?>
			<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete('{{id}}', '{{name}}')">
				<i class="fa fa-trash"></i>
			</button>
		<?php endif; ?>
	</td>
	<td class="middle text-center no"></td>	
	<td class="middle">{{name}}</td>	
	<td class="middle text-center">{{member}}</td>
	<td></td>
  <td class="middle">{{date_upd}}</td>
  <td class="middle">{{update_user}}</td>
</script>

<script src="<?php echo base_url(); ?>scripts/masters/product_color_group.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>