<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_category extends PS_Controller
{
  public $menu_code = 'DBPDCR';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'PRODUCT';
	public $title = 'เพิ่ม/แก้ไข หมวดหมู่สินค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/product_category';
    $this->load->model('masters/product_category_model');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'product_category_code', ''),
      'name' => get_filter('name', 'product_category_name', ''),
      'active' => get_filter('active', 'product_category_active', 'all'),
      'order_by' => get_filter('order_by', 'product_category_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'product_category_sort_by', 'ASC')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->product_category_model->count_rows($filter);
      $filter['data'] = $this->product_category_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/product_category/product_category_list', $filter);
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
        if ($this->product_category_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->product_category_model->is_exists_name($ds->name))
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

          $id = $this->product_category_model->add($arr);

          if (! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            $res = $this->product_category_model->get($id);

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
      $res = $this->product_category_model->get($ds->id);

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
        if ($this->product_category_model->is_exists_code($ds->code, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->product_category_model->is_exists_name($ds->name, $ds->id))
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
            'member' => $this->product_category_model->count_members($ds->id)
          );

          if (! $this->product_category_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }

          if ($sc === TRUE)
          {
            $res = $this->product_category_model->get($ds->id);

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
        $member = $this->product_category_model->count_members($ds->id);

        if ($member > 0)
        {
          $sc = FALSE;
          set_error('transaction');
        }

        if ($sc === TRUE)
        {
          if (! $this->product_category_model->delete($ds->id))
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
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds->code))
    {
      if ($this->product_category_model->is_exists_code($ds->code, $ds->id))
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

    if (! empty($ds->name))
    {
      if ($this->product_category_model->is_exists_name($ds->name, $ds->id))
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
      'product_category_code',
      'product_category_name',
      'product_category_active',
      'product_category_order_by',
      'product_category_sort_by'
    );

    return clear_filter($filter);
  }

}//--- end class
 ?>
