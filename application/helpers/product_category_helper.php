<?php
function select_product_category($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  $list = $ci->product_category_model->get_all();

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


function category_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  $list = $ci->product_category_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function category_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  $list = $ci->product_category_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function category_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  return $ci->product_category_model->get_name($id);
}

function category_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  return $ci->product_category_model->get_name_by_code($code);
}

function category_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  return $ci->product_category_model->get_id($code);
}
