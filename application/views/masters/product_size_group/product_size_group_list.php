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
</form>
<hr class="margin-top-15">
<?php echo $this->pagination->create_links(); ?>
<?php if ($this->pm->can_add) : ?>
  <?php $this->load->view('masters/product_size_group/product_size_group_control'); ?>
<?php endif; ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive">
    <table class="table table-striped tableFixHead border-1" style="min-width:400px;">
      <thead>
        <tr>
          <th class="fix-width-60 middle"></th>
          <th class="fix-width-50 middle text-center">#</th>
          <th class="fix-width-200 middle">กลุ่ม</th>
          <th class="fix-width-60 middle text-center">members</th>
          <th class="min-width-100"></th>
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
		<td colspan="2" class="middle text-center"></td>
		<td class="middle">
			<input type="text" class="form-control input-sm" id="name-{{id}}" maxlength="100" value="{{name}}" data-id="{{id}}" />
		</td>
		<td class="middle">
			<button type="button" class="btn btn-xs btn-success" onclick="update({{id}})">
        <i class="fa fa-save"></i> &nbsp; Save
      </button>
		</td>		
		<td class="middle red padding-left-10" id="error-{{id}}"></td>
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
</script>

<script src="<?php echo base_url(); ?>scripts/masters/product_size_group.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>