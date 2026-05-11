<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_type extends PS_Controller
{
  public $menu_code = 'DBJOBT';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = '';
	public $title = 'เพิ่ม/แก้ไข ประเภทงาน';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/job_type';
    $this->load->model('masters/job_type_model');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'job_type_code', ''),
      'name' => get_filter('name', 'job_type_name', ''),
      'active' => get_filter('active', 'job_type_active', 'all'),
      'order_by' => get_filter('order_by', 'job_type_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'job_type_sort_by', 'ASC')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->job_type_model->count_rows($filter);
      $filter['data'] = $this->job_type_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/job_type/job_type_list', $filter);
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
        if ($this->job_type_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->job_type_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'active' => $ds->active,
            'user' => $this->_user->uname,
            'update_user' => $this->_user->uname
          );

          $id = $this->job_type_model->add($arr);

          if (! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            $res = $this->job_type_model->get($id);

            if (! empty($res))
            {
              $res->is_active = is_active($res->active);
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
      $res = $this->job_type_model->get($ds->id);

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
      if (! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name))
      {        
        if ($sc === TRUE && $this->job_type_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(            
            'name' => $ds->name,
            'active' => $ds->active,
            'update_user' => $this->_user->uname
          );

          if (! $this->job_type_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }

          if ($sc === TRUE)
          {
            $res = $this->job_type_model->get($ds->id);

            if (! empty($res))
            {
              $res->is_active = is_active($res->active);
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


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->id))
    {
      if ($this->pm->can_delete)
      {
        $job = $this->job_type_model->get($ds->id);

        if(empty($job))
        {
          $sc = FALSE;
          set_error('not_found');
        }

        if($sc === TRUE && $this->job_type_model->has_transection($job->code))
        {
          $sc = FALSE;
          set_error('transection');
        }        

        if ($sc === TRUE)
        {
          if (! $this->job_type_model->delete($ds->id))
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

    if (! empty($ds) && ! empty($ds->code))
    {
      $exists = $this->job_type_model->is_exists_code($ds->code, $ds->id);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->name))
    {
      $exists = $this->job_type_model->is_exists_name($ds->name, $ds->id);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function clear_filter()
  {
    $filter = array(
      'job_type_code',
      'job_type_name',
      'job_type_active',
      'job_type_order_by',
      'job_type_sort_by'
    );

    return clear_filter($filter);
  }

}//--- end class
 ?>
