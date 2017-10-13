<?php 
class Size_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($id="")
	{
		if($id != "")
		{
			$this->db->where("id_size", $id);
		}
		$this->db->order_by("position", "asc");
		$rs = $this->db->get("tbl_size");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}		
	}
	
	
	public function add($data)
	{
		$data['position'] = $this->db->select_max("position")->get("tbl_size",1)->row()->position+1;
		$rs = $this->db->insert("tbl_size", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	public function update($id, $data)
	{
		$this->db->where("id_size", $id);
		$rs = $this->db->update("tbl_size", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	public function delete($id)
	{
		$pos = $this->db->get_where("tbl_size", array("id_size"=>$id), 1)->row()->position;
		$ro = $this->db->order_by("position","asc")->get_where("tbl_size", array("position >"=>$pos));
		$rs = $this->db->delete("tbl_size", array("id_size"=>$id));
		if($rs)
		{
			if($ro->num_rows() >0)
			{
				foreach( $ro->result() as $rm )
				{
					$this->step_up($rm->id_size, $rm->position);
				}
			}
			return true;
		}else{
			return false;
		}
	}	
	
	
	
	public function valid_code($code, $id)
	{
		if($id != "")
		{
			$this->db->where("size_code", $code)->where("id_size !=", $id);
		}else{
			$this->db->where("size_code", $code);
		}
		$rs = $this->db->get("tbl_size");
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	
	public function valid_name($name, $id)
	{
		if($id != "")
		{
			$this->db->where("size_name", $name)->where("id_size !=", $id);
		}else{
			$this->db->where("size_name", $name);
		}
		$rs = $this->db->get("tbl_size");
		if($rs->num_rows() >0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	
	public function top_position()
	{
		$rs = $this->db->select_max("position")->get("tbl_size");
		if($rs->num_rows() == 1)
		{
			return $rs->row()->position;
		}else{
			return false;
		}
	}
	
	public function move_up($id, $position)
	{
		$up = $position -1;
		$rm = $this->db->select_max("id_size")->where("position <", $position)->get("tbl_size")->row()->id_size;
		$rs = $this->db->where("id_size", $id)->update("tbl_size", array("position"=>$up));
		if($rs)
		{
			$ro = $this->db->where("id_size", $rm)->update("tbl_size", array("position"=>$position));
			if($ro){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	public function move_down($id, $position)
	{
		$up = $position +1;
		$rm = $this->db->select_min("id_size")->where("position >", $position)->get("tbl_size")->row()->id_size;
		$rs = $this->db->where("id_size", $id)->update("tbl_size", array("position"=>$up));
		if($rs)
		{
			$ro = $this->db->where("id_size", $rm)->update("tbl_size", array("position"=>$position));
			if($ro){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function step_up($id, $position)
	{
		$pos = $position-1;	
		$this->db->where("id_size", $id)->where("position", $position);
		$rs = $this->db->update("tbl_size", array("position"=>$pos));
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
}// End class


?>