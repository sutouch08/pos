<?php
class User_group_model extends CI_Model
{
  private $tb = "user_group";

  public function __construct()
  {
    parent::__construct();
  }


  public function get_all()
  {
    $rs = $this->db->where('id >', 0)->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }

  
} //--- end class


?>
