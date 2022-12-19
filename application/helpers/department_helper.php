<?php
//---- only active department
function select_department($id = NULL)
{
  $options = "";

  $ci =& get_instance();
  $ci->load->model('masters/department_model');

  $ds = $ci->department_model->get_all_active();

  if( ! empty($ds))
  {
    foreach($ds as $rs)
    {
      $options .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $id).'>'.$rs->name.'</option>';
    }
  }

  return $options;
}

 ?>
