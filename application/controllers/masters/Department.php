<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Department extends PS_Controller
{
  public $menu_code = 'DBEMDP';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'EMPLOYEE';
  public $title = 'เพิ่ม/แก้ไข แผนก';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/department';
    $this->load->model('masters/department_model');
  }


  public function index()
  {
    $filter = array(
      'name' => get_filter('name', 'department_name', ''),      
      'active' => get_filter('active', 'department_active', 'all'),
      'order_by' => get_filter('order_by', 'department_order_by', 'name'),
      'sort_by' => get_filter('sort_by', 'department_sort_by', 'ASC')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->department_model->count_rows($filter);
      $filter['data'] = $this->department_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/department/department_list', $filter);
    }
  }


  public function add()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_add)
    {
      if (! empty($ds) && ! empty($ds->name))
      {        
        if ($sc === TRUE && $this->department_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(            
            'name' => $ds->name,
            'active' => $ds->active,
            'create_by' => $this->_user->id
          );

          $id = $this->department_model->add($arr);

          if (! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            $res = $this->department_model->get($id);

            if (! empty($res))
            {
              $res->is_active = is_active($res->active);
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
      $res = $this->department_model->get($ds->id);

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
      if (! empty($ds) && ! empty($ds->id) && ! empty($ds->name))
      {        
        if ($sc === TRUE && $this->department_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name,
            'active' => $ds->active,
            'update_by' => $this->_user->id
          );

          if (! $this->department_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }

          if ($sc === TRUE)
          {
            $res = $this->department_model->get($ds->id);

            if (! empty($res))
            {
              $res->is_active = is_active($res->active);
              $res->last_modified = thai_date($res->update_at, TRUE, '/');
              $res->modified_by = display_name($res->update_by);
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
        if ($this->department_model->has_transaction($ds->id))
        {
          $sc = FALSE;
          set_error('transaction');
        }

        if ($sc === TRUE)
        {
          if (! $this->department_model->delete($ds->id))
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


  public function is_exists_name()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds->name))
    {
      if ($this->department_model->is_exists_name($ds->name, $ds->id))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function clear_filter()
  {
    $filter = array(      
      'department_name',
      'department_active',
      'department_order_by',
      'department_sort_by'
    );

    return clear_filter($filter);
  }
} //--- end class
