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


	public function edit($id)
	{
		if($this->pm->can_add OR $this->pm->can_edit)
		{
			$profile = $this->profile_model->get($id);
			
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
											'permission' => $this->permission_model->get_permission($menu->code, $id)
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

		if( ! empty($ds) && ! empty($ds->id))
		{
			if( ! empty($ds->menus))
			{
				$batches = [];

				foreach($ds->menus as $rs)
				{
					$batches[] = array(
						'id_profile' => $ds->id,
						'menu' => $rs->menu,
						'can_view' => $rs->view,
						'can_add' => $rs->add,
						'can_edit' => $rs->edit,
						'can_delete' => $rs->delete,
						'can_approve' => $rs->approve
					);
				}

				$this->db->trans_begin();

				if( ! $this->permission_model->drop_permission($ds->id))
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



	public function clear_filter()
	{
		$filter = array('profileName', 'menux', 'permission');
		clear_filter($filter);
		echo 'done';
	}
} //-- end class
