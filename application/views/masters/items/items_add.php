<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
    <h3 class="title">
      <a href="<?php echo $this->home; ?>" class="pull-left margin-right-15">
        <i class="fa fa-chevron-left"></i>
      </a>
      <?php echo $this->title; ?>
    </h3>
  </div>
</div>
<hr>
<div class="row margin-top-30">
  <?php $this->load->view('masters/items/items_add_left'); ?>
  <?php $this->load->view('masters/items/items_add_right'); ?>
  <?php $this->load->view('masters/items/item_attributes_modal'); ?>

</div><!--/row-->
<?php if ($this->pm->can_add) : ?>
  <div class="divider"></div>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
        <button type="button" class="btn btn-white btn-success btn-100" onclick="add()">
          <i class="fa fa-plus"></i>&nbsp; Add
        </button>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
  $('#unit').select2();
  $('#color').select2();
  $('#size').select2();
  $('#main-group').select2();
  $('#group').select2();
  $('#gender').select2();
  $('#kind').select2();
  $('#type').select2();
  $('#category').select2();
  $('#brand').select2();
  $('#year').select2();
</script>


<script src="<?php echo base_url(); ?>scripts/masters/items.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/masters/items_attributes.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>