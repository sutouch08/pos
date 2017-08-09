<?php
function setError($message)
{
	$c =& get_instance();
	$c->session->set_flashdata("error", $message);
}

function setMessage($message)
{
	$c =& get_instance();
	$c->session->set_flashdata("success", $message);
}

function setInfo($message)
{
	$c =& get_instance();
	$c->session->set_flashdata("info", $message);
}

function isActived($value)
{
	$icon = "<i class='fa fa-remove' style='color:red'></i>";
	if($value == "1")
	{
		$icon = "<i class='fa fa-check' style='color:green'></i>";
	}
	return $icon;
}

function isChecked($val1, $val2)
{
	$value = "";
	if( $val1 == $val2 )
	{
		$value = 'checked';
	}
	return $value;
}

function isSelected($val1, $val2)
{
	$value = "";
	if($val1 == $val2)
	{
		$value = 'selected';
	}
	return $value;
}


function empName($id_employee)
{
	$c =& get_instance();
	$name = "";
	$rs = $c->db->select("first_name, last_name")->where("id_employee", $id_employee)->get("tbl_employee");
	if($rs->num_rows() == 1 )
	{
		$name = $rs->row()->first_name." ".$rs->row()->last_name;
	}
	return $name;
}

function empNameByUser($id_user)
{
	$c =& get_instance();
	$name = "";
	$rs = $c->db->select("first_name")->join("tbl_employee","tbl_employee.id_employee = tbl_user.id_employee")->get_where("tbl_user", array("id_user"=>$id_user),1);
	if($rs->num_rows() == 1)
	{
		$name = $rs->row()->first_name;
	}
	return $name;	
}


function newOrderNo($date = "")
{
	$c =& get_instance();
	$prefix = getConfig("PREFIX_ORDER");
	if($date == ''){ $date = date("Y-m-d"); }
	$year = date("y", strtotime($date));
	$month = date("m", strtotime($date));
	$qs = $c->db->query("SELECT MAX(reference) AS reference FROM tbl_order WHERE reference LIKE '%".$prefix."-".$year.$month."%'");
	$str = $qs->row()->reference;
	if($str !="")
	{
		$ra = explode('-', $str, 2);
		$num = $ra[1];
		$run_num = $num + 1;
		$reference = $prefix."-".$run_num;		
	}else{
		$reference = $prefix."-".$year.$month."00001";
	}
	return $reference;		
}

function newPromoCode($date = "")
{
	$c =& get_instance();
	$prefix = getConfig("PREFIX_PROMOTION");
	if($date == ''){ $date = date("Y-m-d"); }
	$year = date("y", strtotime($date));
	$month = date("m", strtotime($date));
	$qs = $c->db->query("SELECT MAX(code) AS reference FROM tbl_promotion WHERE code LIKE '%".$prefix."-".$year.$month."%'");
	$str = $qs->row()->reference;
	if($str !="")
	{
		$ra = explode('-', $str, 2);
		$num = $ra[1];
		$run_num = $num + 1;
		$reference = $prefix."-".$run_num;		
	}else{
		$reference = $prefix."-".$year.$month."00001";
	}
	return $reference;		
}

function brandName($id_b)
{
	$name = '';
	$rs = get_instance()->db->where('id_brand', $id_b)->get('tbl_brand');
	if( $rs->num_rows() == 1 )
	{
		$name = $rs->row()->name;
	}
	return $name;
}
function getIdBrandByBarcode($barcode)
{
	$rs = get_instance()->db->select('id_brand')->where('barcode', $barcode)->get('tbl_items');
	if( $rs->num_rows() == 1 )
	{
		return $rs->row()->id_brand;
	}
	else
	{
		return 0;
	}
}

function shopName($id)
{
	$rs = get_instance()->db->select('shop_name')->where('id_shop', $id)->get('tbl_shop');
	if( $rs->num_rows() == 1 )
	{
		return $rs->row()->shop_name;
	}
	else
	{
		return '';
	}
}

?>
