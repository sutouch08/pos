<?php
class Rule_model extends CI_Model
{
	
public function __construct()
{
	parent::__construct();
}

public function countRow($txt = '')
{
	if( $txt != '' )
	{
		$this->db->like('code', $txt)->or_like('name', $txt);
	}
	$rs = $this->db->get('tbl_promotion_rule');
	return $rs->num_rows();
}

public function getData($id = '', $perpage = 20, $limit = 1)
{
	if( $id != '' )
	{
		$this->db->where('id_rule', $id);
	}
	else
	{
		$this->db->limit($perpage, $limit);
	}
	$rs = $this->db->get('tbl_promotion_rule');
	if( $rs->num_rows() > 0 )
	{
		return $rs->result();
	}
	else
	{
		return FALSE;
	}
}

public function getSearchData($txt, $perpage = 50, $limit = 1)
{
	$rs = $this->db->like('code', $txt)->or_like('name', $txt)->limit($perpage, $limit)->get('tbl_promotion_rule');
	if( $rs->num_rows() > 0 )
	{
		return $rs->result();
	}
	else
	{
		return FALSE;
	}
}
	
	
}// end class
?>