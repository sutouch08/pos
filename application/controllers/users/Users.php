<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends PS_Controller
{
	public $menu_code = 'SCUSER';
	public $menu_group_code = 'SC';
	public $title = 'Users';
	public $segment = 4;

	public function __construct()
	{
		parent::__construct();
		$this->home = base_url() . 'users/users';
		$this->load->model('users/profile_model');
		$this->load->helper('profile');
		$this->load->helper('saleman');
		$this->load->helper('employee');
	}


	public function index()
	{
		$filter = array(
			'uname' => get_filter('uname', 'user', ''),
			'dname' => get_filter('dname', 'dname', ''),
			'profile' => get_filter('profile', 'profile', 'all'),
			'status' => get_filter('status', 'status', 'all')
		);

		if ($this->input->post('search'))
		{
			redirect($this->home);
		}
		else
		{
			$perpage = get_rows();
			$rows = $this->user_model->count_rows($filter);
			$filter['data'] = $this->user_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
			$init	= pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
			$this->pagination->initialize($init);
			$this->load->view('users/user_list', $filter);
		}
	}


	public function add_new()
	{
		$this->title = 'Create New User';

		if($this->pm->can_add)
		{
			$this->load->view('users/user_add');
		}
		else
		{
			$this->deny_page();
		}
	}


	public function add()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if ($this->pm->can_add)
		{
			if (! empty($ds) && ! empty($ds->uname) && ! empty($ds->dname) && ! empty($ds->pwd) && ! empty($ds->id_profile))
			{
				if ($this->user_model->is_exists_uname($ds->uname))
				{
					$sc = FALSE;
					$this->error = "{$ds->uname} already exists !";
				}

				if ($sc === TRUE)
				{
					if ($this->user_model->is_exists_dname($ds->dname))
					{
						$sc = FALSE;
						$this->error = "{$ds->dname} already exists !";
					}
				}

				if ($sc === TRUE)
				{
					$profile = $this->profile_model->get($ds->id_profile);

					if (empty($profile))
					{
						$sc = FALSE;
						$this->error = "Profile not found !";
					}
				}

				if ($sc === TRUE)
				{
					$arr = array(
						'uname' => $ds->uname,
						'name' => $ds->dname,
						'pwd' => password_hash($ds->pwd, PASSWORD_DEFAULT),
						'uid' => genUid(32),
						'id_profile' => get_null($ds->id_profile),
						'profile_id' => $profile->uid,
						'emp_id' => get_null($ds->id_employee),
						'sale_id' => get_null($ds->sale_id),
						'active' => $ds->active,
						'last_pass_change' => date('Y-m-d'),
						'force_reset' => $ds->force_reset == 1 ? 1 : 0,
						'create_by' => $this->_user->id
					);

					if (! $this->user_model->add($arr))
					{
						$sc = FALSE;
						set_error('insert');
					}
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
			'status' => $sc === TRUE ? 'success' : 'failed',
			'message' => $sc === TRUE ? 'success' : $this->error
		);

		echo json_encode($arr);
	}


	public function edit($uid)
	{
		$this->title = 'Edit User';

		if($this->pm->can_edit)
		{
			$user = $this->user_model->get_by_uid($uid);

			if( ! empty($user))
			{
				$this->load->view('users/user_edit', array('user' => $user));
			}
			else
			{
				$this->page_not_found();
			}
		}
		else 
		{
			$this->deny_page();			
		}		
	}


	public function update()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->uid) && ! empty($ds->uname) && ! empty($ds->dname))
		{
			$user = $this->user_model->get_by_uid($ds->uid);

			if( ! empty($user))
			{
				$id = $user->id;				

				if ($sc === TRUE)
				{
					if ($this->user_model->is_exists_dname($ds->dname, $id))
					{
						$sc = FALSE;
						$this->error = "{$ds->dname} already exists !";
					}
				}

				if($sc === TRUE)
				{
					$profile = $this->profile_model->get($ds->id_profile);

					if (empty($profile))
					{
						$sc = FALSE;
						$this->error = "Profile not found !";
					}
				}

				if ($sc === TRUE)
				{
					$arr = array(
						'uname' => $ds->uname,
						'name' => $ds->dname,
						'id_profile' => get_null($ds->id_profile),
						'profile_id' => $profile->uid,
						'emp_id' => get_null($ds->id_employee),
						'sale_id' => get_null($ds->sale_id),
						'active' => $ds->active,
						'update_by' => $this->_user->id
					);

					if (! $this->user_model->update($id, $arr))
					{
						$sc = FALSE;
						set_error('update');
					}
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

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'failed',
			'message' => $sc === TRUE ? 'success' : $this->error
		);

		echo json_encode($arr);
	}


	public function restore()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if(! empty($ds) && ! empty($ds->uid))
		{
			if($this->pm->can_approve)
			{
				$user = $this->user_model->get_by_uid($ds->uid);

				if( ! empty($user))
				{
					$arr = array(
						'active' => 1,
						'delete_by' => NULL,
						'delete_at' => NULL,
						'update_by' => $this->_user->id
					);

					if( ! $this->user_model->update($user->id, $arr))
					{
						$sc = FALSE;
						set_error('update');
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
		}
		else 
		{
			$sc = FALSE;
			set_error('required');
		}

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'failed',
			'message' => $sc === TRUE ? 'success' : $this->error
		);

		echo json_encode($arr);
	}


	public function permanent_delete()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if(! empty($ds) && ! empty($ds->uid))
		{
			if($this->pm->can_delete && $this->pm->can_approve)
			{
				$user = $this->user_model->get_by_uid($ds->uid);

				if( ! empty($user))
				{
					// check user transection before delete

					if( $this->user_model->has_transection($user->id))
					{
						$sc = FALSE;
						$this->error = "This user has transaction history. Can't delete permanently !";
					}

					if($sc === TRUE)
					{
						if( ! $this->user_model->delete($user->id))
						{
							$sc = FALSE;
							set_error('delete');
						}
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
		}
		else 
		{
			$sc = FALSE;
			set_error('required');
		}

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'failed',
			'message' => $sc === TRUE ? 'success' : $this->error
		);

		echo json_encode($arr);
	}
	

	public function view_detail($uid)
	{
		$this->title = 'User Detail';
		$user = $this->user_model->get_by_uid($uid);

		if( ! empty($user))
		{
			$this->load->view('users/user_detail', array('user' => $user));
		}
		else
		{
			$this->page_not_found();
		}
	}
	

	public function reset_password($uid)
	{
		if($this->pm->can_edit)
		{
			$user = $this->user_model->get_by_uid($uid);

			if( ! empty($user))
			{
				$this->title = 'Reset Password';
				$data['user'] = $user;
				$this->load->view('users/user_reset_pwd', $data);
			}
			else 
			{
				$this->page_not_found();				
			}
		}
		else
		{
			$this->deny_page();			
		}		
	}


	public function change_password()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->id) && $ds->pwd != '')
		{
			$user = $this->user_model->get_by_id($ds->id);

			if (! empty($user))
			{
				$arr = array(
					'pwd' => $pwd = password_hash($ds->pwd, PASSWORD_DEFAULT),
					'force_reset' => $ds->force,
					'last_pass_change' => now()
				);

				if (! $this->user_model->update($ds->id, $arr))
				{
					$sc = FALSE;
					$this->error = "Update password failed";
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


	public function delete()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if(! empty($ds) && ! empty($ds->uid))
		{
			if($this->pm->can_delete)
			{
				$user = $this->user_model->get_by_uid($ds->uid);

				if( ! empty($user))
				{
					$arr = array(
						'active' => -1,
						'delete_by' => $this->_user->id,
						'delete_at' => now(),
						'update_by' => $this->_user->id
					);

					if( ! $this->user_model->update($user->id, $arr))
					{
						$sc = FALSE;
						set_error('update');
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
		}
		else 
		{
			$sc = FALSE;
			set_error('required');
		}

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'failed',
			'message' => $sc === TRUE ? 'success' : $this->error
		);

		echo json_encode($arr);
	}


	public function valid_dname()
	{
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds))
		{
			if ($this->user_model->is_exists_dname($ds->dname, $ds->id))
			{
				echo 'exists';
			}
			else
			{
				echo 'not_exists';
			}
		}
	}



	public function valid_uname()
	{
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds))
		{
			if ($this->user_model->is_exists_uname($ds->uname, $ds->id))
			{
				echo 'exists';
			}
			else
			{
				echo 'not_exists';
			}
		}
	}


	public function get_permission($uid)
	{
		$sc = TRUE;
		$this->load->model('users/permission_model');

		$ds = [];

		$user = $this->user_model->get_by_uid($uid);

		if (! empty($user))
		{
			$ds['header'] = "Permission : \"{$user->uname}\"";
			$ds['group'] = [];

			$groups = $this->menu_model->get_active_menu_groups();

			if (! empty($groups))
			{
				foreach ($groups as $gp)
				{
					if ($gp->pm)
					{
						$menuGroup = array(
							'group_code' => $gp->code,
							'group_name' => $gp->name,
							'menu' => ''
						);

						$menus = $this->menu_model->get_menus_by_group($gp->code);

						if (! empty($menus))
						{
							$item = array();

							foreach ($menus as $menu)
							{
								if ($menu->valid)
								{
									$pm = $this->permission_model->get_permission($menu->code, $user->id_profile);

									$item[] = array(
										'menu_code' => $menu->code,
										'menu_name' => $menu->name,
										'cv' => $pm->can_view ? 1 : 0,
										'ca' => $pm->can_add ? 1 : 0,
										'ce' => $pm->can_edit ? 1 : 0,
										'cd' => $pm->can_delete ? 1 : 0,
										'cp' => $pm->can_approve ? 1 : 0
									);
								}
							}

							$menuGroup['menu'] = $item;
						}

						$ds['group'][] = $menuGroup;
					}
				}
			}
		}
		else
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


	public function get_user_permissions($id)
	{
		$this->load->model('users/permission_model');
		$sc = TRUE;
		$ds = array();

		$user = $this->user_model->get_by_id($id);

		if (! empty($user))
		{
			$ds['header'] = "Permission : \"{$user->uname}\"";
			$ds['group'] = array();

			$groups = $this->menu_model->get_active_menu_groups();

			if (! empty($groups))
			{
				foreach ($groups as $gp)
				{
					if ($gp->pm)
					{
						$menuGroup = array(
							'group_code' => $gp->code,
							'group_name' => $gp->name,
							'menu' => ''
						);

						$menus = $this->menu_model->get_menus_by_group($gp->code);

						if (! empty($menus))
						{
							$item = array();

							foreach ($menus as $menu)
							{
								if ($menu->valid)
								{
									$pm = $this->permission_model->get_permission($menu->code, $user->id_profile);

									$arr = array(
										'menu_code' => $menu->code,
										'menu_name' => $menu->name,
										'cv' => $pm->can_view ? 1 : 0,
										'ca' => $pm->can_add ? 1 : 0,
										'ce' => $pm->can_edit ? 1 : 0,
										'cd' => $pm->can_delete ? 1 : 0,
										'cp' => $pm->can_approve ? 1 : 0
									);

									array_push($item, $arr);
								}
							}

							$menuGroup['menu'] = $item;
						}

						array_push($ds['group'], $menuGroup);
					}
				}
			}
		}
		else
		{
			$sc = FALSE;
			$this->error = "Invalid user id";
		}

		echo $sc === TRUE ? json_encode($ds) : $this->error;
	}




	public function export_permission()
	{
		$this->load->model('users/permission_model');
		$this->load->model('users/profile_model');
		$token = $this->input->post('token');
		$uid = $this->input->post('uid');

		$user = $this->user_model->get_by_uid($uid);
		$uname = empty($user) ? 'no data' : $user->uname;

		//--- load excel library
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle($uname);

		if (! empty($user))
		{
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('15');

			$this->excel->getActiveSheet()->setCellValue('A1', 'User : ')->getStyle('A1')->getAlignment()->setHorizontal('right');
			$this->excel->getActiveSheet()->setCellValue('B1', $user->uname);
			$this->excel->getActiveSheet()->mergeCells('B1:C1');

			$this->excel->getActiveSheet()->setCellValue('D1', 'Display name : ')->getStyle('D1')->getAlignment()->setHorizontal('right');
			$this->excel->getActiveSheet()->setCellValue('E1', $user->name);
			$this->excel->getActiveSheet()->mergeCells('E1:F1');

			$this->excel->getActiveSheet()->setCellValue('A2', 'Profile : ')->getStyle('A2')->getAlignment()->setHorizontal('right');
			$this->excel->getActiveSheet()->setCellValue('B2', $this->profile_model->get_name($user->id_profile));
			$this->excel->getActiveSheet()->mergeCells('B2:C2');
			$this->excel->getActiveSheet()->setCellValue('D2', "Status : ")->getStyle('D2')->getAlignment()->setHorizontal('right');
			$this->excel->getActiveSheet()->setCellValue('E2', ($user->active == 1 ? 'Active' : ($user->active == -1 ? 'Deleted' : 'Inactive')));
			$this->excel->getActiveSheet()->mergeCells('E2:F2');

			$row = 4;


			$groups = $this->menu_model->get_active_menu_groups();

			if (! empty($groups))
			{
				foreach ($groups as $gp)
				{
					if ($gp->pm)
					{
						$this->excel->getActiveSheet()->setCellValue("A{$row}", $gp->name);
						$this->excel->getActiveSheet()->setCellValue("B{$row}", 'ดู');
						$this->excel->getActiveSheet()->setCellValue("C{$row}", 'เพิ่ม');
						$this->excel->getActiveSheet()->setCellValue("D{$row}", 'แก้ไข');
						$this->excel->getActiveSheet()->setCellValue("E{$row}", 'ลบ');
						$this->excel->getActiveSheet()->setCellValue("F{$row}", 'อนุมัติ');


						$color = array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array('rgb' => 'F28A8C')
						);

						$this->excel->getActiveSheet()->getStyle("A{$row}:F{$row}")->getFill()->applyFromArray($color);

						$row++;

						$menus = $this->menu_model->get_menus_by_group($gp->code);

						if (! empty($menus))
						{
							foreach ($menus as $menu)
							{
								if ($menu->valid)
								{
									$pm = $this->permission_model->get_permission($menu->code, $user->id_profile);

									$this->excel->getActiveSheet()->setCellValue("A{$row}", $menu->name);
									$this->excel->getActiveSheet()->setCellValue("B{$row}", ($pm->can_view ? 'Y' : '-'));
									$this->excel->getActiveSheet()->setCellValue("C{$row}", ($pm->can_add ? 'Y' : '-'));
									$this->excel->getActiveSheet()->setCellValue("D{$row}", ($pm->can_edit ? 'Y' : '-'));
									$this->excel->getActiveSheet()->setCellValue("E{$row}", ($pm->can_delete ? 'Y' : '-'));
									$this->excel->getActiveSheet()->setCellValue("F{$row}", ($pm->can_approve ? 'Y' : '-'));

									$row++;
								}
							}
						}
					} //-- endif
				} //--- end foreach

				if ($row > 3)
				{
					$this->excel->getActiveSheet()->getStyle("B3:F{$row}")->getAlignment()->setHorizontal('center');
				}
			} //--- endif group
		}

		setToken($token);
		$file_name = "{$uname} Permission.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); /// form excel 2007 XLSX
		header('Content-Disposition: attachment;filename="' . $file_name . '"');
		$writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$writer->save('php://output');
	}



	public function export_all_permission()
	{
		$this->load->model('users/permission_model');
		$this->load->model('users/profile_model');
		$token = $this->input->post('alltoken');
		$all = $this->input->post('all') == 1 ? TRUE : FALSE;

		$users = $this->user_model->get_all($all);

		$ds = array();

		$groups = $this->menu_model->get_active_menu_groups();

		if (! empty($groups))
		{
			foreach ($groups as $group)
			{
				if ($group->pm)
				{
					$arr = array(
						'name' => $group->name,
						'menus' => NULL
					);

					$menus = $this->menu_model->get_menus_by_group($group->code);

					if (! empty($menus))
					{
						$items = array();

						foreach ($menus as $menu)
						{
							if ($menu->valid)
							{
								$items[] = array(
									'code' => $menu->code,
									'name' => $menu->name
								);
							}
						}

						$arr['menus'] = $items;
					}
				}

				$ds[] = $arr;
			}
		}


		//--- load excel library
		$this->load->library('excel');

		if (! empty($users))
		{
			$index = 0;

			foreach ($users as $user)
			{
				$worksheet = new PHPExcel_Worksheet($this->excel, $user->uname);
				$this->excel->addSheet($worksheet, $index);
				$this->excel->setActiveSheetIndex($index);
				$tabColor = $user->active == 1 ? '54c784' : ($user->active == -1 ? 'f2c96b' : 'c96b65');
				$this->excel->getActiveSheet()->getTabColor()->setARGB($tabColor);

				$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
				$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
				$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
				$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
				$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
				$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('15');

				$this->excel->getActiveSheet()->setCellValue('A1', 'User : ')->getStyle('A1')->getAlignment()->setHorizontal('right');
				$this->excel->getActiveSheet()->setCellValue('B1', $user->uname);
				$this->excel->getActiveSheet()->mergeCells('B1:C1');

				$this->excel->getActiveSheet()->setCellValue('D1', 'Display name : ')->getStyle('D1')->getAlignment()->setHorizontal('right');
				$this->excel->getActiveSheet()->setCellValue('E1', $user->name);
				$this->excel->getActiveSheet()->mergeCells('E1:F1');

				$this->excel->getActiveSheet()->setCellValue('A2', 'Profile : ')->getStyle('A2')->getAlignment()->setHorizontal('right');
				$this->excel->getActiveSheet()->setCellValue('B2', $this->profile_model->get_name($user->id_profile));
				$this->excel->getActiveSheet()->mergeCells('B2:C2');
				$this->excel->getActiveSheet()->setCellValue('D2', "Status : ")->getStyle('D2')->getAlignment()->setHorizontal('right');
				$this->excel->getActiveSheet()->setCellValue('E2', ($user->active == 1 ? 'Active' : ($user->active == -1 ? 'Deleted' : 'Inactive')));
				$this->excel->getActiveSheet()->mergeCells('E2:F2');

				$row = 4;

				if (! empty($ds))
				{
					foreach ($ds as $rs)
					{
						$this->excel->getActiveSheet()->setCellValue("A{$row}", $rs['name']);
						$this->excel->getActiveSheet()->setCellValue("B{$row}", 'ดู');
						$this->excel->getActiveSheet()->setCellValue("C{$row}", 'เพิ่ม');
						$this->excel->getActiveSheet()->setCellValue("D{$row}", 'แก้ไข');
						$this->excel->getActiveSheet()->setCellValue("E{$row}", 'ลบ');
						$this->excel->getActiveSheet()->setCellValue("F{$row}", 'อนุมัติ');


						$color = array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array('rgb' => 'F28A8C')
						);

						$this->excel->getActiveSheet()->getStyle("A{$row}:F{$row}")->getFill()->applyFromArray($color);

						$row++;

						$menus = $rs['menus'];

						if (! empty($menus))
						{
							foreach ($menus as $menu)
							{
								$pm = $this->permission_model->get_permission($menu['code'], $user->id_profile);

								$this->excel->getActiveSheet()->setCellValue("A{$row}", $menu['name']);
								$this->excel->getActiveSheet()->setCellValue("B{$row}", ($pm->can_view ? 'Y' : '-'));
								$this->excel->getActiveSheet()->setCellValue("C{$row}", ($pm->can_add ? 'Y' : '-'));
								$this->excel->getActiveSheet()->setCellValue("D{$row}", ($pm->can_edit ? 'Y' : '-'));
								$this->excel->getActiveSheet()->setCellValue("E{$row}", ($pm->can_delete ? 'Y' : '-'));
								$this->excel->getActiveSheet()->setCellValue("F{$row}", ($pm->can_approve ? 'Y' : '-'));

								$row++;
							}
						}
					} //--- end foreach

					if ($row > 4)
					{
						$this->excel->getActiveSheet()->getStyle("B3:F{$row}")->getAlignment()->setHorizontal('center');
					}
				} //--- endif group

				$index++;
			}
		}

		setToken($token);
		$file_name = "Users Permission.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); /// form excel 2007 XLSX
		header('Content-Disposition: attachment;filename="' . $file_name . '"');
		$writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$writer->save('php://output');
	}



	public function clear_filter()
	{
		$filter = ['uname', 'dname', 'profile', 'status'];
		return clear_filter($filter);
	}
} //--- end class
