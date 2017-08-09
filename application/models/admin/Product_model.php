<?php 
class Product_model extends CI_Model
{
	public function __construch()
	{
		parent::__construct();
	}
	
	public function get_item($id)
	{
		if($id != "")
		{
			$rs = $this->db->get_where("tbl_items", array("id_item" => $id));
			return $rs->row();	
		}
	}
	
	public function getProductStyle($txt = '', $perpage, $limit)
	{
		if( $txt != '' )
		{
			$this->db->like("item_code", $txt)->or_like("item_name", $txt)->or_like("style", $txt);
		}
		$rs = $this->db->group_by('style')->limit($perpage, $limit)->get("tbl_items");
		if($rs->num_rows() >0 ){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function getItemsFromStyle($style)
	{
		$rs = $this->db->where('style', $style)->get('tbl_items');
		if( $rs->num_rows() > 0 )
		{
			return $rs->result();
		}
		else
		{
			return FALSE;
		}
	}	
	
	public function delete_item($id)
	{
		$rs = $this->db->where("id_item", $id)->delete("tbl_items");
		return $rs;	
	}
	
	public function getAllBrand()
	{
		$rs = $this->db->get('tbl_brand');
		if( $rs->num_rows() > 0 )
		{
			return $rs->result();	
		}
		else
		{
			return FALSE;
		}
	}
	
	
	public function check_barcode($barcode, $id = "")
	{
		$barcode = trim($barcode);
		if($id != "")
		{
			$rs = $this->db->where("barcode", $barcode)->where("id_item !=", $id)->get("tbl_items");
		}
		else
		{
			$rs = $this->db->get_where("tbl_items", array("barcode"=>$barcode));
		}
		return $rs->num_rows();
	}
	
	public function add_item($data)
	{
		$qs = $this->db->insert("tbl_items", $data);
		if($qs)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
	
	public function isExists($barcode)
	{
		$rs = $this->db->where("barcode", $barcode)->get("tbl_items");
		return $rs->num_rows();
	}
	
	public function update_import_item($barcode, $data)
	{
		return $this->db->where("barcode", $barcode)->update("tbl_items", $data);	
	}
	
	public function update_item($id, $data)
	{
		$rs = $this->db->where("id_item", $id)->update("tbl_items", $data);
		return $rs;		
	}
	
	public function count_row($txt = "")
	{
		if($txt != "")
		{
			$rs = $this->db->like("item_code", $txt)->or_like("item_name", $txt)->or_like("style", $txt)->or_like("barcode", $txt)->get("tbl_items");
		}
		else
		{
			$rs = $this->db->get("tbl_items");
		}
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function search_count_row($txt)
	{
		$this->db->like("item_code", $txt)->or_like("item_name", $txt);
		$rs = $this->db->get("tbl_items");
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	/*************************  Product  ****************************/
	public function get_data($id="", $perpage="", $limit ="")
	{
		if($id !=""){
			$rs = $this->db->get_where("tbl_items", array("id_item"=>$id), 1);
			if($rs->num_rows() == 1){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->order_by("date_upd","desc");
			$rs = $this->db->limit($perpage, $limit)->get("tbl_items");
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
		
	public function update($id, $data)
	{
		$rs = $this->db->where("id_item", $id)->update("tbl_items", $data);	
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}

	/********************************* End Product  *********************************/

	
	
}// End class

?>