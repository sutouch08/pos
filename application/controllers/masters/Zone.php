<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Zone extends PS_Controller
{
  public $menu_code = 'DBZONE';
	public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'WAREHOUSE';
	public $title = 'เพิ่ม/แก้ไข โซน';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/zone';
    $this->load->model('masters/zone_model');
    $this->load->model('masters/warehouse_model');
    $this->load->helper('zone');
    $this->load->helper('warehouse');
  }

  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'z_code', ''),
      'name' => get_filter('name', 'z_name', ''),
      'warehouse_id' => get_filter('warehouse_id', 'z_warehouse_id', 'all'),
      'active' => get_filter('active', 'z_active', 'all'),
      'fastmove' => get_filter('fastmove', 'z_fastmove', 'all'),
      'system' => get_filter('system', 'z_system', 'all'),
      'pickface' => get_filter('is_pickface', 'z_pickface', 'all'),
      'order_by' => get_filter('order_by', 'z_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'z_sort_by', 'ASC')
    );      

    if($this->input->post('search'))
    {
      redirect($this->home);
    }
    else 
    {
      $perpage = get_rows();
      $rows = $this->zone_model->count_rows($filter);
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);

      $filter['list'] = $this->zone_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $this->load->view('masters/zone/zone_list', $filter);
    }		
  }


  public function add_new()
  {
    if($this->pm->can_add)
    {
      $this->title = 'เพิ่มโซน';
      $this->load->view('masters/zone/zone_add');      
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

    if($this->pm->can_add)
    {
      if( ! empty($ds) && ! empty($ds->code) && ! empty($ds->name) && ! empty($ds->warehouse_id))
      {
        if($this->zone_model->is_exists_code(trim($ds->code)))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if($sc === TRUE && $this->zone_model->is_exists_name(trim($ds->name)))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $whs = $this->warehouse_model->get($ds->warehouse_id);

          if(empty($whs))
          {
            $sc = FALSE;
            set_error('not_found', 'Warehouse');
          }

          if($sc === TRUE)
          {
            $arr = array(
              'code' => trim($ds->code),
              'name' => trim($ds->name),
              'warehouse_id' => $ds->warehouse_id,
              'warehouse_code' => $whs->code,
              'pickface' => $ds->pickface,
              'fastmove' => $ds->fastmove,
              'active' => $ds->active,
              'create_by' => $this->_user->id
            );

            if( ! $this->zone_model->add($arr))
            {
              $sc = FALSE;
              set_error('insert');
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

    $this->_response($sc);
  }


  public function edit($id)
  {
    if($this->pm->can_edit)
    {
      $ds = $this->zone_model->get($id);

      if( ! empty($ds))
      {
        $this->title = 'แก้ไขโซน';
        $this->load->view('masters/zone/zone_edit', $ds);
      }
      else
      {
        $this->load->view('page_error');
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

    if($this->pm->can_edit)
    {
      if( ! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name) && ! empty($ds->warehouse_id))
      {
        $id = $ds->id;        

        if($sc === TRUE && $this->zone_model->is_exists_name(trim($ds->name), $id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $whs = $this->warehouse_model->get($ds->warehouse_id);

          if(empty($whs))
          {
            $sc = FALSE;
            set_error('not_found', 'Warehouse');
          }

          if($sc === TRUE)
          {
            $arr = array(
              'code' => trim($ds->code),
              'name' => trim($ds->name),
              'warehouse_id' => $ds->warehouse_id,
              'warehouse_code' => $whs->code,
              'pickface' => $ds->pickface,
              'fastmove' => $ds->fastmove,
              'active' => $ds->active,
              'update_by' => $this->_user->id
            );

            if( ! $this->zone_model->update($id, $arr))
            {
              $sc = FALSE;
              set_error('update');
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

    $this->_response($sc);
  }


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_delete)
    {
      if( ! empty($ds) && ! empty($ds->id))
      {
        $arr = array(
          'active' => -1,
          'delete_by' => $this->_user->id,
          'delete_at' => now()
        );

        if( ! $this->zone_model->update($ds->id, $arr))
        {
          $sc = FALSE;
          set_error('update');
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


  public function restore()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_approve)
    {
      if( ! empty($ds) && ! empty($ds->id))
      {
        $zone = $this->zone_model->get($ds->id);

        if(empty($zone))
        {
          $sc = FALSE;
          set_error('not_found', '', "<br> Zone your're trying to restore might be deleted permanently");
        }

        if($sc === TRUE)
        {
          $arr = array(
            'active' => 1,
            'delete_by' => NULL,
            'delete_at' => NULL,
            'update_by' => $this->_user->id
          );

          if (! $this->zone_model->update($ds->id, $arr))
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


  public function permanent_delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_delete && $this->pm->can_approve)
    {
      if (!empty($ds) && !empty($ds->id))
      {
        $zone = $this->zone_model->get($ds->id);

        if( ! empty($zone))
        {
         if($zone->system == 1)
         {
           $sc = FALSE;
           $this->error = "System zone cannot be deleted";
         }
         
         if($sc === TRUE && $this->zone_model->has_stock($ds->id))
          {
            $sc = FALSE;
            set_error('delete', 'zone', '\r Stock in zone must be zero');
          }

          if($sc === TRUE && $this->zone_model->has_transaction($ds->id))
          {
            $sc = FALSE;
            set_error('transection', 'zone');
          }

          if($sc === TRUE)
          {
            if( ! $this->zone_model->delete($ds->id))
            {
              $sc = FALSE;
              set_error('delete', 'zone');
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


  public function view_detail($id)
  {
    $this->title = 'รายละเอียดโซน';
    $ds = $this->zone_model->get($id);

    if( ! empty($ds))
    {
      $this->load->view('masters/zone/zone_detail', $ds);
    }
    else
    {
      $this->page_not_found();
    }
  }


  public function is_exists_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && ! empty($ds->code))
    {
      $exists = $this->zone_model->is_exists_code(trim($ds->code), isset($ds->id) ? $ds->id : NULL);
    }
    
    echo $exists ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && ! empty($ds->name))
    {
      $exists = $this->zone_model->is_exists_name(trim($ds->name), isset($ds->id) ? $ds->id : NULL);
    }
    
    echo $exists ? 'exists' : 'not_exists';
  }


  public function clear_filter()
  {
   $filter = array('z_code', 'z_name', 'z_warehouse_id', 'z_active', 'z_pickface', 'z_fastmove', 'z_system', 'z_order_by', 'z_sort_by');

   return clear_filter($filter);
  }

} //--- end class

