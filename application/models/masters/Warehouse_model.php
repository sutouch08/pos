<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{
  private $tb = 'warehouse';

  public function __construct()
  {
    parent::__construct();
  }
  
  public function count_rows($filter = array())
  {
    if( ! $this->pm->can_approve)
    {      
      $this->db->where('delete_at IS NULL', NULL, FALSE);
    }
    
    if(!empty($filter['code']))
    {
      $this->db->like('code', $filter['code']);
    }

    if(!empty($filter['name']))
    {
      $this->db->like('name', $filter['name']);
    }

    if($filter['role'] != 'all')
    {
      $this->db->where('role', $filter['role']);
    }

    if($filter['active'] != 'all')
    {
      $this->db->where('active', $filter['active']);
    }

    if($filter['auz'] != 'all')
    {
      $this->db->where('auz', $filter['auz']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list($filter = array(), $limit = 20, $offset = 0)
  {
    $order_by = isset($filter['order_by']) ? $filter['order_by'] : 'code';
    $sort_by = isset($filter['sort_by']) ? $filter['sort_by'] : 'ASC';

    if (! $this->pm->can_approve)
    {
      $this->db->where('delete_at IS NULL', NULL, FALSE);
    }

    if(!empty($filter['code']))
    {
      $this->db->like('code', $filter['code']);
    }

    if(!empty($filter['name']))
    {
      $this->db->like('name', $filter['name']);
    }

    if($filter['role'] != 'all')
    {
      $this->db->where('role', $filter['role']);
    }

    if($filter['active'] != 'all')
    {
      $this->db->where('active', $filter['active']);
    }

    if($filter['auz'] != 'all')
    {
      $this->db->where('auz', $filter['auz']);
    }

    $rs = $this->db
    ->order_by($order_by, $sort_by)
    ->limit($limit, $offset)
    ->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }  

    return NULL;
  }


  public function get($id)
  {
    $rs = $this->db
    ->where('id', $id)
    ->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_by_code($code)
  {
    $rs = $this->db
    ->where('code', $code)
    ->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_code($id)
  {
    $rs = $this->db
    ->select('code')
    ->where('id', $id)
    ->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row()->code;
    }

    return NULL;
  }


  public function get_name($id)
  {
    $rs = $this->db
    ->select('name')
    ->where('id', $id)
    ->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function get_all($active = TRUE)
  {
    if($active)
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

    $rs = $this->db
    ->where('code', $code)
    ->get($this->tb);

    return $rs->num_rows() > 0;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if(!empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $rs = $this->db
    ->where('name', $name)
    ->get($this->tb);

    return $rs->num_rows() > 0;
  }


  public function add(array $data = array())
  {
    if( !empty($data) )
    {
      if($this->db->insert($this->tb, $data))
      {
        return $this->db->insert_id();
      }
    }

    return FALSE;
  }


  public function update($id, array $data = array())
  {
    if( !empty($data) )
    {
      $this->db->where('id', $id);
      return $this->db->update($this->tb, $data);
    }

    return FALSE;
  }


  public function delete($id, $soft = TRUE)
  {
    if( ! $soft)
    {
      $this->db->where('id', $id);
      return $this->db->delete($this->tb);
    }
    else
    {
      $data = array(
        'active' => -1,
        'delete_by' => $this->_user->id,
        'delete_at' => now()
      );

      return $this->update($id, $data);
    }
  }


  public function count_zone($id)
  {
   return $this->db->where('warehouse_id', $id)->count_all_results('zone');
  }


  public function get_all_role()
  {
    $rs = $this->db
    ->order_by('id', 'ASC')
    ->get('warehouse_role');

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }
  

  public function role_name($id)
  {
    $rs = $this->db
    ->select('name')
    ->where('id', $id)
    ->get('warehouse_role');

    if($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }
}
