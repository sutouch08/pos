<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends PS_Controller
{
  public $menu_code = 'DBPUOM';
  public $menu_sub_group_code = 'PRODUCT';
  public $menu_group_code = 'DB';
  public $title = 'เพิ่ม/แก้ไข หน่วยนับ';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/unit';
    $this->load->model('masters/unit_model');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'unit_code', ''),
      'active' => get_filter('active', 'unit_active', 'all'),
      'order_by' => get_filter('order_by', 'unit_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'unit_sort_by', 'ASC')
    );

    $perpage = get_rows();
    $rows = $this->unit_model->count_rows($filter);
    $filter['data'] = $this->unit_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
    $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
    $this->pagination->initialize($init);
    $this->load->view('masters/unit/unit_list', $filter);
  }


  public function add()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name,
        'active' => $ds->active
      );

      if ($this->unit_model->is_exists_code($ds->code))
      {
        $sc = FALSE;
        set_error('exists', $ds->code);
      }

      if ($sc === TRUE && $this->unit_model->is_exists_name($ds->name))
      {
        $sc = FALSE;
        set_error('exxists', $ds->name);
      }

      if ($sc === TRUE)
      {
        $id = $this->unit_model->add($arr);

        if (! $id)
        {
          $sc = FALSE;
          set_error('insert');
        }

        if ($sc === TRUE)
        {
          $res = $this->unit_model->get($id);

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

    if(! empty($ds) && ! empty($ds->id))
    {
      $res = $this->unit_model->get($ds->id);

      if (! empty($res))
      {
        $res->isChecked = $res->active == 1 ? 'checked' : '';
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

    if (! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name))
    {
      if ($this->unit_model->is_exists_code($ds->code, $ds->id))
      {
        $sc = FALSE;
        set_error('exists', $ds->code);
      }

      if ($sc === TRUE && $this->unit_model->is_exists_name($ds->name, $ds->id))
      {
        $sc = FALSE;
        set_error('exists', $ds->name);
      }

      if ($sc === TRUE)
      {
        $arr = array(
          'code' => $ds->code,
          'name' => $ds->name,
          'active' => $ds->active
        );

        if (! $this->unit_model->update($ds->id, $arr))
        {
          $sc = FALSE;
          set_error('update');
        }

        if($sc === TRUE)
        {
          $res = $this->unit_model->get($ds->id);

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

    if($this->pm->can_delete)
    {
      if (! empty($ds) && ! empty($ds->id))
      {
        if (! $this->unit_model->delete($ds->id))
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


  public function is_exists_code()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->code))
    {
      if ($this->unit_model->is_exists_code($ds->code, $ds->id))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function is_exists_name()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->name))
    {
      if ($this->unit_model->is_exists_name($ds->name, $ds->id))
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
    $filter = array('unit_code', 'unit_active', 'unit_order_by', 'unit_sort_by');

    return clear_filter($filter);
  }
} //---- end class
