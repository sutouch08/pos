<?php 
class Color_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	
	}
	
	/************************* Color  ************************/
	public function get_color($id="")
	{
		if($id != "")
		{
			$this->db->where("id_color", $id);
		}
		$rs = $this->db->get("tbl_color");
		if($rs->num_rows() >0 )
		{
			return $rs->result();
		}else{
			return false;
		}			
	}
	
	public function add_color($data)
	{
		$data['position'] = $this->db->select_max("position")->get("tbl_color")->row()->position +1;
		$rs = $this->db->insert("tbl_color",$data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}		
	}
	
	public function update_color($id, $data)
	{
		$rs = $this->db->where("id_color", $id)->update("tbl_color", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	public function delete_color($id)
	{
		$rs = $this->db->delete("tbl_color", array("id_color"=>$id));
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function valid_code($code, $id)
	{
		if($id !="")
		{
			$this->db->where("color_code", $code)->where("id_color !=", $id);
		}else{
			$this->db->where("color_code", $code);
		}
		$rs = $this->db->get("tbl_color");
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function valid_name($code, $id)
	{
		if($id !="")
		{
			$this->db->where("color_name", $code)->where("id_color !=", $id);
		}else{
			$this->db->where("color_name", $code);
		}
		$rs = $this->db->get("tbl_color");
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	/*************************   Color Group   **********************/
	public function get_group($id="")
	{
		if($id !="")
		{
			$this->db->where("id_color_group", $id);
		}
		$rs = $this->db->get("tbl_color_group");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function add_group($data)
	{
		$rs = $this->db->insert("tbl_color_group", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function update_group($id, $data)
	{
		$this->db->where("id_color_group", $id);
		$rs = $this->db->update("tbl_color_group", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function delete_group($id)
	{
		$rs = $this->db->delete("tbl_color_group", array("id_color_group"=>$id));
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	
}// end class


?>