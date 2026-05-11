<?php
function select_product_main_group($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  $list = $ci->product_main_group_model->get_all();

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


function main_group_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  $list = $ci->product_main_group_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function main_group_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  $list = $ci->product_main_group_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function main_group_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  $rs = $ci->product_main_group_model->get($id);

  if(!empty($rs))
  {
    return $rs->name;
  }

  return NULL;
}

function main_group_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  return $ci->product_main_group_model->get_name_by_code($code);
}

function main_group_code($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  return $ci->product_main_group_model->get_code($id); 
}

function main_group_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  return $ci->product_main_group_model->get_id($code);
}
