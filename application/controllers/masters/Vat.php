<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Vat extends PS_Controller
{
	public $menu_code = 'DBVATG';
	public $menu_group_code = 'DB';
	public $menu_sub_group_code = '';
	public $title = 'เพิ่ม/แก้ไข กลุ่มภาษี';
	public $segment = 4;

	public function __construct()
	{
		parent::__construct();
		$this->home = base_url() . 'masters/vat';
		$this->load->model('masters/vat_model');
		$this->load->helper('vat');
	}


	public function index()
	{
		$filter = array(
			'code' => get_filter('code', 'vat_code', ''),
			'type' => get_filter('type', 'vat_type', 'all'),
			'active' => get_filter('active', 'vat_active', 'all')
		);

		if ($this->input->post('search'))
		{
			redirect($this->home);
		}
		else
		{
			$perpage = get_rows();
			$rows = $this->vat_model->count_rows($filter);
			$filter['data'] = $this->vat_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
			$init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
			$this->pagination->initialize($init);
			$this->load->view('masters/vat/vat_list', $filter);
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
				if ($sc === TRUE && $this->vat_model->is_exists_code($ds->code))
				{
					$sc = FALSE;
					set_error('exists', $ds->code);
				}

				if ($sc === TRUE && $this->vat_model->is_exists_name($ds->name))
				{
					$sc = FALSE;
					set_error('exists', $ds->name);
				}

				if ($sc === TRUE)
				{
					$rate = floatval($ds->rate);
					$rate = $rate < 0 ? 0 : ($rate > 100 ? 100 : $rate);

					$arr = array(
						'code' => $ds->code,
						'name' => $ds->name,
						'type' => $ds->type === 'S' ? 'S' : 'P',
						'rate' => $rate,
						'active' => $ds->active ? 1 : 0,
						'create_by' => $this->_user->id
					);

					$id = $this->vat_model->add($arr);

					if( ! $id)
					{
						$sc = FALSE;
						set_error('insert');
					}
					
					if($sc === TRUE)
					{
						$res = $this->vat_model->get_by_id($id);

						if( ! empty($res))
						{
							$res->is_active = is_active($res->active);
							$res->vatType = $ds->type === 'S' ? 'Sales' : 'Purchase';
							$res->last_modified = thai_date($res->create_at, TRUE, '/');
							$res->modified_by = display_name($res->create_by);
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
			'message' => get_error(),
			'data' => $res
		);

		echo json_encode($arr);
	}


	public function get_data()
	{
		$sc = TRUE;
		$res = NULL;
		$ds = json_decode(file_get_contents('php://input'));

		if(! empty($ds) && ! empty($ds->id))
		{
			$res = $this->vat_model->get_by_id($ds->id);

			if( ! empty($res))
			{
				$res->isChecked = $res->active == 1 ? 'checked' : '';
				$res->typeOptions = select_vat_type($res->type);
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
			'message' => get_error(),
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
			if (! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name))
			{				
				if ($sc === TRUE && $this->vat_model->is_exists_name($ds->name, $ds->id))
				{
					$sc = FALSE;
					set_error('exists', $ds->name);
				}

				if ($sc === TRUE)
				{
					$rate = floatval($ds->rate);
					$rate = $rate < 0 ? 0 : ($rate > 100 ? 100 : $rate);

					$arr = array(
						'code' => $ds->code,
						'name' => $ds->name,
						'type' => $ds->type === 'S' ? 'S' : 'P',
						'rate' => $rate,
						'active' => $ds->active ? 1 : 0,
						'update_by' => $this->_user->id
					);

					if ($this->vat_model->update_by_id($ds->id, $arr))
					{
						$res = $this->vat_model->get_by_id($ds->id);

						if( ! empty($res))
						{
							$res->is_active = is_active($res->active);
							$res->vatType = $res->type === 'S' ? 'Sales' : 'Purchase';
							$res->last_modified = thai_date($res->update_at, TRUE, '/');
							$res->modified_by = display_name($res->update_by);
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
			'message' => get_error(),
			'data' => $res
		);

		echo json_encode($arr);
	}


	public function delete()
	{
		$sc = TRUE;
		$ds = json_decode(file_get_contents('php://input'));

		if($this->pm->can_delete)
		{
			if (! empty($ds) && ! empty($ds->id))
			{
				$res = $this->vat_model->get_by_id($ds->id);

				if( ! empty($res))
				{
					if ($this->vat_model->has_transection($res->code))
					{
						$sc = FALSE;
						set_error('transection');
					}
					
					if($sc === TRUE)
					{
						if ( ! $this->vat_model->delete($ds->id))
						{
							$sc = FALSE;
							set_error('delete');
						}						
					}
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
		}
		else
		{
			$sc = FALSE;
			set_error('permission');
		}

		$this->_response($sc);
	}


	public function is_exists_code()
	{
		$exists = FALSE;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->code))
		{
			$exists = $this->vat_model->is_exists_code($ds->code, isset($ds->id) ? $ds->id : NULL);
		}

		echo $exists ? 'exists' : 'not_exists';
	}


	public function is_exists_name()
	{
		$exists = FALSE;
		$ds = json_decode(file_get_contents('php://input'));

		if (! empty($ds) && ! empty($ds->name))
		{
			$exists = $this->vat_model->is_exists_name($ds->name, isset($ds->id) ? $ds->id : NULL);
		}

		echo $exists ? 'exists' : 'not_exists';
	}


	public function clear_filter()
	{
		return clear_filter(array('vat_code', 'vat_type', 'vat_active'));
	}
}
