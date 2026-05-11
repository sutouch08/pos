<?php
function select_product_kind($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  $list = $ci->product_kind_model->get_all();

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

function kind_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  $list = $ci->product_kind_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}

function kind_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  $list = $ci->product_kind_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function kind_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  return $ci->product_kind_model->get_name($id);
}

function kind_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  return $ci->product_kind_model->get_name_by_code($code);
}

function kind_code($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  return $ci->product_kind_model->get_code($id); 
}

function kind_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_kind_model');
  return $ci->product_kind_model->get_id($code);
}
