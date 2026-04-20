<?php
class Slp_model extends CI_Model
{
  private $tb = "saleman";

  public function __construct()
  {
    parent::__construct();
  }


  public function add(array $ds = array())
  {
    if (!empty($ds))
    {
      if ($this->db->insert($this->tb, $ds))
      {
        return $this->db->insert_id();
      }
    }

    return FALSE;
  }


  public function update($id, array $ds = array())
  {
    if (!empty($ds))
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
    $rs = $this->db->where('id', $id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_by_emp_id($emp_id)
  {
    $rs = $this->db->where('emp_id', $emp_id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }

  
  public function get_name($id)
  {
    $rs = $this->db->select('name')->where('id', $id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }

  
  public function is_exists_employee($emp_id, $id = NULL)
  {
    if ($id !== NULL)
    {
      $this->db->where('id !=', $id);
    }

    return $this->db->where('emp_id', $emp_id)->count_all_results($this->tb) > 0 ? TRUE : FALSE;
  }
  

  public function count_rows(array $ds = array())
  {
    if (isset($ds['emp_id']) && $ds['emp_id'] != 'all')
    {
      $this->db->where('emp_id', $ds['emp_id']);
    }

    if (! empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }

    if (isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {    
    if(isset($ds['emp_id']) && $ds['emp_id'] != 'all')
    {
      $this->db->where('emp_id', $ds['emp_id']);
    }

    if(! empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }
    
    if (isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    $rs = $this->db->order_by('name', 'ASC')->limit($perpage, $offset)->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }



  public function get_all($active = TRUE)
  {
    if ($active === TRUE)
    {
      $this->db->where('active', 1);
    }

    $rs = $this->db->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function has_transection($id)
  {
    $exists = FALSE;

    if( ! $exists && $this->db->where('sale_id', $id)->count_all_results('sale_order') > 0)
    {
      $exists = TRUE;
    }

     if( ! $exists && $this->db->where('sale_id', $id)->count_all_results('order_pos') > 0)
    {
      $exists = TRUE;
    }

     if( ! $exists && $this->db->where('sale_id', $id)->count_all_results('orders') > 0)
    {
      $exists = TRUE;
    }

    return $exists;
  }
}
