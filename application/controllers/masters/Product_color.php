<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_color extends PS_Controller
{
  public $menu_code = 'DBPDCL';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'PRODUCT';
	public $title = 'เพิ่ม/แก้ไข สีสินค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/product_color';
    $this->load->model('masters/product_color_model');
    $this->load->helper('product_color');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'color_code', ''),
      'name' => get_filter('name', 'color_name', ''),
      'group' => get_filter('group', 'color_group', 'all'),
      'active' => get_filter('active', 'color_active', 'all'),
      'order_by' => get_filter('order_by', 'color_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'color_sort_by', 'ASC')
    );

    if($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();     
      $rows = $this->product_color_model->count_rows($filter);      
      $filter['data'] = $this->product_color_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init	= pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);      
      $this->pagination->initialize($init);
      $this->load->view('masters/product_color/product_color_list', $filter);
    }
  }


  public function add()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_add)
    {
      if( ! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
      {        
        if($this->product_color_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if($sc === TRUE && $this->product_color_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'group_id' => $ds->group_id,
            'active' => $ds->active
          );

          $id = $this->product_color_model->add($arr);
          if( ! $id)
          {            
            $sc = FALSE;
            set_error('insert');
          }

          if($sc === TRUE)
          {
            $res = $this->product_color_model->get($id);

            if ( ! empty($res))
            {
              $res->group_name = $this->product_color_model->get_group_name($res->group_id);
              $res->member = $this->product_color_model->count_members($id);
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


  public function add_color_group()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));
    $group = NULL;

    if($this->pm->can_add)
    {
      if( ! empty($ds) && ! empty($ds->name))
      {
        if($this->product_color_model->is_exists_group_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name
          );

          $id = $this->product_color_model->add_group($arr);

          if($id)
          {
            $group = $this->product_color_model->get_group($id);
          }
          else
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

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? 'success' : $this->error,
      'group' => $group
    );

    echo json_encode($arr);
  }


  public function get_data()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));
    $data = NULL;

    if( ! empty($ds) && ! empty($ds->id))
    {
      $data = $this->product_color_model->get($ds->id);
      
      if( ! empty($data))
      {
        $data->isChecked = $data->active == 1 ? 'checked' : '';        
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
      'data' => $data
    );

    echo json_encode($arr);
  }
  

  public function update()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name))
    {
      if($this->pm->can_edit)
      {
        $color = $this->product_color_model->get_by_id($ds->id);

        if( ! empty($color))
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'group_id' => $ds->group_id,
            'active' => $ds->active,
            'member' => $this->product_color_model->count_members($ds->id)
          );

          if($this->product_color_model->is_exists_code($ds->code, $ds->id))
          {
            $sc = FALSE;
            set_error('exists', $ds->code);
          }

          if($sc === TRUE && $this->product_color_model->is_exists_name($ds->name, $ds->id))
          {
            $sc = FALSE;
            set_error('exists', $ds->name);
          }

          if($sc === TRUE)
          {
            if( ! $this->product_color_model->update($ds->id, $arr))
            {
              $sc = FALSE;
              set_error('update');
            }

            if($sc === TRUE)
            {
              $res = $this->product_color_model->get($ds->id);
              $res->group_name = $this->product_color_model->get_group_name($res->group_id);
              $res->is_active = is_active($res->active);
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

    if( ! empty($ds) && ! empty($ds->id))
    {
      if($this->pm->can_delete)
      {
        $member = $this->product_color_model->count_members($ds->id);

        if($member > 0)
        {
          $sc = FALSE;
          set_error('transections');
        }

        if($sc === TRUE)
        {
          if( ! $this->product_color_model->delete_by_id($ds->id))
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

    if( ! empty($ds) && isset($ds->code))
    {
      if($this->product_color_model->is_exists_code($ds->code, $ds->id))
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

    if( ! empty($ds) && isset($ds->name))
    {
      if($this->product_color_model->is_exists_name($ds->name, $ds->id))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function is_exists_color_group()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && isset($ds->name))
    {
      if($this->product_color_model->is_exists_group_name($ds->name))
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
      'color_code',
      'color_name',
      'color_group',
      'color_active',
      'color_order_by',
      'color_sort_by'
    );

    return clear_filter($filter);
	}

}//--- end class
 ?>
