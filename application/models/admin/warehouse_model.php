<?php 
class Warehouse_model extends CI_Model
{
	public function __construch()
	{
		parent::__construct();
	}
	
	public function get_data($id="")
	{
		if($id !="" )
		{
			$this->db->where("id_warehouse", $id);
		}
		$rs = $this->db->get("tbl_warehouse");
		if( $rs->num_rows() >0 )
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	
}// End class

?>