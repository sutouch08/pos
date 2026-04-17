<?php
class Channels_model extends CI_Model
{
  private $tb = "channels";

  public function __construct()
  {
    parent::__construct();
  }


  public function get($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tb);

    if($rs->num_rows() == 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_by_code($code)
  {
    $rs = $this->db->where('code', $code)->get($this->tb);

    if($rs->num_rows() == 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_by_id($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tb);

    if($rs->num_rows() == 1)
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

    $rs = $this->db->order_by('code', 'ASC')->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function add(array $ds = array())
  {
    if( ! empty($ds))
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


  public function update_by_code($code, array $ds = array())
  {
    if(!empty($ds))
    {
      return $this->db->where('code', $code)->update($this->tb, $ds);
    }

    return FALSE;
  }


  public function update_by_id($id, array $ds = array())
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


  public function delete_by_code($code)
  {
    return $this->db->where('code', $code)->delete($this->tb);
  }


  public function delete_by_id($id)
  {
    return $this->db->where('id', $id)->delete($this->tb);
  }


  public function count_rows(array $ds = array())
  {
    if( ! empty($ds['code']))
    {
      $this->db->like('code', $ds['code']);
    }

    if( ! empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }

    if(isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    return $this->db->count_all_results($this->tb);
  }

  
  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    if( ! empty($ds['code']))
    {
      $this->db->like('code', $ds['code']);
    }

    if( ! empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }

    if(isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    $rs = $this->db->order_by('code', 'ASC')->limit($perpage, $offset)->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function is_exists_code($code, $id = NULL)
  {
    if($id != NULL)
    {
      $this->db->where('id !=', $id);
    }

    return $this->db->where('code', $code)->count_all_results($this->tb) > 0 ? TRUE : FALSE;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if($id != NULL)
    {
      $this->db->where('id !=', $id);
    }

    return $this->db->where('name', $name)->count_all_results($this->tb) > 0 ? TRUE : FALSE;
  }


	public function get_channels_array()
	{
		$rs = $this->db->order_by('code', 'ASC')->get($this->tb);

		if($rs->num_rows() > 0)
		{
			$arr = [];

			foreach($rs->result() as $ds)
			{
				$arr[$ds->code] = $ds->name;
			}

			return $arr;
		}

		return NULL;
	}


  public function get_name($id)
  {
    $rs = $this->db->select('name')->where('id', $id)->get($this->tb);

    if($rs->num_rows() == 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function get_name_by_code($code)
  {
    $rs = $this->db->select('name')->where('code', $code)->get($this->tb);

    if($rs->num_rows() == 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }

  public function has_transaction($code)
  {
    // Implement the logic to check if the channel has related transactions
    // Return TRUE if there are related transactions, otherwise FALSE
    $exists = FALSE;

    if( ! $exists && $this->db->where('channels_code', $code)->count_all_results('orders') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('channels_code', $code)->count_all_results('order_pos') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('channels_code', $code)->count_all_results('sale_order') > 0)
    {
      $exists = TRUE;
    }    

    return $exists;
  }
}
?>
