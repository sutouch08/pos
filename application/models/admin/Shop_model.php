<?php
class Shop_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	
	}
	
	public function addShop(array $data)
	{
		$rs = $this->db->insert('tbl_shop', $data);
		if( $rs )
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function updateShop($id, array $data)
	{
		return $this->db->where('id_shop', $id)->update('tbl_shop', $data);	
	}
	
	public function count_row($txt = "")
	{
		if($txt != "")
		{
			$rs = $this->db->like("shop_code", $txt)->or_like("shop_name", $txt)->or_like('province', $txt)->get("tbl_shop");
		}
		else
		{
			$rs = $this->db->get("tbl_shop");
		}
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return FALSE;
		}
	}
	
	public function deleteShop($id)
	{
		return $this->db->where('id_shop', $id)->delete('tbl_shop');	
	}
	
	public function search_count_row($txt)
	{
		$this->db->like("shop_code", $txt)->or_like("shop_name", $txt)->or_like('province', $txt);
		$rs = $this->db->get("tbl_shop");
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return FALSE;
		}
	}
	
	public function get_data($id="", $perpage="", $limit ="")
	{
		if($id !=""){
			$rs = $this->db->where("id_shop", $id)->get('tbl_shop');
			if($rs->num_rows() == 1){
				return $rs->row();
			}else{
				return FALSE;
			}
		}else{
			$this->db->order_by("date_upd","desc");
			$rs = $this->db->limit($perpage, $limit)->get("tbl_shop");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return FALSE;
			}
		}
	}
	
	public function get_search_data($txt, $perpage="", $limit ="")
	{
		$this->db->like("shop_code", $txt)->or_like("shop_name", $txt)->or_like('province', $txt);
			$rs = $this->db->limit($perpage, $limit)->get("tbl_shop");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return FALSE;
			}
	}
	
	/******** AutoComplete ************/
	public function searchShop($txt)
	{
		$this->db->select('id_shop, shop_code, shop_name');
		$this->db->like("shop_code", $txt)->or_like("shop_name", $txt)->or_like('province', $txt);
		$rs = $this->db->get("tbl_shop");
		$data = array();
		if( $rs->num_rows() > 0 )
		{	
			foreach( $rs->result() as $rd )
			{
				$data[] = $rd->shop_code.' | '.$rd->shop_name.' | '.$rd->id_shop;
			}
		}
		return $data;
	}
	
	public function isCodeExists($code, $id = '')
	{
		if( $id != '' )
		{
			$this->db->where('shop_code', $code)->where('id_shop !=', $id);
		}
		else
		{
			$this->db->where('shop_code', $code);	
		}
		$rs = $this->db->get('tbl_shop');
		if( $rs->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
	}
	
	public function isNameExists($name, $id = '' )
	{
		if( $id != '' )
		{
			$this->db->where('shop_name', $name)->where('id_shop !=', $id);	
		}
		else
		{
			$this->db->where('shop_name', $name);
		}
		$rs = $this->db->get('tbl_shop');
		if( $rs->num_rows() > 0 )
		{
			return TRUE;	
		}
		else
		{
			return FALSE;
		}		
	}	
	
	public function getShopEmp($id)
	{
		$rs = $this->db->where('id_shop', $id)->get('tbl_employee');
		if( $rs->num_rows() > 0 )
		{
			return $rs->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function isInShop($id_employee, $id_shop)
	{
		$rs = $this->db->where('id_shop', $id_shop)->where('id_employee', $id_employee)->get('tbl_employee');
		if( $rs->num_rows() == 1 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function addToShop($id_employee, $id_shop)
	{
		$rs = $this->db->where('id_employee', $id_employee)->update('tbl_employee', array('id_shop' => $id_shop));
		return $rs;
	}
	
	public function removeEmpShop($id_employee)
	{
		return $this->db->where('id_employee', $id_employee)->update('tbl_employee', array('id_shop' => 0));
	}
	
	public function removeFromShop($id_shop)
	{
		return $this->db->where('id_shop', $id_shop)->update('tbl_employee', array('id_shop' => 0) );	
	}
	
	public function isTransection($id_shop, $table = 'tbl_order')
	{
		$rs = $this->db->select('id_shop')->where('id_shop', $id_shop)->limit(1)->get($table);
		if( $rs->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}// End class

?>