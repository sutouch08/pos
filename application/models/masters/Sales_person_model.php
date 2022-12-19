<?php
class Sales_person_model extends CI_Model
{
  public $tb = "sale_person";

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


  
} //--- end class

 ?>
