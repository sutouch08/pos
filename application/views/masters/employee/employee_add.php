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
<hr />
<div class="row margin-top-30">
  <?php $this->load->view('masters/employee/employee_add_left'); ?>
  <?php $this->load->view('masters/employee/employee_add_right'); ?>

  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="divider-hidden"></div>
  <div class="col-lg-1-harf col-lg-offset-3 col-md-1-harf col-md-offset-3 col-sm-2 col-sm-offset-3 col-xs-12">
    <button type="button" class="btn btn-white btn-success btn-block" onclick="add()"><i class="fa fa-plus"></i> Add</button>
  </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url(); ?>scripts/masters/employee.js?v=<?php echo date('Ymd'); ?>"></script>
<script>
  $('#position').select2();
  $('#department').select2();
  $('#employment-status').select2();
  $('#birth-date').mask('99/99/9999');
  $('#hire-date').mask('99/99/9999');
</script>
<?php $this->load->view('include/footer'); ?>