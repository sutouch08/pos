<?php 
class Profile_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($id)
	{
		$rs = $this->db->where("id_user", $id)->get("tbl_personal_config",1);
		if($rs->num_rows() == 1)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function update_lang($id, $lang)
	{
		$data['language'] = $lang;
		$rs = $this->db->where("id_user", $id)->update("tbl_personal_config", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
}// End class

?>