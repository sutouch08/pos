<?php
class Slp_model extends CI_Model
{
  private $tb = "saleman";

  public function __construct()
  {
    parent::__construct();
  }


  public function get($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }

  
  public function get_all($active = TRUE)
  {
    if($active)
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


  public function is_exists($id)
  {
    $count = $this->db->where('id', $id)->count_all_results($this->tb);
    return $count > 0 ? TRUE : FALSE;    
  }


  public function add($ds = array())
  {
    if(!empty($ds))
    {
      return $this->db->insert($this->tb, $ds);
    }

    return FALSE;
  }


  public function update($id, $ds = array())
  {
    if(!empty($ds))
    {
      return $this->db->where('id', $id)->update($this->tb, $ds);
    }

    return FALSE;
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


  public function count_rows($ds = array())
  {
    $this->db->where('id IS NOT NULL', NULL, FALSE);

    if($ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }


    if(!empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list($ds = array(), $limit = NULL, $offset = 0)
  {
    if($ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    if(!empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }


    if(!empty($limit))
    {
      $this->db->limit($limit, $offset);
    }

    $rs = $this->db->get($this->tb);
    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return FALSE;
  }


  public function get_data($active = NULL)
  {
    if( ! empty($active))
    {
      $this->db->where('active', 1);
    }

    $rs = $this->db->where('id > ', 0)->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_in(array $ds = array())
  {
    if( ! empty($ds))
    {
      $rs = $this->db->where_in('id', $ds)->get($this->tb);

      if($rs->num_rows() > 0)
      {
        return $rs->result();
      }
    }


    return NULL;
  }

} //--- End class

 ?>
