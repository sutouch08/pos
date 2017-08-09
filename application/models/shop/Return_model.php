<?php
class Return_model extends CI_Model
{

public function __construct()
{
	parent:: __construct();	
}

public function getReturned($id)
{
	$rs = $this->db->where('id_order', $id)->get('tbl_return_product');
	if( $rs->num_rows() > 0 )
	{
		return $rs->result();
	}
	else
	{
		return FALSE;
	}
}


public function updateReturnDetail($id_return_product, $data)
{
	return $this->db->where('id_return_product', $id_return_product)->update('tbl_return_product', $data);
}

public function insertReturnDetail($data)
{
	$rs = $this->db->insert('tbl_return_product', $data);
	if( $rs )
	{
		return $this->db->insert_id();
	}
	else
	{
		return FALSE;
	}
}

public function getReturnDetail($id_return_product)
{
	$rs = $this->db->where('id_return_product', $id_return_product)->get('tbl_return_product');
	if( $rs->num_rows() == 1 )
	{
		return $rs->row();	
	}
	else
	{
		return FALSE;
	}
}

public function isExists($id_order_detail, $id_order, $barcode)
{
	$rs = $this->db->where('id_order_detail', $id_order_detail)->where('id_order', $id_order)->where('barcode', $barcode)->get('tbl_return_product');
	if( $rs->num_rows() == 1 )
	{
		return $rs->row();	
	}
	else
	{
		return FALSE;
	}
}

public function getReturnedItem($id_order_detail)
{
	$qty = 0;
	$rs = $this->db->where('id_order_detail', $id_order_detail)->get('tbl_return_product');
	if( $rs->num_rows() == 1 )
	{
		$qty  = $rs->row()->qty;
	}
	return $qty;
}

}/// end class
?>