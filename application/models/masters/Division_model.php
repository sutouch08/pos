<?php
class Division_model extends CI_Model
{
  private $tb = "division";

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
    $rs = $this->db
    ->select('di.*, de.name AS department_name')
    ->from('division AS di')
    ->join('department AS de', 'di.department_id = de.id', 'left')
    ->where('di.id', $id)
    ->get();

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_all()
  {
    $rs = $this->db
    ->select('di.*, de.name AS department_name')
    ->from('division AS di')
    ->join('department AS de', 'di.department_id = de.id', 'left')
    ->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_all_active()
  {
    $rs = $this->db
    ->select('di.*, de.name AS department_name')
    ->from('division AS di')
    ->join('department AS de', 'di.department_id = de.id', 'left')
    ->where('di.status', 1)
    ->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_list(array $ds = array(), $limit = 20, $offset = 0)
  {
    $this->db
    ->select('di.*, de.name AS department_name')
    ->from('division AS di')
    ->join('department AS de', 'di.department_id = de.id', 'left');

    if( isset($ds['name']) && $ds['name'] != "" && $ds['name'] != NULL)
    {
      $this->db->like('di.name', $ds['name']);
    }

    if( isset($ds['department']) && $ds['department'] != "all")
    {
      $this->db->where('di.department_id', $ds['department']);
    }

    if( isset($ds['status']) && $ds['status'] != 'all')
    {
      $this->db->where('di.status', $ds['status']);
    }

    $rs = $this->db->order_by('di.name', 'ASC')->limit($limit, $offset)->get();

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

    if( isset($ds['department']) && $ds['department'] != "all")
    {
      $this->db->where('department_id', $ds['department']);
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
