<?php
class Employee_model extends CI_Model
{
  private $tb = "employee";

  public function __construct()
  {
    parent::__construct();
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

    if($rs->num_rows() > 0)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_list(array $ds = array(), $limit = 20, $offset = 0)
  {

  }


  public function count_rows(array $ds = array())
  {

  }


} //-- end class

?>
