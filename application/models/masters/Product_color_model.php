<?php
class Product_color_model extends CI_Model
{
  private $tb = "product_color";
  private $tg = "product_color_group";

  public function __construct()
  {
    parent::__construct();
  }


  public function add(array $ds = array())
  {
    if(! empty($ds))
    {
      if($this->db->insert($this->tb, $ds))
      {
        return $this->db->insert_id();
      }
    }

    return FALSE;
  }


  public function add_group(array $ds = array())
  {
    if( ! empty($ds))
    {
      if($this->db->insert($this->tg, $ds))
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
      $this->db->where('id', $id);
      return $this->db->update($this->tb, $ds);
    }

    return FALSE;
  }


  public function update_by_code($code, array $ds = array())
  {
    if(!empty($ds))
    {
      $this->db->where('code', $code);
      return $this->db->update($this->tb, $ds);
    }

    return FALSE;
  }


  public function update_by_id($id, array $ds = array())
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


  public function delete_by_id($id)
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


  public function get_group($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tg);
    if($rs->num_rows() === 1)
    {
      return $rs->row();
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


  public function get_name_by_code($code)
  {
    $rs = $this->db->select('name')->where('code', $code)->get($this->tb);

    if($rs->num_rows() === 1)
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


  public function get_all($active = NULL)
  {
    $this->db
    ->select('co.*, cg.name AS group_name')
    ->from('product_color AS co')
    ->join('product_color_group AS cg', 'co.group_id = cg.id', 'left');

    if($active)
    {
      $this->db->where('co.active', 1);
    }

    $rs = $this->db
    ->order_by('cg.name', 'ASC')
    ->order_by('co.code', 'ASC')
    ->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_all_group()
  {
    $rs = $this->db->order_by('name', 'ASC')->get($this->tg);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function count_rows(array $ds = array())
  {
    if( ! empty($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    if( ! empty($ds['code']))
    {
      $this->db->like('code', $ds['code']);
    }

    if( ! empty($ds['name']))
    {
      $this->db->like('name', $ds['name']);
    }

    if( ! empty($ds['group']) && $ds['group'] != 'all')
    {
      if($ds['group'] === 'NULL')
      {
        $this->db->where('group_id IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('group_id', $ds['group']);
      }
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    $order_by = isset($ds['order_by']) ? $ds['order_by'] : 'code';
    $sort_by = isset($ds['sort_by']) ? $ds['sort_by'] : 'ASC';

    $this->db
    ->select('co.*, cg.name AS group_name')
    ->from('product_color AS co')
    ->join('product_color_group AS cg', 'co.group_id = cg.id', 'left');

    if(isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('co.active', $ds['active']);
    }

    if(! empty($ds['code']))
    {
      $this->db->like('co.code', $ds['code']);
    }

    if(!empty($ds['name']))
    {
      $this->db->like('co.name', $ds['name']);
    }

    if( ! empty($ds['group']) && $ds['group'] != 'all')
    {
      if($ds['group'] === 'NULL')
      {
        $this->db->where('co.group_id IS NULL', NULL, FALSE);
      }
      else
      {
        $this->db->where('co.group_id', $ds['group']);
      }
    }

    $rs = $this->db
    ->order_by($order_by, $sort_by)
    ->limit($perpage, $offset)
    ->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }
  

  public function is_exists_code($code, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('code', $code)->count_all_results($this->tb);

    return $count > 0 ? TRUE : FALSE;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('name', $name)->count_all_results($this->tb);

    return $count > 0 ? TRUE : FALSE;
  }  


  public function is_exists_group_name($name, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('name', $name)->count_all_results($this->tg);

    return $count > 0 ? TRUE : FALSE;
  }


  public function count_members($id)
  {
    return $this->db->where('color_id', $id)->count_all_results('products');
  }
} //-- end class 
?>
