<?php
class Department extends PS_Controller
{
  public $menu_code = "DBODEP";
  public $menu_group_code = "DB";
  public $menu_sub_group_code = "EMPLOYEE";
  public $segment = 4;
  public $title = "Department";

  public function __construct()
  {
    parent::__construct();

    $this->home = base_url()."masters/department";

    $this->load->model('masters/department_model');
  }


  public function index()
  {
    $filter = array(
      'name' => get_filter('name', 'dep_name', ''),
      'status' => get_filter('status', 'dep_status', 'all')
    );

    //--- แสดงผลกี่รายการต่อหน้า
		$perpage = get_rows();

		$rows = $this->department_model->count_rows($filter);

		$filter['data'] = $this->department_model->get_list($filter, $perpage, $this->uri->segment($this->segment));

		//--- ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$init	= pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);

		$this->pagination->initialize($init);

    $this->load->view('masters/department/department_list', $filter);
  }


  public function get($id)
  {
    $sc = TRUE;

    $rs = $this->department_model->get($id);

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
        $status = $this->input->post('status') == 1 ? 1 : 0;

				if( ! $this->department_model->is_exists_name($name))
				{
					$arr = array(
            'name' => $name,
            'status' => $status,
            'create_at' => date('Y-m-d'),
            'create_by' => $this->_user->uname
          );

          if( ! $this->department_model->add($arr))
          {
            $sc = FALSE;
            set_error('insert', $name);
          }
				}
				else
				{
					$sc = FALSE;
					set_error('exists', "Department : {$name}");
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
      $status = $this->input->post('status') == 1 ? 1 : 0;

      if( ! empty($id))
      {
        if( ! $this->department_model->is_exists_name($name, $id))
        {
          $arr = array(
            'name' => $name,
            'status' => $status,
            'update_at' => date('Y-m-d'),
            'update_by' => $this->_user->uname
          );

          if( ! $this->department_model->update($id, $arr))
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
        if( ! $this->department_model->delete($id))
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
      $filter = array('dep_name', 'dep_status');

      return clear_filter($filter);
    }

} //--- end controller
