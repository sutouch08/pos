<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sender extends PS_Controller
{
	public $menu_code = 'DBSEND';
	public $menu_group_code = 'DB';
	public $menu_sub_group_code = ''; 
	public $title = 'เพิ่ม/แก้ไข ผู้จัดส่ง';
	public $segment = 4;

	public function __construct()
	{
		parent::__construct();
		$this->home = base_url() . 'masters/sender';
		$this->load->model('masters/sender_model');
	}


	public function index()
	{
		$filter = array(
			'code' => get_filter('code', 'sender_code', ''),
			'active' => get_filter('active', 'sender_active', 'all'),
			'show_in_list' => get_filter('show_in_list', 'sender_show_in_list', 'all'),
			'order_by' => get_filter('order_by', 'sender_order_by', 'code'),
			'sort_by' => get_filter('sort_by', 'sender_sort_by', 'ASC')
		);

		if ($this->input->post('search'))
		{
			redirect($this->home);
		}
		else
		{
			$perpage = get_rows();
			$rows = $this->sender_model->count_rows($filter);
			$filter['data'] = $this->sender_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
			$init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
			$this->pagination->initialize($init);
			$this->load->view('masters/sender/sender_list', $filter);
		}
	}


	public function add()
	{
		$sc = TRUE;
		$res = NULL;
		$ds = json_decode(file_get_contents('php://input'));

		if ($this->pm->can_add)
		{
			if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
			{
				if ($this->sender_model->is_exists_code($ds->code))
				{
					$sc = FALSE;
					set_error('exists', $ds->code);
				}

				if ($sc === TRUE && $this->sender_model->is_exists_name($ds->name))
				{
					$sc = FALSE;
					set_error('exists', $ds->name);
				}

				if ($sc === TRUE)
				{
					$arr = array(
						'code' => $ds->code,
						'name' => $ds->name,
						'phone' => get_null($ds->phone),
						'show_in_list' => $ds->show_in_list,
						'active' => $ds->active,
						'user' => $this->_user->uname,
						'update_user' => $this->_user->uname
					);

					$id = $this->sender_model->add($arr);

					if (! $id)
					{
						$sc = FALSE;
						set_error('insert');
					}

					if ($sc === TRUE)
					{
						$res = $this->sender_model->get($id);

						if (! empty($res))
						{
							$res->is_active = is_active($res->active);
							$res->is_common = is_active($res->show_in_list);
							$res->date_upd = thai_date($res->date_upd, TRUE, '/');
						}
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
			'status' => $sc === TRUE ? 'success' : 'error',
			'message' => $sc === TRUE ? 'success' : $this->error,
			'data' => $res
		);

		echo json_encode($arr);
	}


	public function get_data()
	{
		$sc = TRUE;
		$res = NULL;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->id))
		{
			$res = $this->sender_model->get_by_id($ds->id);

			if (! empty($res))
			{
				$res->is_active = $res->active == 1 ? 'checked' : '';
				$res->is_common = $res->show_in_list == 1 ? 'checked' : '';
				$res->date_upd = thai_date($res->date_upd, TRUE, '/');
			}
			else
			{
				$sc = FALSE;
				set_error('not_found');
			}
		}
		else
		{
			$sc = FALSE;
			set_error('required');
		}

		$arr = array(
			'status' => $sc === TRUE ? 'success' : 'error',
			'message' => $sc === TRUE ? 'success' : $this->error,
			'data' => $res
		);

		echo json_encode($arr);
	}


	public function update()
	{
		$sc = TRUE;
		$res = NULL;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->id) && ! empty($ds->name))
		{
			if ($this->pm->can_edit)
			{
				if ($this->sender_model->is_exists_name($ds->name, $ds->id))
				{
					$sc = FALSE;
					set_error('exists', $ds->name);
				}

				if ($sc === TRUE)
				{
					$arr = array(
						'name' => $ds->name,
						'phone' => get_null($ds->phone),
						'show_in_list' => $ds->show_in_list,
						'active' => $ds->active,
						'update_user' => $this->_user->uname
					);

					if ($this->sender_model->update($ds->id, $arr))
					{
						$res = $this->sender_model->get($ds->id);

						if (! empty($res))
						{
							$res->is_active = is_active($res->active);
							$res->is_common = is_active($res->show_in_list, FALSE);
							$res->date_upd = thai_date($res->date_upd, TRUE, '/');
						}
					}
					else
					{
						$sc = FALSE;
						set_error('update');
					}
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
			'status' => $sc === TRUE ? 'success' : 'error',
			'message' => $sc === TRUE ? 'success' : $this->error,
			'data' => $res
		);

		echo json_encode($arr);
	}


	public function delete()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->id))
		{
			if ($this->pm->can_delete)
			{
				if($this->sender_model->has_transection($ds->id))
				{
					$sc = FALSE;
					set_error('transection');
				}

				if($sc === TRUE)
				{
					if (! $this->sender_model->delete($ds->id))
					{
						$sc = FALSE;
						set_error('delete');
					}
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

		$this->_response($sc);
	}


	public function is_exists_code()
	{
		$exists = FALSE;
		$ds = json_decode(file_get_contents('php://input'));

		if(! empty($ds) && ! empty($ds->code))
		{
			$exists = $this->sender_model->is_exists_code($ds->code, empty($ds->id) ? NULL : $ds->id);			
		}

		echo $exists ? 'exists' : 'not_exists';
	}


	public function is_exists_name()
	{
		$exists = FALSE;
		$ds = json_decode(file_get_contents('php://input'));

		if(! empty($ds) && ! empty($ds->name))
		{
			$exists = $this->sender_model->is_exists_name($ds->name, empty($ds->id) ? NULL : $ds->id);
		}

		echo $exists ? 'exists' : 'not_exists';
	}


	public function clear_filter()
	{
		return clear_filter(array(
			'sender_code',
			'sender_active',
			'sender_show_in_list',
			'sender_order_by',
			'sender_sort_by'
		));
	}
} //--- end class
