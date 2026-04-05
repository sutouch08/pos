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
      'active' => get_filter('active', 'unit_active', 'all')
    );

    $perpage = get_rows();
    $rows = $this->unit_model->count_rows($filter);
    $filter['data'] = $this->unit_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
    $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
    $this->pagination->initialize($init);
    $this->load->view('masters/unit/unit_list', $filter);
  }


  public function add_new()
  {
    if ($this->pm->can_add)
    {
      $this->load->view('masters/unit/unit_add');
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
        set_error('exxists', $ds->code);
      }

      if ($sc === TRUE && $this->unit_model->is_exists_name($ds->name))
      {
        $sc = FALSE;
        set_error('exxists', $ds->name);
      }

      if ($sc === TRUE)
      {
        if (! $this->unit_model->add($arr))
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

    $this->_response($sc);
  }


  public function edit($id)
  {
    if ($this->pm->can_edit)
    {
      $data = $this->unit_model->get_by_id($id);

      if (! empty($data))
      {
        $ds['unit'] = $data;
        $this->load->view('masters/unit/unit_edit', $ds);
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

    if (! empty($ds) && ! empty($ds->id))
    {
      if (! $this->unit_model->delete($ds->id))
      {
        $sc = FALSE;
        $this->error = 'ลบข้อมูลไม่สำเร็จ';
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
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds))
    {
      if ($this->unit_model->is_exists_code($ds->code))
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
    $filter = array('unit_code', 'unit_active');

    return clear_filter($filter);
  }
} //---- end class
