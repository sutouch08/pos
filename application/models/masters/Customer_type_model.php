<?php
class Customer_type_model extends CI_Model
{
  private $tb = "customer_type";

  public function __construct()
  {
    parent::__construct();
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


  public function get_by_id($id)
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


  public function update_by_id($id, array $ds = array())
  {
    if (! empty($ds))
    {
      return $this->db->where('id', $id)->update($this->tb, $ds);
    }

    return FALSE;
  }


  public function update_by_code($code, array $ds = array())
  {
    if (! empty($ds))
    {
      return $this->db->where('code', $code)->update($this->tb, $ds);
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


  public function delete_by_code($code)
  {
    return $this->db->where('code', $code)->delete($this->tb);
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

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    if (! empty($ds['code']))
    {
      $this->db
        ->group_start()
        ->like('code', $ds['code'])
        ->or_like('name', $ds['code'])
        ->group_end();
    }

    $rs = $this->db->order_by('id', 'DESC')->limit($perpage, $offset)->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_all()
  {
    $rs = $this->db->get($this->tb);

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


  public function get_name_by_id($id)
  {
    $rs = $this->db->select('name')->where('id', $id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function is_exists_code($code, $id = NULL)
  {
    if (! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    return $this->db->where('code', $code)->count_all_results($this->tb) > 0 ? TRUE : FALSE;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if (! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    return $this->db->where('name', $name)->count_all_results($this->tb) > 0 ? TRUE : FALSE;
  }


  public function count_members($id)
  {
    return $this->db->where('type_id', $id)->count_all_results('customers');
  }
}
?>
