<?php
function select_color_group($id = NULL)
{
  $ds = "";
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  $groups = $ci->product_color_model->get_all_group();

  if(!empty($groups))
  {
    foreach($groups as $group)
    {
      $selected = $id == $group->id ? 'selected' : '';
      $ds .= '<option value="'.$group->id.'" '.$selected.'>'.$group->name.'</option>';
    }
  }
  
  return $ds;
}


function select_color($id = NULL)
{
  $ds = "";
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  $colors = $ci->product_color_model->get_all();

  if(!empty($colors))
  {
    foreach($colors as $color)
    {
      $selected = $id == $color->id ? 'selected' : '';
      $ds .= '<option value="'.$color->id.'" '.$selected.'>'.$color->name.'</option>';
    }
  }
  
  return $ds;
}


 ?>
