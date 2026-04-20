<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saleman extends PS_Controller
{
	public $menu_code = 'DBSALE';
	public $menu_group_code = 'DB';
	public $menu_sub_group_code = '';
	public $title = 'พนักงานขาย';
	public $segment = 4;

	public function __construct()
	{
		parent::__construct();
		$this->home = base_url() . 'masters/saleman';
		$this->load->model('masters/slp_model');
		$this->load->model('masters/employee_model');
		$this->load->helper('employee');
	}


	public function index()
	{
		$filter = array(
			'name' => get_filter('name', 'saleman_name', ''),
			'emp_id' => get_filter('emp_id', 'saleman_emp_id', 'all'),
			'active' => get_filter('active', 'saleman_active', 'all')
		);

		if ($this->input->post('search'))
		{
			redirect($this->home);
		}
		else
		{
			$perpage = get_rows();
			$rows = $this->slp_model->count_rows($filter);
			$filter['data'] = $this->slp_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
			$init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
			$this->pagination->initialize($init);
			$this->load->view('masters/saleman/saleman_list', $filter);
		}
	}


	public function add()
	{
		$sc = TRUE;
		$res = NULL;
		$ds = json_decode(file_get_contents('php://input'));

		if ($this->pm->can_add)
		{
			if (! empty($ds) && ! empty($ds->emp_id))
			{
				$emp = $this->employee_model->get($ds->emp_id);

				if (empty($emp))
				{
					$sc = FALSE;
					set_error("Employee not found");
				}
				
				if($sc === TRUE && $this->slp_model->is_exists_employee($ds->emp_id))
				{
					$sc = FALSE;
					set_error('exists', employee_name($ds->emp_id));
				}

				if ($sc === TRUE)
				{					
					$arr = array(
						'emp_id' => $ds->emp_id,
						'name' => employee_name($ds->emp_id),
						'active' => $ds->active,
						'user' => $this->_user->uname
					);					

					$id = $this->slp_model->add($arr);

					if (! $id)
					{
						$sc = FALSE;
						set_error('insert');
					}

					if ($sc === TRUE)
					{
						$res = $this->slp_model->get($id);

						if (! empty($res))
						{
							$res->is_active = is_active($res->active);
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
			$res = $this->slp_model->get($ds->id);

			if (! empty($res))
			{
				$res->isChecked = $res->active == 1 ? 'checked' : '';
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

		if ($this->pm->can_edit)
		{
			if (! empty($ds) && ! empty($ds->id) && ! empty($ds->emp_id))
			{
				$emp = $this->employee_model->get($ds->emp_id);

				if (empty($emp))
				{
					$sc = FALSE;
					set_error("Employee not found");
				}

				if ($sc === TRUE && $this->slp_model->is_exists_employee($ds->emp_id, $ds->id))
				{
					$sc = FALSE;
					set_error('exists', employee_name($ds->emp_id));
				}

				if ($sc === TRUE)
				{
					$arr = array(
						'emp_id' => $ds->emp_id,
						'name' => employee_name($ds->emp_id),
						'active' => $ds->active,
						'update_user' => $this->_user->uname
					);

					if (! $this->slp_model->update($ds->id, $arr))
					{
						$sc = FALSE;
						set_error('update');
					}

					if ($sc === TRUE)
					{
						$res = $this->slp_model->get($ds->id);

						if (! empty($res))
						{
							$res->is_active = is_active($res->active);
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


	public function delete()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->id))
		{
			if ($this->pm->can_delete)
			{
				if($this->slp_model->has_transection($ds->id))
				{
					$sc = FALSE;
					set_error('transaction');
				}

				if ($sc === TRUE)
				{
					if (! $this->slp_model->delete($ds->id))
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


	public function is_exists_employee()
	{
		$exists = FALSE;

		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds->emp_id))
		{
			$exists = $this->slp_model->is_exists_employee($ds->emp_id, $ds->id);			
		}

		echo $exists === TRUE ? 'exists' : 'not_exists';
	}


	public function clear_filter()
	{
		$filter = array(
			'saleman_emp_id',
			'saleman_name',
			'saleman_active'
		);

		return clear_filter($filter);
	}
} //--- end class
