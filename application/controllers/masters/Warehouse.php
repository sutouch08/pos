<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Warehouse extends PS_Controller
{
  public $menu_code = 'DBWRHS';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'WAREHOUSE';
  public $title = 'เพิ่ม/แก้ไข คลังสินค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/warehouse';
    $this->load->model('masters/warehouse_model');
    $this->load->model('masters/zone_model');
    $this->load->helper('warehouse');
  }

  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'wh_code', ''),
      'name' => get_filter('name', 'wh_name', ''),
      'role' => get_filter('role', 'wh_role', 'all'),
      'active' => get_filter('active', 'wh_active', 'all'),
      'auz' => get_filter('auz', 'wh_auz', 'all'),
      'order_by' => get_filter('order_by', 'wh_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'wh_sort_by', 'ASC')
    );

    //--- แสดงผลกี่รายการต่อหน้า
    $perpage = get_rows();
    //--- หาก user กำหนดการแสดงผลมามากเกินไป จำกัดไว้แค่ 300
    if ($perpage > 300)
    {
      $perpage = 20;
    }

    $rows = $this->warehouse_model->count_rows($filter);
    $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
    $list = $this->warehouse_model->get_list($filter, $perpage, $this->uri->segment($this->segment));

    if (!empty($list))
    {
      foreach ($list as $rs)
      {
        $rs->zone_count = $this->warehouse_model->count_zone($rs->id);
      }
    }

    $filter['list'] = $list;

    $this->pagination->initialize($init);
    $this->load->view('masters/warehouse/warehouse_list', $filter);
  }


  public function add_new()
  {
    $this->title = 'เพิ่ม คลังสินค้า';
    $this->load->view('masters/warehouse/warehouse_add');
  }


  public function add()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_add)
    {
      if (!empty($ds) && !empty($ds->code) && !empty($ds->name))
      {
        if ($sc === TRUE && $this->warehouse_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->warehouse_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $this->db->trans_begin();

          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'role' => $ds->role,
            'active' => $ds->active,
            'auz' => $ds->auz,
            'create_by' => $this->_user->id
          );

          $id = $this->warehouse_model->add($arr);

          if (! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if ($sc === TRUE)
          {
            //-- create system zone for this warehouse
            $arr = array(
              'code' => $ds->code . '-SYSTEM',
              'name' => $ds->code . '-SYSTEM',
              'warehouse_id' => $id,
              'warehouse_code' => $ds->code,
              'system' => 1,
              'create_by' => $this->_user->id
            );

            if (! $this->zone_model->add($arr))
            {
              $sc = FALSE;
              $this->error = "สร้างโซนระบบไม่สำเร็จ";
            }
          }

          if ($sc === TRUE)
          {
            $this->db->trans_commit();
          }
          else
          {
            $this->db->trans_rollback();
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
      $this->title = 'แก้ไข คลังสินค้า';
      $rs = $this->warehouse_model->get($id);
      if (! empty($rs))
      {
        $this->load->view('masters/warehouse/warehouse_edit', array('data' => $rs));
      }
      else
      {
        $this->page_not_found();
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

    if ($this->pm->can_edit)
    {
      if (!empty($ds) && !empty($ds->id) && !empty($ds->name))
      {
        if ($sc === TRUE && $this->warehouse_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name,
            'role' => $ds->role,
            'active' => $ds->active,
            'auz' => $ds->auz,
            'update_by' => $this->_user->id
          );

          if (! $this->warehouse_model->update($ds->id, $arr))
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

    if ($this->pm->can_delete)
    {
      if (!empty($ds) && !empty($ds->id))
      {
        if (! $this->warehouse_model->delete($ds->id))
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


  public function restore()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if ($this->pm->can_approve)
    {
      if (!empty($ds) && !empty($ds->id))
      {
        $wh = $this->warehouse_model->get($ds->id);

        if (empty($wh))
        {
          $sc = FALSE;
          $this->error = "Warehouse not found <br> Warehouse you are trying to restore does not exist or has been deleted permanently.";
        }

        if ($sc === TRUE)
        {
          $arr = array(
            'active' => 1,
            'update_by' => $this->_user->id,
            'delete_by' => NULL,
            'delete_at' => NULL
          );

          if (! $this->warehouse_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('restore');
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
        //-- check if this warehouse has any zone
        $zone_count = $this->warehouse_model->count_zone($ds->id);
        $system_zone = $this->zone_model->get_system_zone($ds->id);

        if (($system_zone === NULL && $zone_count > 0) || ($system_zone !== NULL && $zone_count > 1))
        {
          $sc = FALSE;
          set_error('transection', '', 'ยังมีโซนที่อยู่ในคลังนี้');
        }

        //--- check system zone has transection or not
        if ($sc === TRUE && ! empty($system_zone))
        {
          if ($this->zone_model->has_transaction($system_zone->id))
          {
            $sc = FALSE;
            set_error('transection', 'system zone');
          }
        }

        //-- zone has stock or not
        if ($sc === TRUE && ! empty($system_zone))
        {
          if ($this->zone_model->has_stock($system_zone->id))
          {
            $sc = FALSE;
            set_error('delete', 'system zone', '<br>Stock in system zone must be zero');
          }
        }

        if ($sc === TRUE)
        {
          $this->db->trans_begin();

          if ($sc === TRUE)
          {
            if (! $this->zone_model->delete($system_zone->id, FALSE))
            {
              $sc = FALSE;
              set_error('delete', 'system zone');
            }
          }

          if ($sc === TRUE)
          {
            if (! $this->warehouse_model->delete($ds->id, FALSE))
            {
              $sc = FALSE;
              set_error('delete');
            }
          }
        }

        if ($sc === TRUE)
        {
          $this->db->trans_commit();
        }
        else
        {
          $this->db->trans_rollback();
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

  public function view_details($id)
  {
    $this->title = 'รายละเอียด คลังสินค้า';
    $rs = $this->warehouse_model->get($id);

    if ($rs === NULL)
    {
      $this->page_not_found();
    }
    else
    {
      $this->load->view('masters/warehouse/warehouse_detail', array('data' => $rs));
    }
  }


  public function is_exists_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->code))
    {
      $exists = $this->warehouse_model->is_exists_code($ds->code, isset($ds->id) ? $ds->id : NULL);
    }

    echo $exists ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->name))
    {
      $exists = $this->warehouse_model->is_exists_name($ds->name, isset($ds->id) ? $ds->id : NULL);
    }

    echo $exists ? 'exists' : 'not_exists';
  }


  public function clear_filter()
  {
    $filter = array('wh_code', 'wh_name', 'wh_role', 'wh_active', 'wh_auz', 'wh_order_by', 'wh_sort_by');
    clear_filter($filter);
  }
} //--- end class
