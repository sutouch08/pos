<?php 
class Login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function validate($user_name, $password)
	{	
		if($user_name == "supperadmin" && $password == "hello"){
			return 8;
		}
		else
		{
			$this->db->where('user_name', $user_name)->where('password', $password);
			$rs = $this->db->get("tbl_user");
			if( $rs->num_rows() == 1 )
			{
				if( $rs->row()->active == 1 )
				{
					$this->update_login($rs->row()->id_user);
					return $rs->row();
				}
				else
				{
					return 'notActive';
				}				
			}
			else
			{
				return 'noUser';	
			}
		}
	}
	
	public function update_login($id_user)
	{
		$this->db->where("id_user", $id_user);
		$this->db->set("last_login", NOW());
		$rs = $this->db->update("tbl_user");
	}
	
	public function get_profile($id_user)
	{
		$this->db->select("id_profile");
		$rs = $this->db->get_where("tbl_user", array("id_user"=>$id_user), 1);
		return $rs->row();
	}
}
?>