<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_class extends PS_Controller
{
  public $menu_code = 'DBCLAS';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'CUSTOMER';
	public $title = 'เพิ่ม/แก้ไข เกรดลูกค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/customer_class';
    $this->load->model('masters/customer_class_model');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'customer_class_code', '')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->customer_class_model->count_rows($filter);
      $filter['data'] = $this->customer_class_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/customer_class/customer_class_list', $filter);
    }
  }


  public function is_exists_code()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds))
    {
      if ($this->customer_class_model->is_exists_code($ds->code, $ds->id))
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
      if ($this->customer_class_model->is_exists_name($ds->name, $ds->id))
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
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_add)
    {
      if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
      {
        if ($this->customer_class_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE)
        {
          if ($this->customer_class_model->is_exists_name($ds->name))
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

          if (! $this->customer_class_model->add($arr))
          {
            $sc = FALSE;
            set_error('insert');
          }
        }

        if ($sc === TRUE)
        {
          $res = $this->customer_class_model->get_by_code($ds->code);

          if (! empty($res))
          {
            $res->date_update = thai_date($res->date_upd, TRUE, '/');
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
      'message' => $sc === TRUE ? 'success' : get_error(),
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
      $res = $this->customer_class_model->get_by_id($ds->id);

      if (empty($res))
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
      'message' => $sc === TRUE ? 'success' : get_error(),
      'data' => $res
    );

    echo json_encode($arr);
  }


  public function update()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_edit)
    {
      if (! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name))
      {
        if ($this->customer_class_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name
          );

          if (! $this->customer_class_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }
        }

        if ($sc === TRUE)
        {
          $res = $this->customer_class_model->get_by_id($ds->id);

          if (! empty($res))
          {
            $res->date_update = thai_date($res->date_upd, TRUE, '/');
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
      'message' => $sc === TRUE ? 'success' : get_error(),
      'data' => $res
    );

    echo json_encode($arr);
  }


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_delete)
    {
      if (! empty($ds) && ! empty($ds->id))
      {
        $item = $this->customer_class_model->get_by_id($ds->id);

        if (! empty($item))
        {
          if ($this->customer_class_model->count_members($ds->id) > 0)
          {
            $sc = FALSE;
            set_error('transaction');
          }

          if ($sc === TRUE)
          {
            if (! $this->customer_class_model->delete($ds->id))
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


  public function clear_filter()
  {
    $filter = ['customer_class_code', 'customer_class_name'];
    return clear_filter($filter);
  }

}//--- end class
 ?>
