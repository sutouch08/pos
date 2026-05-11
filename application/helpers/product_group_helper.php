<?php
function select_product_group($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  $list = $ci->product_group_model->get_all();

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


function group_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  $list = $ci->product_group_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}

function group_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  $list = $ci->product_group_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function group_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  return $ci->product_group_model->get_name($id);
}

function group_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  return $ci->product_group_model->get_name_by_code($code);
}

function group_code($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  return $ci->product_group_model->get_code($id); 
}


function group_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_group_model');
  return $ci->product_group_model->get_id($code);
}