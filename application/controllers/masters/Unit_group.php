<?php
class Unit_group extends PS_Controller
{
  public $menu_code = 'DBPUGP';
  public $menu_sub_group_code = 'PRODUCT';
  public $menu_group_code = 'DB';
  public $title = 'เพิ่ม/แก้ไข กลุ่มหน่วยนับ';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/unit_group';
    $this->load->model('masters/unit_group_model');
    $this->load->model('masters/unit_model');
    $this->load->helper('unit');
  }

  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'ug_code'),
      'baseUnit' => get_filter('baseUnit', 'ug_base_unit', 'all'),
      'order_by' => get_filter('order_by', 'ug_order_by', 'code'),
      'sort_by' => get_filter('sort_by', 'ug_sort_by', 'ASC')
    );

    if($this->input->post('search'))
    {
      redirect($this->home);
    }
    else 
    {
      $per_page = get_rows();
      $rows = $this->unit_group_model->count_rows($filter);
      $filter['data'] = $this->unit_group_model->get_list($filter, $per_page, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $per_page, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/unit_group/unit_group_list', $filter);
    }
  }


  public function add_new()
  {
    if ($this->pm->can_add)
    {
      $this->load->view('masters/unit_group/unit_group_add');
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

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name) && ! empty($ds->baseUnit))
    {
      if (! $this->unit_group_model->is_exists_code($ds->code))
      {
        $this->db->trans_begin();

        $arr = array(
          'code' => $ds->code,
          'name' => $ds->name,
          'baseUnit' => $ds->baseUnit,
        );

        $id = $this->unit_group_model->add($arr);

        if (! $id)
        {
          $sc = FALSE;
          set_error('insert');
        }

        if ($sc === TRUE && $id)
        {
          $arr = array(
            'unitGroupId' => $id,
            'unitId' => $ds->baseUnit,
            'lineNum' => 1,
            'altQty' => 1,
            'baseQty' => 1,
            'active' => 1
          );

          if (! $this->unit_group_model->add_detail($arr))
          {
            $sc = FALSE;
            set_error('insert');
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
        set_error('exists', $ds->code);
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
      $data = $this->unit_group_model->get($id);
      $details = $this->unit_group_model->get_details($id);
      $ds = array(
        'data' => $data,
        'details' => $details
      );

      $this->load->view('masters/unit_group/unit_group_edit', $ds);
    }
    else
    {
      $this->deny_page();
    }
  }


  public function add_detail()
  {
    $sc = TRUE;
    $ds = json_decode($this->input->post('data'));
    $data = [];

    if (! empty($ds) && ! empty($ds->id) && ! empty($ds->altUnit) && ! empty($ds->baseUnit) && ! empty($ds->altQty) && ! empty($ds->baseQty))
    {
      $arr = array(
        'unitGroupId' => $ds->id,
        'unitId' => $ds->altUnit,
        'lineNum' => $this->unit_group_model->get_max_line_num($ds->id) + 1,
        'altQty' => $ds->altQty,
        'baseQty' => $ds->baseQty,
        'active' => 1
      );

      $id = $this->unit_group_model->add_detail($arr);

      if (! $id)
      {
        $sc = FALSE;
        set_error('insert');
      }

      if ($sc === TRUE)
      {
        $data = $this->unit_group_model->get_detail($id);

        if (! empty($data))
        {
          $data->altUnitCode = unit_code($data->unitId);
          $data->baseUnitCode = unit_code($ds->baseUnit);
          $data->altQty = round($data->altQty, 4);
          $data->baseQty = round($data->baseQty, 4);
        }
      }
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'failed',
      'message' => $sc === TRUE ? 'success' : $this->error,
      'data' => $data
    );

    echo json_encode($arr);
  }


  public function delete_detail()
  {
    $sc = TRUE;
    $id = $this->input->post('id');

    if (! empty($id))
    {
      if (! $this->unit_group_model->delete_detail($id))
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

    $this->_response($sc);
  }


  public function update()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->id) && ! empty($ds->code) && ! empty($ds->name) && ! empty($ds->baseUnit))
    {

      $ugp = $this->unit_group_model->get($ds->id);

      if (empty($ugp))
      {
        $sc = FALSE;
        set_error('not_exists');
      }

      if ($sc === TRUE)
      {
        if ($this->unit_group_model->is_exists_code($ds->code, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }
      }

      if ($sc === TRUE)
      {
        if ($this->unit_group_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }
      }

      if ($sc === TRUE)
      {
        $this->db->trans_begin();

        $arr = array(
          'code' => $ds->code,
          'name' => $ds->name,
          'baseUnit' => $ds->baseUnit
        );

        if (! $this->unit_group_model->update($ds->id, $arr))
        {
          $sc = FALSE;
          set_error('update');
        }

        if ($sc === TRUE)
        {
          if ($ugp->baseUnit != $ds->baseUnit)
          {
            $detail = $this->unit_group_model->get_detail_first_line($ds->id);

            if (! empty($detail))
            {
              $arr = array(
                'unitId' => $ds->baseUnit,
                'altQty' => 1,
                'baseQty' => 1
              );

              if (! $this->unit_group_model->update_detail($detail->id, $arr))
              {
                $sc = FALSE;
                set_error('update');
              }
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
      if ($this->pm->can_delete)
      {
        $this->db->trans_begin();

        if (! $this->unit_group_model->delete($ds->id))
        {
          $sc = FALSE;
          set_error('delete');
        }

        if ($sc === TRUE)
        {
          if (! $this->unit_group_model->delete_details($ds->id))
          {
            $sc = FALSE;
            set_error('delete');
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


  public function view_detail($id)
  {
    $data = $this->unit_group_model->get($id);
    $details = $this->unit_group_model->get_details($id);
    $ds = array(
      'data' => $data,
      'details' => $details
    );

    $this->load->view('masters/unit_group/unit_group_view_detail', $ds);
  }

  public function is_exists_code()
  {
    $ds = json_decode(file_get_contents('php://input'));
    $id = isset($ds->id) ? get_null($ds->id) : NULL;

    if ($this->unit_group_model->is_exists_code($ds->code, $id))
    {
      echo 'exists';
    }
    else
    {
      echo 'not_exists';
    }
  }

  public function clear_filter()
  {
    return clear_filter(array('ug_code', 'ug_base_unit', 'ug_order_by', 'ug_sort_by'));
  }
} //-- End of file Unit_group.php --//
