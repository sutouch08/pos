<?php
class Category_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($id="")
	{
		if($id !="")
		{
			$this->db->where("id_category", $id);	
		}
		$rs = $this->db->get("tbl_category");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	
	public function add($data)
	{
		$rs = $this->db->insert("tbl_category", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function update($id, $data)
	{
		$this->db->where("id_category", $id);
		$rs = $this->db->update("tbl_category", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function delete($id)
	{
		$rs = $this->db->where("id_category", $id)->delete("tbl_category");
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}

	
	public function get_max_deep()
	{
		$rs = $this->db->select_max("level")->get("tbl_category",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->level;
		}else{
			return 0;
		}
	}
	
	public function get_category_by_level($level)
	{
		$rs = $this->db->get_where("tbl_category", array("level"=>$level));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_category_by_parent($parent)
	{
		$rs = $this->db->get_where("tbl_category", array("id_parent"=>$parent));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_level($id_parent)
	{
		$rs = $this->db->select("level")->get_where("tbl_category", array("id_category"=>$id_parent), 1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->level+1;
		}else{
			return 2;
		}
	}
	
	public function valid_name($name, $id)
	{
		if($id !="")
		{
			$this->db->where("category_name", $name)->where("id_category !=", $id);
		}else{
			$this->db->where("category_name", $name);
		}
		$rs = $this->db->get("tbl_category");
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function have_children($id)
	{
		$rs = $this->db->get_where("tbl_category", array("id_parent"=>$id));
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
}// End class



?>