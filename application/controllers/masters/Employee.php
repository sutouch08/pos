<?php
class Employee extends PS_Controller
{
  public $menu_code = "DBOHEM";
  public $menu_group_code = "DB";
  public $menu_sub_group_code = "EMPLOYEE";
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();

    $this->home = base_url()."masters/employee";

    $this->load->model('masters/employee_model');
  }


  public function index()
  {
    $filter = array(
      'name' => get_filter('emp_name', 'emp_name', ''),
      ''
    );
  }

}


 ?>
