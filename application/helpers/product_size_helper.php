<?php
function select_size($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  $list = $ci->product_size_model->get_all();

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


function select_size_group($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_size_group_model');
  $list = $ci->product_size_group_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $selected = strval($id) === strval($rs->id) ? 'selected' : '';
      $ds .= '<option value="'.$rs->id.'" '.$selected.'>'.$rs->name.'</option>';
    }
  }
  
  return $ds;
}


function size_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  $list = $ci->product_size_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function size_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  $list = $ci->product_size_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function size_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  return $ci->product_size_model->get_name($id);
}

function size_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  return $ci->product_size_model->get_name_by_code($code);
}

function size_code($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  return $ci->product_size_model->get_code($id); 
}

function size_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_size_model');
  return $ci->product_size_model->get_id($code);
}
