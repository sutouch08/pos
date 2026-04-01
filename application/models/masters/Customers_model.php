<?php
class Customers_model extends CI_Model
{
  private $tb = "customers";

  public function __construct()
  {
    parent::__construct();
  }

  
  public function add(array $ds = array())
  {
    if (!empty($ds))
    {
      return  $this->db->insert($this->tb, $ds);
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


  public function get($code)
  {
    $rs = $this->db->where('code', $code)->get($this->tb);

    if ($rs->num_rows() === 1)
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

  public function get_name($code)
  {
    $rs = $this->db->select('name')->where('code', $code)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function get_name_by_id($id)
  {
    $rs = $this->db->select('name')->where('id', $id)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row()->name;
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
        ->grup_end();
    }

    if ($ds['group'] != 'all')
    {
      if ($ds['group'] === "NULL")
      {
        $this->db->where('group_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('group_code', $ds['group']);
      }
    }

    if ($ds['kind'] != "all")
    {
      if ($ds['kind'] === "NULL")
      {
        $this->db->where('kind_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('kind_code', $ds['kind']);
      }
    }

    if ($ds['type'] != "all")
    {
      if ($ds['type'] === "NULL")
      {
        $this->db->where('type_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('type_code', $ds['type']);
      }
    }

    if ($ds['grade'] != "all")
    {
      if ($ds['grade'] === 'NULL')
      {
        $this->db->where('class_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('class_code', $ds['grade']);
      }
    }

    if ($ds['area'] != 'all')
    {
      if ($ds['area'] === "NULL")
      {
        $this->db->where('area_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('area_code', $ds['area']);
      }
    }

    if ($ds['status'] != 'all')
    {
      $this->db->where('active', $ds['status']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    $this->db
    ->select('id, code, name, tax_id, group_code AS group, class_code AS grade')
    ->select('kind_code AS kind, type_code AS type, area_code AS area, sale_id')
    ->select('active, user, date_add, update_user, date_upd');    

    if (! empty($ds['code']))
    {
      $this->db
        ->group_start()
        ->like('code', $ds['code'])
        ->or_like('name', $ds['code'])
        ->grup_end();
    }

    if ($ds['group'] != 'all')
    {
      if ($ds['group'] === "NULL")
      {
        $this->db->where('group_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('group_code', $ds['group']);
      }
    }

    if ($ds['kind'] != "all")
    {
      if ($ds['kind'] === "NULL")
      {
        $this->db->where('kind_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('kind_code', $ds['kind']);
      }
    }

    if ($ds['type'] != "all")
    {
      if ($ds['type'] === "NULL")
      {
        $this->db->where('type_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('type_code', $ds['type']);
      }
    }

    if ($ds['grade'] != "all")
    {
      if ($ds['grade'] === 'NULL')
      {
        $this->db->where('class_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('class_code', $ds['grade']);
      }
    }

    if ($ds['area'] != 'all')
    {
      if ($ds['area'] === "NULL")
      {
        $this->db->where('area_code IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('area_code', $ds['area']);
      }
    }

    if ($ds['status'] != 'all')
    {
      $this->db->where('active', $ds['status']);
    }

    $rs = $this->db->order_by('code', 'ASC')->limit($perpage, $offset)->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function is_exists_code($code)
  {    
    $count = $this->db->where('code', $code)->count_all_results($this->tb);
    return $count > 0 ? TRUE : FALSE;    
  }


  public function is_exists_name($name, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('name !=', $name);
    }
    
    $count = $this->db->where('name', $name)->count_all_results($this->tb);    
    return $count > 0 ? TRUE : FALSE;
  }


  public function get_sale_id($code)
  {
    $rs = $this->db->select('sale_id')->where('code', $code)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->sale_code;
    }

    return NULL;
  }


  public function get_prefix_list()
  {
    $rs = $this->db->get('customer_code_prefix');

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_prefix($code)
  {
    $rs = $this->db->where('code', $code)->get('customer_code_prefix');

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_max_code($prefix)
  {
    $rs = $this->db
    ->select_max('code')
    ->like('code', $prefix, 'after')
    ->order_by('code', 'DESC')    
    ->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row()->code;
    }

    return NULL;
  }

  
  public function get_last_sync_date()
  {
    $rs = $this->db->select_max('last_sync')->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->last_sync === NULL ? date('2019-01-01 00:00:00') : from_date($rs->row()->last_sync);
    }

    return date('2019-01-01 00:00:00');
  }
}
