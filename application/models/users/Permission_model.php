<?php
class Permission_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }


  public function add(array $ds = array())
  {
    if(!empty($ds))
    {
      $this->db->insert('permission', $ds);
    }
  }


  public function add_batch(array $ds = array())
  {
    if( ! empty($ds))
    {
      return $this->db->insert_batch('permission', $ds);
    }

    return FALSE;
  }


  public function get_permission($menu, $id_profile)
  {
    if($id_profile == -987654321)
    {
      $ds = new stdClass();
      $ds->can_view = 1;
      $ds->can_add = 1;
      $ds->can_edit = 1;
      $ds->can_delete = 1;
      $ds->can_approve = 1;

      return $ds;
    }
        
    $this->db->where('menu', $menu)->where('id_profile', $id_profile);
    $rs = $this->db->get('permission');
    if($rs->num_rows() > 0)
    {
      return $rs->row();
    }
    else
    {
      $ds = new stdClass();
      $ds->can_view = 0;
      $ds->can_add = 0;
      $ds->can_edit = 0;
      $ds->can_delete = 0;
      $ds->can_approve = 0;

      return $ds;
    }
  }



  public function drop_permission($id)
  {
    return $this->db->where('id_profile', $id)->delete('permission');    
  }


  public function can_add($menu, $id_profile)
  {
    $perm = $this->get_permission($menu, $id_profile);
    return $perm->can_add == 1 ? TRUE : FALSE;
  }

  public function can_edit($menu, $id_profile)
  {
    $perm = $this->get_permission($menu, $id_profile);
    return $perm->can_edit == 1 ? TRUE : FALSE;
  }

  public function can_delete($menu, $id_profile)
  {
    $perm = $this->get_permission($menu, $id_profile);
    return $perm->can_delete == 1 ? TRUE : FALSE;
  }

  public function can_approve($menu, $id_profile)
  {
    $perm = $this->get_permission($menu, $id_profile);
    return $perm->can_approve == 1 ? TRUE : FALSE;
  }
}

 ?>
