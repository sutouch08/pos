<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee extends PS_Controller
{
  public $menu_code = 'DBEMPL';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = '';
	public $title = 'เพิ่ม/แก้ไข รายชื่อพนักงาน';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/employee';
    $this->load->model('masters/employee_model');
    $this->load->helper('employee');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'emp_code', ''),
      'name' => get_filter('name', 'emp_name', ''),
      'position' => get_filter('position', 'emp_position', 'all'),
      'department' => get_filter('department', 'emp_department', 'all'),
      'status' => get_filter('status', 'emp_status', 'all'),
      'active' => get_filter('active', 'emp_active', 'all'),
      'order_by' => get_filter('order_by', 'emp_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'emp_sort_by', 'ASC')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->employee_model->count_rows($filter);
      $filter['data'] = $this->employee_model->get_list($filter, $perpage, $this->uri->segment($this->segment));      
      $init = pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/employee/employee_list', $filter);
    }
  }


  public function add_new()
  {
    if($this->pm->can_add)
    {
      $auto_gen = getConfig('EMPLOYEE_CODE_GEN');     

      $ds = array(
        'auto_gen' => $auto_gen,        
        'prefixList' => $auto_gen != 'off' ? explode(',', str_replace(' ', '', getConfig('EMPLOYEE_CODE_PREFIX'))) : array()
      );

      $this->load->view('masters/employee/employee_add', $ds);
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

    if($this->pm->can_add)
    {
      if(! empty($ds) && ! empty($ds->code) && ! empty($ds->fname) && ! empty($ds->lname))
      {        
        if($this->employee_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if($sc === TRUE && $this->employee_model->is_exists_name($ds->fname, $ds->lname))
        {
          $sc = FALSE;
          set_error('exists', $ds->fname.' '.$ds->lname);
        }

        if($sc === TRUE)
        {          
          $birthDate = empty($ds->birthDate) ? NULL : ce_date($ds->birthDate, 'Y-m-d');
          $hireDate = empty($ds->hireDate) ? NULL : ce_date($ds->hireDate, 'Y-m-d');
          $arr = array(
            'code' => $ds->code,
            'firstName' => $ds->fname,
            'lastName' => $ds->lname,
            'phone' => get_null($ds->phone),
            'email' => get_null($ds->email),
            'gender' => get_null($ds->gender),
            'birthDate' => ! $birthDate ? NULL : $birthDate,
            'hireDate' => ! $hireDate ? NULL : $hireDate,
            'status' => $ds->status,
            'active' => $ds->active,
            'position_id' => get_null($ds->position),
            'department_id' => get_null($ds->department),
            'user' => $this->_user->uname
          );

          if(! $this->employee_model->add($arr))                      
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

    $this->_response($sc);
  }


  public function edit($id)
  {
    if($this->pm->can_edit)
    {
      $data = $this->employee_model->get($id);

      if(! empty($data))
      {
        $data->birthDate = be_date($data->birthDate, 'd/m/Y');
        $data->hireDate = be_date($data->hireDate, 'd/m/Y');
       
        $this->load->view('masters/employee/employee_edit', ['emp' => $data]);
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


  public function update()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_edit)
    {
      if (! empty($ds) && ! empty($ds->id) && ! empty($ds->fname) && ! empty($ds->lname))
      {        
        if ($sc === TRUE && $this->employee_model->is_exists_name($ds->fname, $ds->lname, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->fname . ' ' . $ds->lname);
        }

        if ($sc === TRUE)
        {
          $birthDate = empty($ds->birthDate) ? NULL : ce_date($ds->birthDate, 'Y-m-d');
          $hireDate = empty($ds->hireDate) ? NULL : ce_date($ds->hireDate, 'Y-m-d');
          $arr = array(            
            'firstName' => $ds->fname,
            'lastName' => $ds->lname,
            'phone' => get_null($ds->phone),
            'email' => get_null($ds->email),
            'gender' => get_null($ds->gender),
            'birthDate' => ! $birthDate ? NULL : $birthDate,
            'hireDate' => ! $hireDate ? NULL : $hireDate,
            'status' => $ds->status,
            'active' => $ds->active,
            'position_id' => get_null($ds->position),
            'department_id' => get_null($ds->department),
            'update_user' => $this->_user->uname
          );

          if (! $this->employee_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }

          if($sc === TRUE)
          {
            $this->load->model('masters/slp_model');
            $slp = $this->slp_model->get_by_emp_id($ds->id);
            if(! empty($slp))
            {
              $arr = array(
                'name' => $ds->fname . ' ' . $ds->lname,
                'update_user' => $this->_user->uname
              );

              $this->slp_model->update($slp->id, $arr);
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

    $this->_response($sc);
  }


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));    

    if ($this->pm->can_delete)
    {
      if (! empty($ds) && ! empty($ds->id))
      {        
        if($this->employee_model->has_transection($ds->id))
        {
          $sc = FALSE;
          set_error('transection');
        }

        if($sc === TRUE)
        {
          if( ! $this->employee_model->delete($ds->id))
          {
            $sc = FALSE;
            set_error('delete');
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

    echo $sc === TRUE ? 'success' : $this->error;
  }
  

  public function is_exists_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if(! empty($ds) && ! empty($ds->code))
    {
      $exists = $this->employee_model->is_exists_code($ds->code, isset($ds->id) ? $ds->id : NULL);
    }

    echo $exists ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if(! empty($ds) && ! empty($ds->fname) && ! empty($ds->lname))
    {
      $exists = $this->employee_model->is_exists_name($ds->fname, $ds->lname, isset($ds->id) ? $ds->id : NULL);
    }

    echo $exists ? 'exists' : 'not_exists';
  }


  public function generate_code()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));
    $code = NULL;

    if (! empty($ds) && ! empty($ds->prefix))
    {
      $digit = intval(getConfig('RUN_DIGIT_CUSTOMER_CODE'));
      $pre = $ds->prefix;

      $code = $this->employee_model->get_max_code($pre);

      if (is_null($code))
      {
        $code = $pre . (sprintf("%0{$digit}d", '001'));
      }
      else
      {
        $running = mb_substr($code, ($digit * -1), NULL, 'UTF-8') + 1;
        $code = $pre . (sprintf('%0' . $digit . 'd', $running));
      }
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }
    
    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'failed',
      'message' => $sc === TRUE ? 'success' : $this->error,
      'code' => $code
    );

    echo json_encode($arr);
  }


  public function clear_filter()
  {
    $filter = array(
      'emp_code', 
      'emp_name', 
      'emp_position', 
      'emp_department', 
      'emp_status', 
      'emp_active', 
      'emp_order_by', 
      'emp_sort_by'
    );

    return clear_filter($filter);
  }
}

?>
