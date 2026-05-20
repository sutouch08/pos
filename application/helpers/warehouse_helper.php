<?php
/**
 *  Warehouses role 
 *  1 = คลังซื้อขาย
  *  2 = คลังฝากขายแท้
  *  3 = คลังฝากขายเทียม
  *  4 = คลังรับคืน
  *  5 = คลังรับเข้า
  *  6 = คลังชำรุด
  *  7 = คลังระหว่างทำ
  *  8 = คลังแปรสภาพ
  *  9 = คลังวัตถุดิบ
 */
function select_warehouse_role($se = 0)
{
  $sc = '';
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');
  $list = $ci->warehouse_model->get_all_role();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" ".is_selected($se, $rs->id).">{$rs->name}</option>";
    }      
  }

  return $sc;
}


function select_warehouse($id = '')
{
  $sc = '';
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');
  $options = $ci->warehouse_model->get_all(FALSE);

  if(!empty($options))
  {
    foreach($options as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" data-code=\"{$rs->code}\" data-name=\"{$rs->name}\" ".is_selected($id, $rs->id).">{$rs->code} | {$rs->name}</option>";      
    }
  }

  return $sc;
}


function select_active_warehouse($id = '')
{
  $sc = '';
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');
  $options = $ci->warehouse_model->get_all(TRUE);

  if(!empty($options))
  {
    foreach($options as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" data-code=\"{$rs->code}\" data-name=\"{$rs->name}\" ".is_selected($id, $rs->id).">{$rs->code} | {$rs->name}</option>";      
    }
  }

  return $sc;
}


//--- เอาเฉพาะคลังซื้อขาย
function select_sell_warehouse($id = '')
{
  $sc = '';
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');
  $options = $ci->warehouse_model->get_all_by_role(1);

  if(!empty($options))
  {
    foreach($options as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" data-code=\"{$rs->code}\" data-name=\"{$rs->name}\" ".is_selected($id, $rs->id).">{$rs->code} | {$rs->name}</option>";      
    }
  }

  return $sc;
}


function select_consign_warehouse($id = '')
{
	$sc = "";
	$ci =& get_instance();
	$ci->load->model('masters/warehouse_model');
	$option = $ci->warehouse_model->get_all_by_role(2);

	if(!empty($option))
	{
		foreach($option as $rs)
		{
			$sc .= "<option value=\"{$rs->id}\" data-code=\"{$rs->code}\" data-name=\"{$rs->name}\" ".is_selected($id, $rs->id).">{$rs->code} | {$rs->name}</option>";
		}
	}

	return $sc;
}


function select_consignment_warehouse($id = '')
{
  $sc = "";
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');
  $option = $ci->warehouse_model->get_all_by_role(3);

  if(!empty($option))
  {
    foreach($option as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" data-code=\"{$rs->code}\" data-name=\"{$rs->name}\" ".is_selected($id, $rs->id).">{$rs->code} | {$rs->name}</option>";
    }
  }

  return $sc;
}


function select_common_warehouse($id = '')
{
  $commonList = ['1', '4', '5'];

  $sc = "";
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');  

  $option = $ci->warehouse_model->get_all_by_role($commonList);

  if(!empty($option))
  {
    foreach($option as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" data-code=\"{$rs->code}\" data-name=\"{$rs->name}\" ".is_selected($id, $rs->id).">{$rs->code} | {$rs->name}</option>";
    }
  }

  return $sc;
}


function warehouse_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');

  return $ci->warehouse_model->get_name($id);
}


function warehouse_code($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');

  return $ci->warehouse_model->get_code($id);
}


function warehouse_code_and_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');

  $wh = $ci->warehouse_model->get($id);

  if(!empty($wh))
  {
    return $wh->code . ' | ' . $wh->name;
  }

  return '';
}


function warehouse_role_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');

  return $ci->warehouse_model->role_name($id);
}


function warehouse_role_name_array()
{
  $arr = [];
  
  $ci =& get_instance();
  $ci->load->model('masters/warehouse_model');

  $list = $ci->warehouse_model->get_all_role();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs->name;
    }
  }

  return $arr;
}

