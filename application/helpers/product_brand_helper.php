<?php 
function select_product_brand($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  $list = $ci->product_brand_model->get_all();

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


function brand_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  $list = $ci->product_brand_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function brand_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  $list = $ci->product_brand_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}

function brand_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  return$ci->product_brand_model->get_name($id);  
}

function brand_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  return $ci->product_brand_model->get_name_by_code($code);  
}

function brand_id($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  return $ci->product_brand_model->get_id($code);
}