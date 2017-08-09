<?php
class Payment_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	
	}
	
	public function count_row($txt = "")
	{
		if($txt != "")
		{
			$rs = $this->db->like("reference", $txt)->get("tbl_payment");
		}
		else
		{
			$rs = $this->db->get("tbl_payment");
		}
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
	}

	/*************************  employee  ****************************/
	public function get_data($id="", $perpage="", $limit ="")
	{
		if($id !=""){
			$rs = $this->db->get_where("tbl_payment", array("id_payment"=>$id), 1);
			if($rs->num_rows() == 1){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->order_by("date_upd","desc");
			$rs = $this->db->limit($perpage, $limit)->get("tbl_payment");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	public function get_search_data($txt, $perpage="", $limit ="")
	{
		$this->db->like("reference", $txt);
			$rs = $this->db->limit($perpage, $limit)->get("tbl_payment");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
	}
}/// end class