<?php
class Zone_model extends CI_Model
{
  private $tb = "zone";

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


  public function get_by_code($code)
  {
    $rs = $this->db->where('code', $code)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_code($id)
  {
    $rs = $this->db->select('code')->where('id', $id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->code;
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


  public function get_name_by_code($code)
  {
    $rs = $this->db->select('name')->where('code', $code)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function get_system_zone($warehouse_id)
  {
    $rs = $this->db
      ->where('warehouse_id', $warehouse_id)
      ->where('system', 1)
      ->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_warehouse_zone($warehouse_id)
  {
    $rs = $this->db
      ->where('warehouse_id', $warehouse_id)
      ->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }

  public function is_exists_code($code, $id = NULL)
  {
    if (!empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $rs = $this->db->where('code', $code)->get($this->tb);

    return $rs->num_rows() > 0;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if (!empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $rs = $this->db->where('name', $name)->get($this->tb);

    return $rs->num_rows() > 0;
  }


  public function count_rows(array $filter = array())
  {
    if (! $this->pm->can_approve)
    {
      $this->db->where('active !=', -1);
    }

    if (!empty($filter['code']))
    {
      $this->db->like('code', $filter['code']);
    }

    if (!empty($filter['name']))
    {
      $this->db->like('name', $filter['name']);
    }

    if(isset($filter['warehouse_id']) && $filter['warehouse_id'] != 'all')
    {
      $this->db->where('warehouse_id', $filter['warehouse_id']);
    }

    if(isset($filter['active']) && $filter['active'] != 'all')
    {
      $this->db->where('active', $filter['active']);
    }

    if(isset($filter['fastmove']) && $filter['fastmove'] != 'all')
    {
      $this->db->where('fastmove', $filter['fastmove']);
    }

    if(isset($filter['system']) && $filter['system'] != 'all')
    {
      $this->db->where('system', $filter['system']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $filter = array(), $limit = 20, $offset = 0)
  {
    $order_by = isset($filter['order_by']) ? $filter['order_by'] : 'code';
    $sort_by = isset($filter['sort_by']) ? $filter['sort_by'] : 'ASC';
    if(! $this->pm->can_approve)
    {
      $this->db->where('active !=', -1);
    }

    if (!empty($filter['code']))
    {
      $this->db->like('code', $filter['code']);
    }

    if (!empty($filter['name']))
    {
      $this->db->like('name', $filter['name']);
    }

    if(isset($filter['warehouse_id']) && $filter['warehouse_id'] != 'all')
    {
      $this->db->where('warehouse_id', $filter['warehouse_id']);
    }
   
    if (isset($filter['active']) && $filter['active'] != 'all')
    {
      $this->db->where('active', $filter['active']);
    }    

    if (isset($filter['pickface']) && $filter['pickface'] != 'all')
    {
      $this->db->where('pickface', $filter['pickface']);
    }

    if (isset($filter['fastmove']) && $filter['fastmove'] != 'all')
    {
      $this->db->where('fastmove', $filter['fastmove']);
    }

    if (isset($filter['system']) && $filter['system'] != 'all')
    {
      $this->db->where('system', $filter['system']);
    }

    $rs = $this->db
      ->order_by($order_by, $sort_by)
      ->limit($limit, $offset)
      ->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function has_transaction($id)
  {
    return $this->db->where('zone_id', $id)->count_all_results('stock_movement') > 0;
  }


  public function has_stock($id)
  {
    return $this->db->where('zone_id', $id)->where('qty >', 0)->count_all_results('stock') > 0;
  }
} //--- end class
