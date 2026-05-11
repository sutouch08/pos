<?php

function select_vat_group($code = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list = $ci->vat_model->get_all(NULL, TRUE); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" data-rate="'.$rs->rate.'" data-type="'.$rs->type.'" data-id="'.$rs->id.'" '.is_selected($code, $rs->code).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_sale_vat_group($code = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list =  $ci->vat_model->get_all('S', TRUE); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" data-rate="'.$rs->rate.'" data-type="'.$rs->type.'" data-id="'.$rs->id.'" '.is_selected($code, $rs->code).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_purchase_vat_group($code = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list =  $ci->vat_model->get_all('P', TRUE); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" data-rate="'.$rs->rate.'" data-type="'.$rs->type.'" data-id="'.$rs->id.'" '.is_selected($code, $rs->code).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}

//---- แสดงราคาขาย แยก หรือ รวม vat ตามเงื่อนไขทีส่ตามเงื่อนไขทีส่งมา
//---- โดยราคาที่ส่งเข้ามา จะเป็นราคา รวม vat
//---- แต่จะ return ราคาที่ถอด vat หากเงื่อนไขเป็น E  โดย I = รวม vat E = ไม่รวม vat
function vat_price($price, $option = 'I', $rate = 7, $decimal = 2)
{
	if($price <= 0)
	{
		return $price;
	}

	if($option === 'I')
	{
		return $price;
	}

	if($rate > 0)
	{
		$re_vat = ($rate + 100)/100;
		return round(($price/$re_vat), $decimal);
	}

	return $price;
}

function get_vat_amount($amount, $vat = NULL, $type = 'I')
{
  $re_vat = 0;

  if ($vat === NULL)
  {
    $vat = getConfig('SALE_VAT_RATE');
  }

  if ($vat != 0)
  {
    if ($type == 'E')
    {
      $re_vat = $amount * ($vat * 0.01);
    }
    else
    {
      $re_vat = ($amount * $vat) / (100 + $vat);
    }
  }

  return round($re_vat, 6);
}


function add_vat($amount, $vat = NULL)
{
  if ($vat === NULL OR $vat === '' OR $vat < 0)
  {
    $vat = floatval(getConfig('SALE_VAT_RATE')); //-- 7
  }

  if ($vat > 0)
  {
    $amount = $amount * (1 + ($vat * 0.01));
  }

  return round($amount, 6);
}


function remove_vat($amount, $vat = NULL)
{
  if ($vat === NULL OR $vat === '' OR $vat < 0)
  {
    $vat = floatval(getConfig('SALE_VAT_RATE')); //-- 7
  }

  if ($vat > 0)
  {
    $amount  = $amount / (1 + ($vat * 0.01));
  }

  return round($amount, 6);
}


function select_vat_type($type = 'S')
{
  $option = '<option value="S" '.is_selected($type, 'S').'>Sales</option>';
  $option .= '<option value="P" '.is_selected($type, 'P').'>Purchase</option>';
  return $option;
}


function sale_vat_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list = $ci->vat_model->get_all('S', NULL); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function sale_vat_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list = $ci->vat_model->get_all('S', NULL); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}


function purchase_vat_code_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list = $ci->vat_model->get_all('P', NULL); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->code] = $rs;
    }
  }

  return $arr;
}


function purchase_vat_array()
{
  $arr = array();
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $list = $ci->vat_model->get_all('P', NULL); //--- type: S = Sales, P = Purchase, NULL = all | active = TRUE/FALSE

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $arr[$rs->id] = $rs;
    }
  }

  return $arr;
}


function purchase_vat_name($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $rs = $ci->vat_model->get_by_code($code);

  if(!empty($rs))
  {
    return $rs->name;
  }

  return NULL;
}


function sale_vat_name($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/vat_model');
  $rs = $ci->vat_model->get_by_code($code);

  if(!empty($rs))
  {
    return $rs->name;
  }

  return NULL;
}

 ?>
