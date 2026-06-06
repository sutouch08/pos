<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permission extends PS_Controller
{
	public $menu_code = 'SCPERM'; //--- Add/Edit Profile
	public $menu_group_code = 'SC'; //--- System security
	public $title = 'Permission';
	public $permission = FALSE;
	public $segment = 4;

	public function __construct()
	{
		parent::__construct();
		//--- If any right to add, edit, or delete mean granted
		if ($this->pm->can_add or $this->pm->can_edit or $this->pm->can_delete)
		{
			$this->permission = TRUE;
		}

		$this->home = base_url() . 'users/permission';
		$this->load->model('users/profile_model');
		$this->load->model('users/permission_model');
		$this->load->model('menu_model');
	}


	public function index()
	{
		$filter = array(
			'name' => get_filter('name', 'profileName', ''),
			'menu' => get_filter('menu', 'menux', 'all'),
			'permission' => get_filter('permission', 'permission', 'all')
		);

		if ($this->input->post('search'))
		{
			redirect($this->home);
		}
		else
		{
			$perpage = get_rows();			
			$rows = $this->profile_model->count_rows($filter);
			$filter['data'] = $this->profile_model->get_list($filter, $perpage, $this->uri->segment($this->segment));			
			$init	= pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);		
			$this->pagination->initialize($init);

			if (!empty($filter['data']))
			{
				foreach ($filter['data'] as $rs)
				{
					$rs->member = $this->profile_model->count_members($rs->id);
				}
			}	

			$this->load->view('users/permission_list', $filter);
		}
	}

	//--- add new profiile 
	public function add()
	{
		$sc = TRUE;
		if($this->pm->can_add)
		{
			$uid = genUid();
			$name = $this->input->post('name');

			if( ! empty($name))
			{
				if( ! $this->profile_model->is_exists_name($name))
				{
					$ds = array(
						'uid' => $uid,
						'name' => $name,
						'create_by' => $this->_user->id,
						'create_at' => date('Y-m-d H:i:s')
					);

					if( ! $this->profile_model->add($ds))
					{
						$sc = FALSE;
						set_error('insert');
					}
					else 
					{
						$ds['member'] = 0;
					}
				}
				else
				{
					$sc = FALSE;
					set_error('exists', $name);
				}
			}
			else
			{
				$sc = FALSE;
				set_error('required');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'error',
			'message' => $sc === TRUE ? 'success' : $this->error,
			'data' => $sc === TRUE ? $ds : NULL,
			'can_edit' => $this->pm->can_edit ? TRUE : FALSE,
			'can_delete' => $this->pm->can_delete ? TRUE : FALSE
		);

		echo json_encode($arr);
	}
	

	//--- edit profile name
	public function get($uid)
	{
		$sc = TRUE;
		$ds = $this->profile_model->get_by_uid($uid);

		if(empty($ds))
		{
			$sc = FALSE;
			set_error('notfound');
		}

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'failed',
			'message' => $sc === TRUE ? 'success' : $this->error,
			'data' => $sc === TRUE ? $ds : NULL
		);

		echo json_encode($arr);
	}

	//--- update profile name
	public function update()
	{
		$sc = TRUE;
		if($this->pm->can_edit)
		{
			$uid = $this->input->post('uid');
			$name = $this->input->post('name');

			if( ! empty($name))
			{
				if( ! $this->profile_model->is_exists_name($name, $uid))
				{
					$ds = array(
						'name' => $name,
						'update_by' => $this->_user->id,
						'update_at' => date('Y-m-d H:i:s')
					);

					if( ! $this->profile_model->update_by_uid($uid, $ds))
					{
						$sc = FALSE;
						set_error('update');
					}
				}
				else
				{
					$sc = FALSE;
					set_error('exists', $name);
				}
			}
			else
			{
				$sc = FALSE;
				set_error('required');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		echo json_encode(array(
			'status' => $sc === TRUE ? 'success' : 'error',
			'message' => $sc === TRUE ? 'success' : $this->error
		));
	}

	//--- delete profile
	public function delete()
	{
		$sc = TRUE;
		if($this->pm->can_delete)
		{
			$uid = $this->input->post('uid');
			$profile = $this->profile_model->get_by_uid($uid);

			if( ! empty($profile))
			{
				$this->db->trans_begin();

				if( ! $this->permission_model->drop_permission($profile->id))
				{
					$sc = FALSE;
					$this->error = "Delete failed : Cannot delete prevoius permission";
				}

				if($sc === TRUE)
				{
					if( ! $this->profile_model->delete($profile->id))
					{
						$sc = FALSE;
						set_error('delete');
					}
				}
				
				if($sc === TRUE)
				{
					$this->db->trans_commit();
				}
				else 
				{
					$this->db->trans_rollback();
				}
			}
			else
			{
				$sc = FALSE;
				set_error('notfound');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$this->_response($sc);
	}
	
	//--- edit permission
	public function edit_permission($uid)
	{
		if($this->pm->can_add OR $this->pm->can_edit)
		{
			$profile = $this->profile_model->get_by_uid($uid);
			
			if( ! empty($profile))
			{
				$this->title = "Manage Permission  - {$profile->name}";
				$data['profile'] = $profile;
				$data['menus'] = [];
				$groups = $this->menu_model->get_menu_groups();

				if( ! empty($groups))
				{
					foreach($groups as $group)
					{
						if($group->pm)
						{
							$c = 0; //-- นับจำนวนเมนู

							$ds = array(
								'group_code' => $group->code,
								'group_name' => $group->name,
								'menu' => []
							);

							$menus = $this->menu_model->get_menus_by_group($group->code);

							if( ! empty($menus))
							{
								foreach($menus as $menu)
								{
									if($menu->valid)
									{
										$ds['menu'][] = array(
											'menu_code' => $menu->code,
											'menu_name' => $menu->name,
											'permission' => $this->permission_model->get_permission($menu->code, $profile->id)
										);

										$c++;
									}
								}
							}

							if($c > 0)
							{
								//--- ถ้า มี active menu ในกลุ่ม เพิ่มเช้ารายการกำหนดสิทธิ์ ถ้าไม่มีไม่ต้องกำหนดสิทธิ์
								$data['menus'][] = $ds;
							}
						}
					}
				}

				$this->load->view('users/permission_edit', $data);
			}
			else 
			{
				$this->page_error();
			}
		}
		else 
		{
			$this->deny_page();
		}
	}


	public function set_permission()
	{
		$sc = TRUE;
		$ds = json_decode($this->input->post('data'));

		if( ! empty($ds) && ! empty($ds->uid))
		{
			$profile = $this->profile_model->get_by_uid($ds->uid);

			if( ! empty($ds->permissions) && ! empty($profile))
			{
				$batches = [];

				foreach($ds->permissions as $rs)
				{
					$batches[] = array(
						'id_profile' => $profile->id,
						'menu' => $rs->menu,
						'can_view' => $rs->view,
						'can_add' => $rs->add,
						'can_edit' => $rs->edit,
						'can_delete' => $rs->delete,
						'can_approve' => $rs->approve
					);
				}

				$this->db->trans_begin();

				if( ! $this->permission_model->drop_permission($profile->id))
				{
					$sc = FALSE;
					$this->error = "Update failed : Cannot delete prevoius permission";
				}

				if($sc === TRUE)
				{
					if( ! $this->permission_model->add_batch($batches))
					{
						$sc = FALSE;
						set_error('insert');
					}
				}

				if($sc === TRUE)
				{
					$this->db->trans_commit();
				}
				else 
				{
					$this->db->trans_rollback();
				}
			}
			else 
			{
				$sc = FALSE;
				set_error('notfound');
			}
		}
		else 
		{
			$sc = FALSE;
			set_error('required');
		}

		$this->_response($sc);
	}


	//--- view permission
	public function view_permission($uid)
	{
		if ($this->pm->can_add or $this->pm->can_edit)
		{
			$profile = $this->profile_model->get_by_uid($uid);

			if (! empty($profile))
			{
				$this->title = "Permission  of {$profile->name}";
				$data['profile'] = $profile;
				$data['menus'] = [];
				$groups = $this->menu_model->get_menu_groups();

				if (! empty($groups))
				{
					foreach ($groups as $group)
					{
						if ($group->pm)
						{
							$c = 0; //-- นับจำนวนเมนู

							$ds = array(
								'group_code' => $group->code,
								'group_name' => $group->name,
								'menu' => []
							);

							$menus = $this->menu_model->get_menus_by_group($group->code);

							if (! empty($menus))
							{
								foreach ($menus as $menu)
								{
									if ($menu->valid)
									{
										$ds['menu'][] = array(
											'menu_code' => $menu->code,
											'menu_name' => $menu->name,
											'permission' => $this->permission_model->get_permission($menu->code, $profile->id)
										);

										$c++;
									}
								}
							}

							if ($c > 0)
							{
								//--- ถ้า มี active menu ในกลุ่ม เพิ่มเช้ารายการกำหนดสิทธิ์ ถ้าไม่มีไม่ต้องกำหนดสิทธิ์
								$data['menus'][] = $ds;
							}
						}
					}
				}

				$this->load->view('users/permission_details', $data);
			}
			else
			{
				$this->page_error();
			}
		}
		else
		{
			$this->deny_page();
		}
	}


	public function is_exists_profile()
	{
		$name = $this->input->post('name');
		$uid = $this->input->post('uid');
		$res = 'not_exists';

		if($this->profile_model->is_exists_name($name, $uid))
		{
			$res = 'exists';
		}

		echo $res;
	}


	public function clear_filter()
	{
		$filter = array('profileName', 'menux', 'permission');
		clear_filter($filter);
		echo 'done';
	}
} //-- end class
