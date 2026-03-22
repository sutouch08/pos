<?php
class User_model extends CI_Model
{
  private $tb = "user";
  private $superadmin = -987654321;

  public function __construct()
  {
    parent::__construct();
  }


  public function get_all($all = TRUE)
  {
    $this->db
    ->select('u.*')
    ->select('p.name AS profile_name')
    ->from('user AS u')
    ->join('profile AS p', 'u.id_profile = p.id', 'left');

    if( ! $all)
    {
      $this->db->where('active', 1);
    }

    $rs = $this->db->order_by('u.uname', 'ASC')->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function add(array $ds = array())
  {
    if( ! empty($ds))
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


  public function get_by_id($id)
  {
    $rs = $this->db->where('id', $id)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_by_uid($uid)
  {
    $rs = $this->db->where('uid', $uid)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get($uname)
  {
    $rs = $this->db->where('uname', $uname)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_name($uname)
  {
    $rs = $this->db->where('uname', $uname)->get($this->tb);

    if($rs->num_rows() == 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
		$this->db
		->select('user.*, user.name AS dname, profile.name AS pname')
		->from($this->tb)
		->join('profile', 'user.id_profile = profile.id', 'left');

		if( ! empty($ds['uname']))
		{
			$this->db->like('user.uname', $ds['uname']);
		}

		if( ! empty($ds['dname']))
		{
			$this->db->like('user.name', $ds['dname']);
		}

		if(isset($ds['profile']) && $ds['profile'] != 'all')
		{
      $this->db->where('profile.id', $ds['profile']);			
		}

    if(isset($ds['status']) && $ds['status'] != "" && $ds['status'] != 'all')
    {
      $this->db->where('user.active', $ds['status']);
    }

		$rs = $this->db->order_by('user.name', 'ASC')->limit($perpage, $offset)->get();

		if($rs->num_rows() > 0)
		{
			return $rs->result();
		}

    return NULL;
  }


  public function count_rows(array $ds = array())
  {		
		if( ! empty($ds['uname']))
		{
			$this->db->like('uname', $ds['uname']);
		}

		if(!empty($ds['dname']))
		{
			$this->db->like('name', $ds['dname']);
		}

    if (isset($ds['profile']) && $ds['profile'] != 'all')
    {
      $this->db->where('id_profile', $ds['profile']);
    }

    if(isset($ds['status']) && $ds['status'] != "" && $ds['status'] != 'all')
    {
      $this->db->where('active', $ds['status']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_permission($menu_code, $id_profile)
  {
    if(empty($menu_code))
    {
      return FALSE;
    }
    
    $this->load->model('menu_model');

    $menu = $this->menu_model->get($menu_code);

    if( ! empty($menu))
    {
      $ds = FALSE;

      if($menu->valid OR $id_profile == $this->superadmin)
      {
        $ds = (object) array(
          'can_view' => 1,
          'can_add' => 1,
          'can_edit' => 1,
          'can_delete' => 1,
          'can_approve' => 1
        );
      }
      else 
      {
        $ds = $this->get_profile_permission($menu_code, $id_profile);
      }

      return $ds;
    }

    return FALSE;
  }


  private function get_profile_permission($menu, $id_profile)
  {
    $rs = $this->db
    ->where('menu', $menu)
    ->where('id_profile', $id_profile)
    ->get('permission');

    return $rs->num_rows() == 1 ? $rs->row() : NULL;
  }


  public function is_exists_uname($uname, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('uname', $uname)->count_all_results($this->tb);
    return $count > 0 ? TRUE : FALSE;    
  }


  public function is_exists_dname($dname, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    $count = $this->db->where('name', $dname)->count_all_results($this->tb);
    return $count > 0 ? TRUE : FALSE;    
  }


  public function is_skey_exists($skey, $uid)
  {
    $count = $this->db->where('skey', $skey)->where('uid !=', $uid)->count_all_results($this->tb);
    return $count > 0 ? TRUE : FALSE;
  }


  public function get_user_credentials($uname)
  {
    $rs = $this->db->where('uname', $uname)->get($this->tb);    
    return $rs->num_rows() === 1 ? $rs->row() : NULL;
  }


  public function verify_uid($uid)
  {
    $count = $this->db->where('uid', $uid)->where('active', 1)->count_all_results($this->tb);
    return $count === 1 ? TRUE : FALSE;
  }


  public function get_user_credentials_by_skey($skey)
  {
    if( ! empty($skey))
    {
      $rs = $this->db->where('skey', $skey)->get($this->tb);
      return $rs->num_rows() === 1 ? $rs->row() : NULL;     
    }

    return NULL;
  }


	public function has_transection($uname)
	{
		//return TRUE;
		return FALSE;
	}


} //---- End class

 ?>
