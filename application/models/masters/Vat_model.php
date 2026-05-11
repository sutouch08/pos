<?php
class Vat_model extends CI_Model
{
	private $tb = "vat";

  public function __construct()
  {
    parent::__construct();
  }

	public function get_rate($code)
	{
		$rs = $this->db->select('rate')->where('code', $code)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row()->rate;
		}

		return 0.00;
	}

	
	public function get($code)
  {
    $rs = $this->db->where('code', $code)->get($this->tb);
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


	public function get_by_id($id)
	{
		$rs = $this->db->where('id', $id)->get($this->tb);
		if($rs->num_rows() === 1)
		{
			return $rs->row();
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


	public function update($code, $ds = array())
	{
		return $this->db->where('code', $code)->update($this->tb, $ds);
	}


	public function update_by_code($code, $ds = array())
	{
		return $this->db->where('code', $code)->update($this->tb, $ds);
	}


	public function update_by_id($id, $ds = array())
	{
		return $this->db->where('id', $id)->update($this->tb, $ds);
	}


	public function delete($id)
	{
		return $this->db->where('id', $id)->delete($this->tb);
	}


	public function has_transection($code)
	{
		$exists = FALSE;

		if( ! $exists)
		{
			if($this->db
					->where('sale_vat_code', $code)
					->or_where('purchase_vat_code', $code)
					->count_all_results('products') > 0)
			{
				$exists = TRUE;
			}			
		}

		if( ! $exists && $this->db->where('vat_code', $code)->limit(1)->count_all_results('order_details') > 0)
		{
			$exists = TRUE;
		}

		if( ! $exists && $this->db->where('vat_code', $code)->limit(1)->count_all_results('sale_order_details') > 0)
		{
			$exists = TRUE;
		}

		if( ! $exists && $this->db->where('vat_code', $code)->limit(1)->count_all_results('order_pos_details') > 0)
		{
			$exists = TRUE;
		}

		if( ! $exists && $this->db->where('vat_code', $code)->limit(1)->count_all_results('po_details') > 0)
		{
			$exists = TRUE;
		}

		return $exists;
	}


	public function count_rows(array $ds = array())
	{
		if (isset($ds['code']) && $ds['code'] != '')
		{
			$this->db
				->group_start()
				->like('code', $ds['code'])
				->or_like('name', $ds['code'])
				->group_end();
		}

		if (isset($ds['type']) && $ds['type'] != 'all')
		{
			$this->db->where('type', $ds['type']);
		}

		if (isset($ds['active']) && $ds['active'] != 'all')
		{
			$this->db->where('active', $ds['active']);
		}

		return $this->db->count_all_results($this->tb);
	}


	public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
	{
		if(isset($ds['code']) && $ds['code'] != '')
		{
			$this->db
			->group_start()
			->like('code', $ds['code'])
			->or_like('name', $ds['code'])
			->group_end();
		}

		if(isset($ds['type']) && $ds['type'] != 'all')
		{
			$this->db->where('type', $ds['type']);
		}

		if(isset($ds['active']) && $ds['active'] != 'all')
		{
			$this->db->where('active', $ds['active']);
		}

		$rs = $this->db
		->order_by('code', 'ASC')
		->limit($perpage, $offset)
		->get($this->tb);		

		if($rs->num_rows() > 0)
		{
			return $rs->result();
		}

		return NULL;
	}


	public function get_all($type = NULL, $active = TRUE)
	{
		if($type != NULL)
		{
			$this->db->where('type', $type); //--- S or P
		}

		if($active === TRUE)
		{
			$this->db->where('active', 1);
		}

		$rs = $this->db
		->order_by('code', 'ASC')
		->get($this->tb);

		if($rs->num_rows() > 0)
		{
			return $rs->result();
		}

		return NULL;
	}


	public function is_exists_code($code, $id = NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id !=', $id);
		}

		return $this->db->where('code', $code)->count_all_results($this->tb) > 0;
	}


	public function is_exists_name($name, $id = NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id !=', $id);
		}

		return $this->db->where('name', $name)->count_all_results($this->tb) > 0;
	}

}

