<?php
class Main_model extends CI_Model
{
	
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function change_status($id_order, $status = 1)
	{
		$rs = $this->db->where("id_order", $id_order)->update("tbl_order", array("status"=>1));
		return $rs;
	}
	
	public function add_payment($data)
	{
		$rs = $this->db->insert("tbl_payment", $data);
		return $rs;
	}
	
	public function payment_list($id_employee = "")
	{
		if($id_employee != "")
		{
			$rs = $this->db->where("id_employee", $id_employee)->get("tbl_payment");
		}
		else
		{
			$rs = $this->db->get("tbl_payment");
		}
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function check_status($id_order)
	{
		$rs = $this->db->select("status")->where("id_order", $id_order)->get("tbl_order");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->status;
		}
		else
		{
			return false;
		}
	}
	
	public function get_payment($id_order)
	{
		$rs = $this->db->where("id_order", $id_order)->get("tbl_payment");
		if($rs->num_rows() == 1)
		{
			return $rs->row();	
		}
		else
		{
			return $rs->num_rows();
		}
	}
	
	public function get_total_discount($id_order)
	{
		$rs = $this->db->select_sum("total_discount")->where("id_order", $id_order)->get("tbl_order_detail");
		return $rs->row()->total_discount;	
	}
	public function add_detail($data)
	{
		$rs = $this->db->insert("tbl_order_detail", $data);
		if( $rs )
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function update_detail($id, $data)
	{
		$rs = $this->db->where("id_order_detail", $id)->update("tbl_order_detail", $data);
		return $rs;	
	}
	public function new_order($data)
	{
		$rs = $this->db->insert("tbl_order", $data);
		if($rs)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	
	public function get_data($id)
	{
		$rs = $this->db->where("id_order", $id)->get("tbl_order");
		return $rs->result();
	}
	public function get_order($id)
	{
		$rs = $this->db->where("id_order", $id)->get("tbl_order");
		return $rs->row();
	}
	
	public function get_item($barcode)
	{
		$rs = $this->db->where("barcode", $barcode)->get("tbl_items");
		if($rs->num_rows() > 0)
		{
			return $rs->row();
		}
		else
		{
			return false;
		}
	}
	
	public function delete_item($id_order_detail)
	{
		$rs = $this->db->where("id_order_detail", $id_order_detail)->delete("tbl_order_detail");
		return $rs;	
	}
	
	public function get_total_order($id_order)
	{
		$rs = $this->db->select_sum("total_amount")->where("id_order", $id_order)->get("tbl_order_detail");
		return $rs->row()->total_amount;	
	}
	
	public function valid_detail($id_order, $valid = 1)
	{
		$rs = $this->db->where("id_order", $id_order)->update("tbl_order_detail", array("valid"=>1));
		return $rs;
	}
	
	public function get_reference($id_order)
	{
		$rs = $this->db->select("reference")->where("id_order", $id_order)->get("tbl_order");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->reference;
		}
		else
		{
			return 0;
		}
	}
	
	public function get_detail_data($id_order, $barcode)
	{
		$rs = $this->db->where("id_order", $id_order)->where("barcode", $barcode)->get("tbl_order_detail");
		if($rs->num_rows() > 0 )
		{
			return $rs->row();
		}
		else
		{
			return false;
		}
	}
	
	public function check_open_order($id_employee)
	{
		$rs = $this->db->where("id_employee", $id_employee)->where("status", 0)->get("tbl_order");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function get_detail($id_order)
	{
		$rs = $this->db->where("id_order", $id_order)->get("tbl_order_detail");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function isExistsDetail($id_order, $barcode, $p_dis, $a_dis, $id_promo)
	{
		$rs = $this->db->where('id_order', $id_order)->where('barcode', $barcode)->where('discount_percent', $p_dis)->where('discount_amount', $a_dis)->where('id_promotion', $id_promo)->get('tbl_order_detail');	
		if( $rs->num_rows() == 0 )
		{
			return FALSE;
		}
		else
		{
			return $rs->row();
		}
	}
	
	public function getDetailRow($id, $barcode)
	{
		$rs = $this->db->where("id_order_detail", $id)->where('barcode', $barcode)->get('tbl_order_detail');
		if( $rs->num_rows() == 1 )
		{
			return $rs->row();
		}
		else
		{
			return false;
		}
	}
	
	public function getIdOrder($id_order_detail)
	{
		$rs = $this->db->where('id_order_detail', $id_order_detail)->get('tbl_order_detail');
		return $rs->row()->id_order;	
	}
	
}/// end class
?>