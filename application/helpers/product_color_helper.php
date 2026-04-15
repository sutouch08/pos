<?php

function select_color($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  $list = $ci->product_color_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $selected = strval($id) === strval($rs->id) ? 'selected' : '';
      $ds .= '<option value="'.$rs->id.'" '.$selected.'>'.$rs->code.' | '.$rs->name.'</option>';
    }
  }
  
  return $ds;
}


function select_color_group($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_color_group_model');
  $groups = $ci->product_color_group_model->get_all();

  if(!empty($groups))
  {
    foreach($groups as $group)
    {
      $selected = strval($id) === strval($group->id) ? 'selected' : '';
      $ds .= '<option value="'.$group->id.'" '.$selected.'>'.$group->name.'</option>';
    }
  }
  
  return $ds;
}

 ?>
