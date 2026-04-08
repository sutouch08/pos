<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_brand extends PS_Controller
{
  public $menu_code = 'DBPDBR';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'PRODUCT';
  public $title = 'เพิ่ม/แก้ไข ยี่ห้อสินค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/product_brand';
    $this->load->model('masters/product_brand_model');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'product_brand_code', ''),
      'name' => get_filter('name', 'product_brand_name', ''),
      'active' => get_filter('active', 'product_brand_active', 'all'),
      'order_by' => get_filter('order_by', 'product_brand_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'product_brand_sort_by', 'ASC')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->product_brand_model->count_rows($filter);
      $filter['data'] = $this->product_brand_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/product_brand/product_brand_list', $filter);
    }
  }


  public function add_new()
  {
    if ($this->pm->can_add)
    {
      $this->load->view('masters/product_brand/product_brand_add');
    }
    else
    {
      $this->permission_page();
    }
  }


  public function add()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_add)
    {
      if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
      {
        if ($this->product_brand_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->product_brand_model->is_exists_name($ds->name))
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

          if (! $this->product_brand_model->add($arr))
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
    if ($this->pm->can_edit)
    {
      $ds = $this->product_brand_model->get($id);

      if (!empty($ds))
      {
        $this->load->view('masters/product_brand/product_brand_edit', $ds);
      }
      else
      {
        $this->page_error();
      }
    }
    else
    {
      $this->permission_page();
    }
  }


  public function update()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_edit)
    {
      if (! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name))
      {
        if ($this->product_brand_model->is_exists_code($ds->code, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->product_brand_model->is_exists_name($ds->name, $ds->id))
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
            'member' => $this->product_brand_model->count_members($ds->id)
          );

          if (! $this->product_brand_model->update($ds->id, $arr))
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

    if (! empty($ds) && ! empty($ds->id))
    {
      if ($this->pm->can_delete)
      {
        $member = $this->product_brand_model->count_members($ds->id);

        if ($member > 0)
        {
          $sc = FALSE;
          set_error('transaction');
        }

        if ($sc === TRUE)
        {
          if (! $this->product_brand_model->delete($ds->id))
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

    if( ! empty($ds->code))
    {
      if($this->product_brand_model->is_exists_code($ds->code, $ds->id))
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

    if( ! empty($ds->name))
    {
      if($this->product_brand_model->is_exists_name($ds->name, $ds->id))
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
      'product_brand_code',
      'product_brand_name',
      'product_brand_active',
      'product_brand_order_by',
      'product_brand_sort_by'
    );

    return clear_filter($filter);
  }
} //--- end class
