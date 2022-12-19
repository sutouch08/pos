<?php
class Division extends PS_Controller
{
  public $menu_code = "DBODIV";
  public $menu_group_code = "DB";
  public $menu_sub_group_code = "EMPLOYEE";
  public $segment = 4;
  public $title = "Division";

  public function __construct()
  {
    parent::__construct();

    $this->home = base_url()."masters/division";

    $this->load->model('masters/division_model');
    $this->load->helper('department');
  }


  public function index()
  {
    $filter = array(
      'name' => get_filter('name', 'div_name', ''),
      'department' => get_filter('department', 'div_department', 'all'),
      'status' => get_filter('status', 'div_status', 'all')
    );

    //--- แสดงผลกี่รายการต่อหน้า
		$perpage = get_rows();

		$rows = $this->division_model->count_rows($filter);

		$filter['data'] = $this->division_model->get_list($filter, $perpage, $this->uri->segment($this->segment));

		//--- ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$init	= pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);

		$this->pagination->initialize($init);

    $this->load->view('masters/division/division_list', $filter);
  }


  public function get($id)
  {
    $sc = TRUE;

    $rs = $this->division_model->get($id);

    if(empty($rs))
    {
      $sc = FALSE;
      set_error('notfound');
    }

		$this->_json_response($sc, (array) $rs);
  }



  public function add()
	{
		$sc = TRUE;

		if($this->pm->can_add)
		{
			if($this->input->post())
			{
				$name = trim($this->input->post('name'));
        $department_id = $this->input->post('department_id');
        $status = $this->input->post('status') == 1 ? 1 : 0;

				if( ! $this->division_model->is_exists_name($name))
				{
					$arr = array(
            'name' => $name,
            'department_id' => $department_id,
            'status' => $status,
            'create_at' => date('Y-m-d'),
            'create_by' => $this->_user->uname
          );

          if( ! $this->division_model->add($arr))
          {
            $sc = FALSE;
            set_error('insert', $name);
          }
				}
				else
				{
					$sc = FALSE;
					set_error('exists', "Division : {$name}");
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


  public function update()
  {
    $sc = TRUE;

    if($this->pm->can_edit)
    {
      $id = $this->input->post('id');
      $name = trim($this->input->post('name'));
      $department_id = $this->input->post('department_id');
      $status = $this->input->post('status') == 1 ? 1 : 0;

      if( ! empty($id))
      {
        if( ! $this->division_model->is_exists_name($name, $id))
        {
          $arr = array(
            'name' => $name,
            'department_id' => $department_id,
            'status' => $status,
            'update_at' => date('Y-m-d'),
            'update_by' => $this->_user->uname
          );

          if( ! $this->division_model->update($id, $arr))
          {
            $sc = FALSE;
            set_error('updte', $name);
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

    return $this->_response($sc);
  }



  public function delete()
  {
    $sc = TRUE;

    if($this->pm->can_delete)
    {
      $id = $this->input->post('id');

      if( ! empty($id))
      {
        if( ! $this->division_model->delete($id))
        {
          $sc = FALSE;
          set_error('delete');
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




    public function clear_filter()
    {
      $filter = array('div_name', 'div_department', 'div_status');

      return clear_filter($filter);
    }

} //--- end controller
