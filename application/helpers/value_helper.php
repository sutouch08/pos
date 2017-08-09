<?php

function paginationConfig()
{		
		$config['full_tag_open'] 		= "<nav><ul class='pagination'>";
		$config['full_tag_close'] 		= "</ul></nav>";
		$config['first_link'] 				= 'First';
		$config['first_tag_open'] 		= "<li>";
		$config['first_tag_close'] 		= "</li>";
		$config['next_link'] 				= 'Next';
		$config['next_tag_open'] 		= "<li>";
		$config['next_tag_close'] 	= "</li>";
		$config['prev_link'] 			= 'prev';
		$config['prev_tag_open'] 	= "<li>";
		$config['prev_tag_close'] 	= "</li>";
		$config['last_link'] 				= 'Last';
		$config['last_tag_open'] 		= "<li>";
		$config['last_tag_close'] 		= "</li>";
		$config['cur_tag_open'] 		= "<li class='active'><a href='#'>";
		$config['cur_tag_close'] 		= "</a></li>";
		$config['num_tag_open'] 		= '<li>';
		$config['num_tag_close'] 		= "</li>";
		$config['uri_segment'] 		= 4;
		return $config;
}

function getConfig($name)
{
	$c =& get_instance();
	$rs = $c->db->select("value")->get_where("tbl_config", array("config_name"=>$name),1);	
	if($rs->num_rows() == 1 )
	{
		return $rs->row()->value;
	}else{
		return false;
	}
}

function select_profile($id = "")
{
	$res = "<option value='0'> เลือกโปรไฟล์ </option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_profile");
	foreach($rs->result() as $rd)
	{
		if($rd->id_profile == $id){ $se = " selected"; }else{ $se = ""; }
		$res .= "<option value='".$rd->id_profile."'".$se.">".$rd->profile_name."</option>";
	}
	return $res;
}

function select_brand( $id = '')
{
	$res = '';
	$rs = get_instance()->db->get('tbl_brand');
	if( $rs->num_rows() > 0 )
	{
		foreach( $rs->result() as $rd )
		{
			$res .= '<option value="'.$rd->id_brand.'" '.isSelected($rd->id_brand, $id).'>'.$rd->name.'</option>';
		}
	}
	return $res;
}

function id_employee()
{
	$c =& get_instance();
	if($c->session->userdata("id_employee") != null )
	{
		return $c->session->userdata("id_employee");
	}
	else
	{
		redirect(base_url()."authentication");
	}
}

function discount($percent, $amount)
{
	$discount = "0.00";
	if($percent != 0.00)
	{
		$discount = number_format($percent,2)." %";
	}
	else if($amount != 0.00)
	{
		$discount = number_format($amount,2)." ฿";
	}
	return $discount;		
}

function paymentMethod($id)
{
	$payment = '';
	$rs = get_instance()->db->select('pay_by')->where('id_order', $id)->get('tbl_payment');
	if( $rs->num_rows() == 1 )
	{
		$payment = $rs->row()->pay_by == 'credit_card' ? 'บัตรเคดิต' : 'เงินสด' ;
	}
	return $payment;
}
function returnedItems($id_order) /// จำนวนรายการ
{
	$rs = get_instance()->db->where('id_order', $id_order)->get('tbl_return_product');
	return $rs->num_rows();
}

function returnedQty($id_order)
{
	$qty = 0;
	$rs = get_instance()->db->select_sum('qty')->where('id_order', $id_order)->get('tbl_return_product');
	if( $rs->num_rows() > 0 )
	{
		$qty = $rs->row()->qty;
	}
	return $qty;
}

function returnedAmount($id_order)
{
	$amount = 0;
	$rs = get_instance()->db->select_sum('total_amount')->where('id_order', $id_order)->get('tbl_return_product');
	if( $rs->num_rows() > 0 )
	{
		$amount = $rs->row()->total_amount;
	}
	return $amount;
}

function empIdByOrder($id_order)
{
	$id_emp = 0;
	$rs = get_instance()->db->where('id_order', $id_order)->get('tbl_order');
	if( $rs->num_rows() == 1 )
	{
		$id_emp = $rs->row()->id_employee;
	}
	return $id_emp;			
}

function selectProvince($se = '')
{
	$options = '<option value="">เลือกจังหวัด</option>';
	$rs = get_instance()->db->select('province')->get('tbl_province');
	if( $rs->num_rows() > 0 )
	{
		foreach( $rs->result() as $rd )
		{
			$options .= '<option value="'.$rd->province.'" '.isSelected($rd->province, $se).'>'.$rd->province.'</option>';
		}
	}
	return $options;
}


?>