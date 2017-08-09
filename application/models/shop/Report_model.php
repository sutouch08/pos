<?php 
class Report_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_sell_data($from, $to)
	{
		$rs = $this->db->where("valid", 1)->where("date_upd >=", $from)->where("date_upd <=", $to)->get("tbl_order_detail");
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function getTotalSellQty($from, $to)
	{
		$rs = $this->db->select_sum('qty')->where('date_upd >=', $from)->where('date_upd <=', $to)->get('tbl_order_detail');
		return $rs->row()->qty;	
	}
	
	public function getTotalSellAmount($from, $to)
	{
		$rs = $this->db->select_sum('order_amount')->where('date_upd >=', $from)->where('date_upd <=', $to)->get('tbl_payment');
		return $rs->row()->order_amount;	
	}
	
	public function getTotalSellCash($from, $to)
	{
		$rs = $this->db->select_sum('order_amount')->where('pay_by', 'cash')->where('date_upd >=', $from)->where('date_upd <=', $to)->get('tbl_payment');
		return $rs->row()->order_amount;	
	}
	
	public function getTotalSellCard($from, $to)
	{
		$rs = $this->db->select_sum('order_amount')->where('pay_by', 'credit_card')->where('date_upd >=', $from)->where('date_upd <=', $to)->get('tbl_payment');
		return $rs->row()->order_amount;	
	}
	
	
	
	
	
	
}// end class

?>