<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_color_group extends PS_Controller
{
  public $menu_code = 'DBPCLG';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'PRODUCT';
  public $title = 'เพิ่ม/แก้ไข กลุ่มสี';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/product_color_group';
    $this->load->model('masters/product_color_group_model');
    $this->load->helper('product_color');
  }


  public function index()
  {
    $filter = [
      'name' => get_filter('name', 'color_group_name', '')
    ];

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->product_color_group_model->count_rows($filter);
      $filter['data'] = $this->product_color_group_model->get_list($filter, $perpage, $this->uri->segment($this->segment));

      if (! empty($filter['data']))
      {
        foreach ($filter['data'] as $rs)
        {
          $rs->member = $this->product_color_group_model->count_members($rs->id);
        }
      }

      $init  = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/product_color_group/product_color_group_list', $filter);
    }
  }


  public function add()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->name))
    {
      if ($this->pm->can_add)
      {
        if ($this->product_color_group_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name
          );

          $id = $this->product_color_group_model->add($arr);
          if (! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            $res = array(
              'id' => $id,
              'name' => $ds->name,
              'member' => 0
            );
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


  public function update()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));
    if (! empty($ds) && ! empty($ds->id) && ! empty($ds->name))
    {
      if ($this->pm->can_edit)
      {
        if ($this->product_color_group_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $res = array(
            'name' => $ds->name
          );

          if (! $this->product_color_group_model->update($ds->id, $res))
          {
            $sc = FALSE;
            set_error('update');
          }

          if ($sc === TRUE)
          {
            $res['id'] = $ds->id;
            $res['member'] = $this->product_color_group_model->count_members($ds->id);
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


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->id))
    {
      if ($this->pm->can_delete)
      {
        $member = $this->product_color_group_model->count_members($ds->id);

        if ($member > 0)
        {
          $sc = FALSE;
          set_error('transections');
        }

        if ($sc === TRUE)
        {
          if (! $this->product_color_group_model->delete($ds->id))
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

    if (! empty($ds))
    {
      if ($this->product_color_group_model->is_exists_name($ds->name, $ds->id))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function get_data()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->id))
    {
      $data = $this->product_color_group_model->get($ds->id);
      if (empty($data))
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
      'data' => $data
    );

    echo json_encode($arr);
  }


  public function clear_filter()
  {
    return clear_filter(['color_group_name']);
  }
} //--- end class
