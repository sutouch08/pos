<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_pwd extends PS_Controller
{
  public $title = 'เปลี่ยนรหัสผ่าน';
	public $menu_code = 'change password';
	public $menu_group_code = 'SC';	

	public function __construct()
	{
		parent::__construct();				
		$this->pm->can_view = 1;
    $this->home = base_url().'user_pwd';
    $this->load->model('users/user_model');
	}

	public function index()
	{
    $uid = $this->_user->uid;

    if(!empty($uid))
    {
      $user = $this->user_model->get_by_uid($uid);

      if(!empty($user))
      {
        $ds['user'] = $user;
        $this->load->view('users/change_pwd', $ds);
      }
      else
      {
        //--- ถ้าไม่มีข้อมูล ให้ไป login ใหม่
        redirect(base_url().'users/authentication');
      }
    }
    else
    {
      //--- ถ้าไม่มีข้อมูล ให้ไป login ใหม่
  		redirect(base_url().'users/authentication');
    }
  }


  public function change()
	{
    $uid = $this->_user->uid;

    if(!empty($uid))
    {
      $user = $this->user_model->get_by_uid($uid);

      if(!empty($user))
      {
        $ds['user'] = $user;
        $this->load->view('users/change_pwd', $ds);
      }
      else
      {
        //--- ถ้าไม่มีข้อมูล ให้ไป login ใหม่
        redirect(base_url().'users/authentication');
      }
    }
    else
    {
      //--- ถ้าไม่มีข้อมูล ให้ไป login ใหม่
  		redirect(base_url().'users/authentication');
    }
	}


	public function validate_current_password()
	{
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && ! empty($ds->uid) && ! empty($ds->pwd))
    {
      if($ds->uid != $this->_user->uid)
      {
        echo "Request user name is not match with current user name";
        return;
      }

      $user = $this->user_model->get_by_uid($ds->uid);

      if(empty($user))
      {
        echo "Invalid user name : {$ds->uid}";
        return;
      }

      if(password_verify($ds->pwd, $user->pwd))
      {
        echo "valid";
      }
      else
      {
        echo "invalid";
      }
    }
    else    
    {
      echo "Invalid request";
    }      
  }		


  public function change_password()
	{
		$sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if( empty($ds) || empty($ds->uid) || empty($ds->pwd) || empty($ds->new_pwd))
    {
      echo "Invalid request";
      return;
    }

    if($ds->uid != $this->_user->uid)
    {
      echo "Request user name is not match with current user name";
      return;
    }

    $user = $this->user_model->get_by_uid($ds->uid);		

		if(!empty($user))
		{
			if(password_verify($ds->pwd, $user->pwd))
			{				
				$arr = array(
					'pwd' => password_hash($ds->new_pwd, PASSWORD_DEFAULT),
					'force_reset' => 0,
					'last_pass_change' => now()
				);

				if(!$this->user_model->update($user->id, $arr))
				{
					$sc = FALSE;
					$this->error = "เปลี่ยนรหัสผ่านไม่สำเร็จ";
				}
			}
			else
			{
				$sc = FALSE;
				$this->error = "รหัสผ่านไม่ถูกต้อง";
			}
		}
		else
		{
			$sc = FALSE;
			$this->error = "Invalid Username or User not found";
		}

		echo $sc === TRUE ? 'success' : $this->error;
	}
  
}
