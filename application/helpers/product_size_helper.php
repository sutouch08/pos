<?php
function select_size_group($id = NULL)
{
  $ds = "";
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  $groups = $ci->product_size_model->get_all_group();

  if(! empty($groups))
  {
    foreach($groups as $group)
    {
      $selected = $id == $group->id ? 'selected' : '';
      $ds .= '<option value="'.$group->id.'" '.$selected.'>'.$group->name.'</option>';
    }
  }

  return $ds;  
}


function select_size($id = NULL)
{
  $ds = "";
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  $sizes = $ci->product_size_model->get_all();

  if(! empty($sizes))
  {
    foreach($sizes as $size)
    {
      $selected = $id == $size->id ? 'selected' : '';
      $ds .= '<option value="'.$size->id.'" '.$selected.'>'.$size->name.'</option>';
    }
  }

  return $ds;
}

?>