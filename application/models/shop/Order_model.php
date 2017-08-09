<?php
class Order_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	
	}
	
	public function get_data($id="", $perpage="", $limit ="")
	{
		if($id !=""){
			$rs = $this->db->get_where("tbl_order", array("id_order"=>$id), 1);
			if($rs->num_rows() == 1){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->order_by("date_upd","desc");
			$rs = $this->db->limit($perpage, $limit)->get("tbl_order");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	public function get_search_data($txt, $perpage="", $limit ="")
	{
		$this->db->like("item_code", $txt)->or_like("item_name", $txt)->or_like("style", $txt)->or_like("barcode", $txt);
			$rs = $this->db->limit($perpage, $limit)->get("tbl_items");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
	}
	
	
	
}// End class

?>