<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_area extends PS_Controller
{
  public $menu_code = 'DBCARE';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'CUSTOMER';
	public $title = 'เพิ่ม/แก้ไข พื้นที่การขาย';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/customer_area';
    $this->load->model('masters/customer_area_model');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'customer_area_code', '')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->customer_area_model->count_rows($filter);
      $filter['data'] = $this->customer_area_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/customer_area/customer_area_list', $filter);
    }
  }


  public function add_new()
  {
    $this->load->view('masters/customer_area/customer_area_add');
  }


  public function is_exists_code()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds))
    {
      if ($this->customer_area_model->is_exists($ds->code, $ds->id))
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

    if (! empty($ds))
    {
      if ($this->customer_area_model->is_exists_name($ds->name, $ds->id))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function add()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      if ($this->customer_area_model->is_exists($ds->code))
      {
        $sc = FALSE;
        set_error('exists', $ds->code);
      }

      if ($sc === TRUE)
      {
        if ($this->customer_area_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }
      }

      if ($sc === TRUE)
      {
        $arr = array(
          'code' => $ds->code,
          'name' => $ds->name
        );

        if (! $this->customer_area_model->add($arr))
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
      $ds['data'] = $this->customer_area_model->get_by_id($id);
      $this->load->view('masters/customer_area/customer_area_edit', $ds);
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
      if ($sc === TRUE)
      {
        if ($this->customer_area_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }
      }

      if ($sc === TRUE)
      {
        $arr = array(
          'name' => $ds->name
        );

        if (! $this->customer_area_model->update_by_id($ds->id, $arr))
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
    $id = $this->input->post('id');

    if ($this->pm->can_delete)
    {
      if (! $this->customer_area_model->delete_by_id($id))
      {
        $sc = FALSE;
        set_error('delete');
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
    $filter = ['customer_area_code', 'customer_area_name'];
    return clear_filter($filter);
  }
}//--- end class
 ?>
