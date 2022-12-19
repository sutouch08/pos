<?php
  function full_name($fname, $mname=Null, $lname=NULL)
  {
    return $fname.( ! empty($mname) ? " ".$mname : "").( ! empty($lname) ? " ".$lname : "");
  }

  
  function get_full_name_by_id($id)
  {
    $ci =& get_instance();
    $ci->load->model('masters/employee_model');

    $rs = $ci->employee_model->get($id);

    if( ! empty($rs))
    {
      return full_name($rs->row()->fname, $rs->row()->mname, $rs->row()->lname);
    }

    return NULL;
  }

 ?>
