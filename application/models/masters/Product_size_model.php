<?php
class Product_size_model extends CI_Model
{
  private $tb = "product_size";
  private $tg = "product_size_group";

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


  public function add_group(array $ds = array())
  {
    if (!empty($ds))
    {
      if ($this->db->insert($this->tg, $ds))
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
      $this->db->where('id', $id);
      return $this->db->update($this->tb, $ds);
    }

    return FALSE;
  }


  public function update_by_id($id, array $ds = array())
  {
    if (! empty($ds))
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


  public function get_by_id($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_group($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tg);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_all($active = TRUE)
  {
    $this->db
      ->select('o.*, g.name AS group_name')
      ->from($this->tb . ' AS o')
      ->join($this->tg . ' AS g', 'o.group_id = g.id', 'left');

    if ($active === TRUE)
    {
      $this->db->where('o.active', 1);
    }

    $rs = $this->db
      ->order_by('g.name', 'ASC')
      ->order_by('o.position', 'ASC')
      ->get();

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_all_group()
  {
    $rs = $this->db->order_by('name', 'ASC')->get($this->tg);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
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
    if ($code === NULL or $code === '')
    {
      return $code;
    }

    $rs = $this->db->select('name')->where('code', $code)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function group_name($id)
  {
    $rs = $this->db->select('name')->where('id', $id)->get($this->tg);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function get_group_name($id)
  {
    $rs = $this->db
      ->select('g.name')
      ->from($this->tb . ' AS o')
      ->join($this->tg . ' AS g', 'o.group_id = g.id', 'left')
      ->where('o.id', $id)
      ->get();

    if ($rs->num_rows() === 1)
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
        ->group_end();
    }

    if (isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    $order_by = empty($ds['order_by']) ? 'position' : $ds['order_by'];
    $sort_by = empty($ds['sort_by']) ? 'ASC' : $ds['sort_by'];

    $this->db
      ->select('o.*, g.name AS group_name')
      ->from($this->tb . ' AS o')
      ->join($this->tg . ' AS g', 'o.group_id = g.id', 'left');

    if (! empty($ds['code']))
    {
      $this->db
        ->group_start()
        ->like('o.code', $ds['code'])
        ->or_like('o.name', $ds['code'])
        ->group_end();
    }

    if (isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('o.active', $ds['active']);
    }

    if (isset($ds['group_id']) && $ds['group_id'] != 'all')
    {
      $this->db->where('o.group_id', $ds['group_id']);
    }

    $rs = $this->db
      ->order_by($order_by, $sort_by)
      ->limit($perpage, $offset)
      ->get();

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function is_exists_code($code, $id = NULL)
  {
    if (! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('code', $code)->count_all_results($this->tb);

    return $count > 0 ? TRUE : FALSE;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if (! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('name', $name)->count_all_results($this->tb);

    return $count > 0 ? TRUE : FALSE;
  }


  public function is_exists_group_name($name)
  {
    $count = $this->db->where('name', $name)->count_all_results($this->tg);

    return $count > 0 ? TRUE : FALSE;
  }


  public function count_members($id)
  {
    return $this->db->where('size_id', $id)->count_all_results('products');
  }


  public function update_member($id)
  {
    $count = $this->count_members($id);
    return $this->db->where('id', $id)->update($this->tb, array('member' => $count));
  }
}
