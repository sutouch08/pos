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


function color_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  $list = $ci->product_color_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function color_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  $list = $ci->product_color_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function color_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  return $ci->product_color_model->get_name($id);  
}

function color_code_and_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  $color = $ci->product_color_model->get($id);

  if(!empty($color))
  {
    return $color->code.' | '.$color->name;
  }

  return '';
}

function color_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  return $ci->product_color_model->get_name_by_code($code);
}

function color_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_color_model');
  return $ci->product_color_model->get_id($code);
}