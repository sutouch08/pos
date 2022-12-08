<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends PS_Controller{
	public $menu_code = 'SCUSER'; //--- Add/Edit Users
	public $menu_group_code = 'SC'; //--- System security
	public $title = 'Users';
	public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'users/users';
  }



  public function index()
  {
		$filter = array(
			'uname' => get_filter('uname', 'user_uname', ''),
			'dname' => get_filter('dname', 'user_dname', ''),
			'sale_id' => get_filter('sale_id', 'user_sale_id', 'all'),
			'team_id' => get_filter('team_id', 'user_team_id', 'all'),			
			'group_id' => get_filter('group_id', 'user_group_id', 'all'),
			'active' => get_filter('active', 'user_active', 'all')
		);

		//--- แสดงผลกี่รายการต่อหน้า
		$perpage = get_rows();

		$rows = $this->user_model->count_rows($filter);

		$filter['data'] = $this->user_model->get_list($filter, $perpage, $this->uri->segment($this->segment));

		//--- ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$init	= pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);

		$this->pagination->initialize($init);

    $this->load->view('users/users_list', $filter);
  }





  public function add_new()
  {
		if($this->pm->can_add)
		{
			$this->title = "Add user";
			$this->load->view('users/user_add');
		}
		else
		{
			$this->permission_deny();
		}
  }



	public function add()
	{
		$sc = TRUE;

		if($this->pm->can_add)
		{
			if($this->input->post())
			{
				$uname = trim($this->input->post('uname'));
				$dname = trim($this->input->post('dname'));
				$sale_id = $this->input->post('sale_id');
				$emp_id = get_null($this->input->post('emp_id'));
				$team_id = get_null($this->input->post('team_id'));
				$quota_no = get_null(trim($this->input->post('quota_no')));
				$is_customer = is_true($this->input->post('is_customer'));
				$customer_code = get_null($this->input->post('customer_code'));
				$channels = get_null($this->input->post('channels'));
				$pwd = $this->input->post('pwd');
				$id_profile = get_null($this->input->post('profile'));
				$active = $this->input->post('active') == 1 ? 1 : 0;
				$force_reset = $this->input->post('force_reset') == 1 ? 1 : 0;

				if( ! $this->user_model->is_exists_uname($uname))
				{
					if( ! $this->user_model->is_exists_display_name($dname))
					{
						if( ! $is_customer OR ! empty($customer_code))
						{
							$arr = array(
								'uname' => $uname,
								'pwd' => password_hash($pwd, PASSWORD_DEFAULT),
								'name' => $dname,
								'uid' => md5($uname),
								'id_profile' => $id_profile,
								'active' => $active,
								'sale_id' => $sale_id,
								'emp_id' => $emp_id,
								'team_id' => $team_id,
								'quota_no' => $quota_no,
								'is_customer' => $is_customer ? 1 : 0,
								'customer_code' => $customer_code,
								'channels' => $channels,
								'last_pass_change' => date('Y-m-d'),
								'force_reset' => $force_reset
							);

							if( ! $this->user_model->add($arr))
							{
								$sc = FALSE;
								set_error('insert', 'user');
							}
						}
						else
						{
							$sc = FALSE;
							set_error('required', ' : Customer');
						}
					}
					else
					{
						$sc = FALSE;
						set_error('exists', "Display name : {$dname}");
					}
				}
				else
				{
					$sc = FALSE;
					set_error('exists', "Username : {$uname}");
				}
			}
			else
			{
				$sc = FALSE;
				set_error('required', ' : form data');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$this->_response($sc);
	}


	public function edit($id)
	{
		$this->title = "Edit user";

		if($this->pm->can_edit)
		{
			$this->load->model('masters/customers_model');

			$user = $this->user_model->get($id);

			if( ! empty($user))
			{
				$user->customer_name = $this->customers_model->get_name($user->customer_code);

				$ds = array(
					'user' => $user
				);

				$this->load->view('users/user_edit', $ds);
			}
			else
			{
				$this->error_page();
			}
		}
		else
		{
			$this->permission_deny();
		}
	}




	public function update()
	{
		$sc = TRUE;

		if($this->pm->can_edit)
		{
			if($this->input->post())
			{
				$id = $this->input->post('id');
				$dname = trim($this->input->post('dname'));
				$sale_id = $this->input->post('sale_id');
				$emp_id = get_null($this->input->post('emp_id'));
				$team_id = get_null($this->input->post('team_id'));
				$quota_no = get_null(trim($this->input->post('quota_no')));
				$is_customer = is_true($this->input->post('is_customer'));
				$customer_code = get_null($this->input->post('customer_code'));
				$channels = get_null($this->input->post('channels'));
				$id_profile = get_null($this->input->post('profile'));
				$active = $this->input->post('active') == 1 ? 1 : 0;

				if( ! $this->user_model->is_exists_display_name($dname, $id))
				{
					if( ! $is_customer OR ! empty($customer_code))
					{
						$arr = array(
							'name' => $dname,
							'id_profile' => $id_profile,
							'active' => $active,
							'sale_id' => $sale_id,
							'emp_id' => $emp_id,
							'team_id' => $team_id,
							'quota_no' => $quota_no,
							'is_customer' => $is_customer ? 1 : 0,
							'customer_code' => $customer_code,
							'channels' => $channels
						);

						if( ! $this->user_model->update($id, $arr))
						{
							$sc = FALSE;
							set_error('update', 'user');
						}
					}
					else
					{
						$sc = FALSE;
						set_error('required', ' : Customer');
					}
				}
				else
				{
					$sc = FALSE;
					set_error('exists', "Display name : {$dname}");
				}
			}
			else
			{
				$sc = FALSE;
				set_error('required', ' : form data');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$this->_response($sc);
	}




	public function view_detail($id)
	{
		$user = $this->user_model->get($id);

		if(!empty($user))
		{
			$user = $this->user_model->get($id);

			if( ! empty($user))
			{
				$ds = array(
					'user' => $user
				);

				$this->load->view('users/user_detail', $ds);
			}
			else
			{
				$this->error_page();
			}
		}
	}





	public function delete()
	{
		$sc = TRUE;

		if($this->pm->can_delete)
		{
			$id = $this->input->post('id');

			if( ! empty($id))
			{
				if( ! $this->user_model->has_transection($id))
				{
					if( ! $this->user_model->delete($id))
					{
						$sc = FALSE;
						set_error('delete');
					}
				}
				else
				{
					$sc = FALSE;
					$this->error = "Delete failed because completed transection exists OR link to another module.";
				}
			}
			else
			{
				$sc = FALSE;
				set_error('required', ' : id');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$this->_response($sc);
	}



	public function reset_password($id)
	{
		$this->title = 'Reset Password';

		if($this->pm->can_edit OR $this->pm->can_add)
		{
			$user = $this->user_model->get($id);

			if( ! empty($user))
			{
				$this->load->view('users/user_reset_pwd', array('user' => $user));
			}
			else
			{
				$this->error_page();
			}
		}
		else
		{
			$this->permission_deny();
		}
	}



	public function change_pwd()
	{
		$sc = TRUE;

		if($this->pm->can_edit OR $this->pm->can_add)
		{
			$id = $this->input->post('id');
			$pwd = $this->input->post('pwd');
			$force = $this->input->post('force_reset') == 1 ? 1 : 0;

			if( ! empty($id) && ! empty($pwd))
			{
				$arr = array(
					'pwd' => password_hash($pwd, PASSWORD_DEFAULT),
					'last_pass_change' => date('Y-m-d'),
					'force_reset' => $force
				);

				if( ! $this->user_model->update($id, $arr))
				{
					$sc = FALSE;
					set_error('update', 'password');
				}
			}
			else
			{
				$sc = FALSE;
				set_error('required', 'Password and id');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$this->_response($sc);
	}


	public function valid_uname()
	{
		$uname = trim($this->input->get('uname'));
		$id = $this->input->get('id');

		if( ! $this->user_model->is_exists_uname($uname, $id))
		{
			echo "ok";
		}
		else
		{
			echo "exists";
		}
	}


	public function valid_dname()
	{
		$dname = trim($this->input->get('dname'));
		$id = $this->input->get('id');

		if( ! $this->user_model->is_exists_display_name($dname, $id))
		{
			echo "OK";
		}
		else
		{
			echo "exists";
		}
	}


	public function clear_filter()
	{
		$filter = array(
			'user_uname',
			'user_dname',
			'user_sale_id',
			'user_team_id',
			'user_is_customer',
			'user_customer',
			'user_profile_id',
			'user_active'
		);

		return clear_filter($filter);

	}

}//--- end class


 ?>
