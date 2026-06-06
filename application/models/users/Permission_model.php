<?php
class Permission_model extends CI_Model
{
  private $tb = "permission";

  public function __construct()
  {
    parent::__construct();
  }


  public function add(array $ds = array())
  {
    if(!empty($ds))
    {
      $this->db->insert($this->tb, $ds);
    }
  }


  public function add_batch(array $ds = array())
  {
    if( ! empty($ds))
    {
      return $this->db->insert_batch($this->tb, $ds);
    }

    return FALSE;
  }


  public function get_permission($menu, $id_profile)
  {
    if($id_profile == -1)
    {
      return (object)array(
        'can_view' => 1,
        'can_add' => 1,
        'can_edit' => 1,
        'can_delete' => 1,
        'can_approve' => 1
      );      
    }
        
    $rs = $this->db
    ->where('menu', $menu)
    ->where('id_profile', $id_profile)
    ->get($this->tb);
    
    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return (object)array(
      'can_view' => 0,
      'can_add' => 0,
      'can_edit' => 0,
      'can_delete' => 0,
      'can_approve' => 0
    );    
  }



  public function drop_permission($id)
  {
    return $this->db->where('id_profile', $id)->delete($this->tb);    
  }


  public function can_add($menu, $id_profile)
  {
    $count = $this->db
    ->where('menu', $menu)
    ->where('id_profile', $id_profile)
    ->where('can_add', 1)
    ->count_all_results($this->tb);

    return $count === 1;
  }

  public function can_edit($menu, $id_profile)
  {
    $count = $this->db
    ->where('menu', $menu)
    ->where('id_profile', $id_profile)
    ->where('can_edit', 1)
    ->count_all_results($this->tb);

    return $count === 1;
  }

  public function can_delete($menu, $id_profile)
  {
    $count = $this->db
    ->where('menu', $menu)
    ->where('id_profile', $id_profile)
    ->where('can_delete', 1)
    ->count_all_results($this->tb);

    return $count === 1;
  }

  public function can_approve($menu, $id_profile)
  {
    $count = $this->db
    ->where('menu', $menu)
    ->where('id_profile', $id_profile)
    ->where('can_approve', 1)
    ->count_all_results($this->tb);

    return $count === 1;
  }
}

 ?>
