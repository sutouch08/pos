<?php
class Employee_model extends CI_Model
{
  private $tb = "employee";

  public function __construct()
  {
    parent::__construct();
  }


  public function add(array $ds = array())
  {
    if(!empty($ds))
    {
      if($this->db->insert($this->tb, $ds))
      {
        return $this->db->insert_id();
      }
    }

    return FALSE;
  }


  public function update($id, array $ds = array())
  {
    if(!empty($ds) && $id > 0)
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


  public function get_name($id)
  {
    $rs = $this->db->select('firstName, lastName')->where('id', $id)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row()->firstName.' '.$rs->row()->lastName;
    }

    return NULL;
  }


  public function get_all($active = TRUE)
  {
    if($active === TRUE)
    {
      $this->db->where('active', 1);
    }

    $rs = $this->db->order_by('firstName', 'ASC')->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }  


  public function count_rows(array $ds = array())
  {
    if(!empty($ds['code']))
    {
      $this->db->like('code', $ds['code']);
    }

    if(!empty($ds['name']))
    {
      $this->db->like('CONCAT(firstName, " ", lastName)', $ds['name']);
    }

    if(isset($ds['position']) && $ds['position'] != 'all')
    {
      $this->db->where('position_id', $ds['position']);
    }

    if(isset($ds['department']) && $ds['department'] != 'all')
    {
      $this->db->where('department_id', $ds['department']);
    }

    if(isset($ds['status']) && $ds['status'] != 'all')
    {
      $this->db->where('status', $ds['status']);
    }

    if(isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    return $this->db->count_all_results($this->tb);
  }
  

  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    $order_by = empty($ds['order_by']) ? 'code' : $ds['order_by'];
    $sort_by = empty($ds['sort_by']) ? 'ASC' : $ds['sort_by'];

    $this->db->select('e.*, p.name AS position_name, d.name AS department_name');
    $this->db->from($this->tb.' AS e');
    $this->db->join('positions AS p', 'e.position_id = p.id', 'left');
    $this->db->join('departments AS d', 'e.department_id = d.id', 'left');

    if(!empty($ds['code']))
    {
      $this->db->like('e.code', $ds['code']);
    }

    if(!empty($ds['name']))
    {
      $this->db->like('CONCAT(e.firstName, " ", e.lastName)', $ds['name']);      
    }

    if(isset($ds['position']) && $ds['position'] != 'all')
    {
      $this->db->where('e.position_id', $ds['position']);
    }

    if(isset($ds['department']) && $ds['department'] != 'all')
    {
      $this->db->where('e.department_id', $ds['department']);
    }

    if(isset($ds['status']) && $ds['status'] != 'all')
    {
      $this->db->where('e.status', $ds['status']);
    }

    if(isset($ds['active']) && $ds['active'] != 'all')
    {
      $this->db->where('e.active', $ds['active']);
    }

    $rs = $this->db
    ->order_by('e.'.$order_by, $sort_by)
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
    if($id !== NULL)
    {
      $this->db->where('id !=', $id);
    }
    
    return $this->db->where('code', $code)->count_all_results($this->tb) > 0;
  }


  public function is_exists_name($fname, $lname, $id = NULL)
  {
    if($id !== NULL)
    {
      $this->db->where('id !=', $id);
    }
    
    return $this->db->where('firstName', $fname)->where('lastName', $lname)->count_all_results($this->tb) > 0;
  }


  public function get_max_code($prefix)
  {
    $rs = $this->db
      ->select_max('code')
      ->like('code', $prefix, 'after')
      ->order_by('code', 'DESC')
      ->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row()->code;
    }

    return NULL;
  }


  public function has_transection($id)
  {
    $exists = FALSE;

    if( ! $exists && $this->db->where('emp_id', $id)->count_all_results('user') > 0)
    {
      $exists = TRUE;
    }

     if( ! $exists && $this->db->where('emp_id', $id)->count_all_results('saleman') > 0)
    {
      $exists = TRUE;
    }

     if( ! $exists && $this->db->where('emp_id', $id)->count_all_results('orders') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('emp_id', $id)->count_all_results('return_lend') > 0)
    {
      $exists = TRUE;
    }

    return $exists;
  }

}//--- end class
 ?>
