<?php 
class Promotion_model extends CI_Model
{

public function __construct()
{
	parent:: __construct();	
}

public function add_promotion($data)
{
	$rs = $this->db->insert('tbl_promotion', $data);
	if( $rs )
	{
		$id = $this->db->insert_id();	
		return $this->get_promotion($id);
	}
	else
	{
		return FALSE;
	}
}

public function get_promotion($id)
{
	$rs = $this->db->where('id', $id)->get('tbl_promotion');
	if( $rs->num_rows() == 1 )
	{
		return $rs->row();
	}
	else
	{
		return FALSE;
	}
}
public function getIdPromotionByCode($code)
{
	$rs = $this->db->select('id')->where('code', $code)->get('tbl_promotion')	;
	if( $rs->num_rows() == 1 )
	{
		return $rs->row()->id;
	}
	else
	{
		return FALSE;
	}
}

/// ตรวจสอบสินค้าว่ามีโปรโมชั่นหรือไม่
public function isPromotion($barcode)
{
	$this->db->select('id_promotion, set_price, percent, amount')->join('tbl_promotion', 'tbl_promotion.id = tbl_promotion_items.id_promotion');
	$this->db->where('barcode', $barcode)->where('start_date <=', fromDate(date('Y-m-d')))->where('end_date >=', toDate(date('Y-m-d')))->where('active', 1);
	$rs = $this->db->order_by('tbl_promotion_items.id_promotion', 'desc')->get('tbl_promotion_items');
	
	if( $rs->num_rows() > 0 )
	{
		return $rs->row();	
	}
	else
	{
		return FALSE;
	}
}
public function isExists($barcode, $id_promo)
{
	$rs = $this->db->where('barcode', $barcode)->where('id_promotion', $id_promo)->get('tbl_promotion_items');	
	if( $rs->num_rows() == 0 )
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

public function addPromotionItem($data)
{
	return $this->db->insert('tbl_promotion_items', $data);	
}

	public function count_row($txt = "")
	{
		if($txt != "")
		{
			$rs = $this->db->like("code", $txt)->or_like("promo_name", $txt)->get("tbl_promotion");
		}
		else
		{
			$rs = $this->db->get("tbl_promotion");
		}
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function count_style_row($txt = "")
	{
		if( $txt != "" )
		{
			$this->db->like("item_code", $txt)->or_like("item_name", $txt)->or_like('style', $txt);
		}
		$rs = $this->db->group_by('style')->get("tbl_items");
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
		
	}
	
	public function search_count_row($txt)
	{
		$this->db->like("code", $txt)->or_like("promo_name", $txt);
		$rs = $this->db->get("tbl_promotion");
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function get_data($id="", $perpage="", $limit ="")
	{
		if($id !=""){
			$rs = $this->db->get_where("tbl_promotion", array("id" =>$id), 1);
			if($rs->num_rows() == 1){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->order_by("date_upd","desc");
			$rs = $this->db->limit($perpage, $limit)->get("tbl_promotion");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	public function get_search_data($txt, $perpage="", $limit ="")
	{
		$this->db->like("code", $txt)->or_like("promo_name", $txt);
			$rs = $this->db->limit($perpage, $limit)->get("tbl_promotion");
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
	}
	
public function deleteImported($id)
{
	return $this->db->where('id_promotion', $id)->delete('tbl_promotion_items');	
}
	
}/// End class

?>