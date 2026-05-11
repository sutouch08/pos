<?php
class Sender_model extends CI_Model
{
	private $tb = "sender";

  public function __construct()
  {
    parent::__construct();
  }

  public function add(array $ds = array())
	{
		if(!empty($ds))
		{
			if($this->db->insert($this->tb, $ds))
			{
				return $this->db->insert_id();
			}
		}

		return FALSE;
	}
	

	public function update($id, array $ds = array())
	{
		if(!empty($ds))
		{
			return $this->db->where('id', $id)->update($this->tb, $ds);
		}

		return FALSE;
	}


	public function delete($id)
	{
		return $this->db->where('id', $id)->delete($this->tb);
	}


	public function get($id)
	{
		return $this->db->where('id', $id)->get($this->tb)->row();
	}


	public function get_by_id($id)
	{
		$rs = $this->db->where('id', $id)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row();
		}

		return NULL;
	}


	public function get_by_code($code)
	{
		$rs = $this->db->where('code', $code)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row();
		}

		return NULL;
	}


	public function get_all($active = TRUE)
	{
		if($active === TRUE)
		{
			$this->db->where('active', 1);
		}

		$rs = $this->db->get($this->tb);

		if($rs->num_rows() > 0)
		{
			return $rs->result();
		}

		return NULL;
	}


	public function get_common_list()
	{
		$rs = $this->db->where('active', 1)->where('show_in_list', 1)->get($this->tb);

		if($rs->num_rows() > 0)
		{
			return $rs->result();
		}

		return NULL;
	}


	public function get_name($id)
	{
		$rs = $this->db->select('name')->where('id', $id)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row()->name;
		}

		return NULL;
	}


	public function get_id($code)
	{
		$rs = $this->db->select('id')->where('code', $code)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row()->id;
		}

		return NULL;
	}


	public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
	{
		$order_by = empty($ds['order_by']) ? 'code' : $ds['order_by'];
		$sort_by = empty($ds['sort_by']) ? 'ASC' : $ds['sort_by'];

		if (! empty($ds['code']))
		{
			$this->db
				->group_start()
				->like('code', $ds['code'])
				->or_like('name', $ds['code'])
				->group_end();
		}

		if (isset($ds['active']) && $ds['active'] !== 'all')
		{
			$this->db->where('active', $ds['active']);
		}

		if(isset($ds['show_in_list']) && $ds['show_in_list'] !== 'all')
		{
			$this->db->where('show_in_list', $ds['show_in_list']);
		}

		$rs = $this->db
		->order_by($order_by, $sort_by)
		->limit($perpage, $offset)
		->get($this->tb);

		if($rs->num_rows() > 0)
		{
			return $rs->result();
		}

		return NULL;
	}


	public function count_rows(array $ds = array())
	{
		if (! empty($ds['code']))
		{
			$this->db
				->group_start()
				->like('code', $ds['code'])
				->or_like('name', $ds['code'])
				->group_end();
		}

		if (isset($ds['active']) && $ds['active'] !== 'all')
		{
			$this->db->where('active', $ds['active']);
		}

		if(isset($ds['show_in_list']) && $ds['show_in_list'] !== 'all')
		{
			$this->db->where('show_in_list', $ds['show_in_list']);
		}

		return $this->db->count_all_results($this->tb);
	}


	public function is_exists_code($code, $id = NULL)
	{		
		if (! empty($id))
		{
			$this->db->where('id !=', $id);
		}

		return $this->db->where('code', $code)->count_all_results($this->tb) > 0;
	}
	

	public function is_exists_name($name, $id = NULL)
	{
		if (! empty($id))
		{
			$this->db->where('id !=', $id);
		}

		return $this->db->where('name', $name)->count_all_results($this->tb) > 0;
	}

	
	public function has_transection($id)
	{
		$tables = array(
			'orders',
			'sale_order'
		);

		foreach($tables as $table)
		{
			if($this->db->where('sender_id', $id)->count_all_results($table) > 0)
			{
				return TRUE;
			}
		}

		return FALSE;
	}
	
}
 ?>
