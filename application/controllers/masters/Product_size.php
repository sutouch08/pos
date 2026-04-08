<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_size extends PS_Controller
{
  public $menu_code = 'DBPDSI';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'PRODUCT';
  public $title = 'เพิ่ม/แก้ไข ไซส์';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/product_size';
    $this->load->model('masters/product_size_model');
    $this->load->helper('product_size');
  }


  public function index()
  {
    $filter = [
      'code' => get_filter('code', 'size_code', ''),
      'active' => get_filter('active', 'size_active', 'all'),
      'group_id' => get_filter('group_id', 'size_group_id', 'all'),
      'order_by' => get_filter('order_by', 'order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'sort_by', 'ASC')
    ];

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->product_size_model->count_rows($filter);
      $size = $this->product_size_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init  = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);

      $filter['data'] = $size;

      $this->pagination->initialize($init);
      $this->load->view('masters/product_size/product_size_list', $filter);
    }
  }


  public function add()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      if ($this->pm->can_add)
      {
        if ($this->product_size_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->product_size_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'position' => $ds->position > 0 ? $ds->position : 0,
            'active' => $ds->active,
            'group_id' => $ds->group_id > 0 ? $ds->group_id : NULL
          );

          if (! $this->product_size_model->add($arr))
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            $res = $this->product_size_model->get($this->db->insert_id());
            $res->is_active = is_active($res->active);
            $res->group_name = $this->product_size_model->group_name($res->group_id);
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

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? 'success' : $this->error,
      'data' => $res
    );

    echo json_encode($arr);
  }


  public function add_size_group()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));
    $group = NULL;

    if (! empty($ds) && ! empty($ds->name))
    {
      if ($this->pm->can_add)
      {
        if ($this->product_size_model->is_exists_group_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name
          );

          $id = $this->product_size_model->add_group($arr);
          if (! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            $group = $this->product_size_model->get_group($id);
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

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? 'Group added' : $this->error,
      'group' => $group
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
      if ($this->pm->can_edit)
      {
        if ($this->product_size_model->is_exists_code($ds->code, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->product_size_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $res = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'position' => $ds->position > 0 ? $ds->position : 0,
            'active' => $ds->active,
            'group_id' => $ds->group_id > 0 ? $ds->group_id : NULL,
            'member' => $this->product_size_model->count_members($ds->id)
          );

          if (! $this->product_size_model->update_by_id($ds->id, $res))
          {
            $sc = FALSE;
            set_error('update');
          }
          
          if($sc === TRUE)
          {
            $res['id'] = $ds->id;
            $res['is_active'] = is_active($res['active']);
            $res['group_name'] = $this->product_size_model->group_name($res['group_id']);
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

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? 'Saved' : $this->error,
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
        $member = $this->product_size_model->count_members($ds->id);

        if($member > 0)
        {
          $sc = FALSE;
          set_error('transections');
        }

        if($sc === TRUE)
        {
          if (! $this->product_size_model->delete_by_id($ds->id))
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

    if (! empty($ds))
    {
      if ($this->product_size_model->is_exists_code($ds->code, $ds->id))
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
      if ($this->product_size_model->is_exists_name($ds->name, $ds->id))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function is_exists_group_name()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->name))
    {
      if ($this->product_size_model->is_exists_group_name($ds->name))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function get_edit_data()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->id))
    {
      $data = $this->product_size_model->get($ds->id);
      $data->isChecked = $data->active == 1 ? 'checked' : '';
      echo json_encode($data);
    }
  }


  public function clear_filter()
  {
    $filter = array(
      'size_code',
      'size_name',
      'size_order_by',
      'size_sort_by',
      'size_active',
      'size_group_id'
    );

    return clear_filter($filter);    
  }
} //--- end class
