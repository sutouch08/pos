<?php
class Sales_team_model extends CI_Model
{
  private $tb = "sale_team";

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
