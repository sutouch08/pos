<?php
class Department_model extends CI_Model
{
  private $tb = "department";

  public function __construct()
  {
    parent::__construct();
  }


  public function add(array $ds = array())
  {
    if( ! empty($ds))
    {
      return $this->db->insert($this->tb, $ds);
    }

    return FALSE;
  }


  public function update($id, array $ds = array())
  {
    if( ! empty($ds))
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

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_all()
  {
    $rs = $this->db->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_all_active()
  {
    $rs = $this->db->where('status', 1)->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_list(array $ds = array(), $limit = 20, $offset = 0)
  {
    if( isset($ds['name']) && $ds['name'] != "" && $ds['name'] != NULL)
    {
      $this->db->like('name', $ds['name']);
    }

    if( isset($ds['status']) && $ds['status'] != 'all')
    {
      $this->db->where('status', $ds['status']);
    }

    $rs = $this->db->order_by('name', 'ASC')->limit($limit, $offset)->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function count_rows(array $ds = array())
  {
    if( isset($ds['name']) && $ds['name'] != "" && $ds['name'] != NULL)
    {
      $this->db->like('name', $ds['name']);
    }

    if( isset($ds['status']) && $ds['status'] != 'all')
    {
      $this->db->where('status', $ds['status']);
    }

    return $this->db->count_all_results($this->tb);
  }



  public function is_exists_name($name, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $rs = $this->db->where('name', $name)->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return TRUE;
    }

    return FALSE;
  }


} //--- end class

?>
