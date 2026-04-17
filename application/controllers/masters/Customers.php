<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customers extends PS_Controller
{
  public $menu_code = 'DBCUST';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'CUSTOMER';
  public $title = 'เพิ่ม/แก้ไข รายชื่อลูกค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    
    $this->home = base_url() . 'masters/customers';
    $this->load->model('masters/customers_model');
    $this->load->model('masters/customer_group_model');
    $this->load->model('masters/customer_kind_model');
    $this->load->model('masters/customer_type_model');
    $this->load->model('masters/customer_class_model');
    $this->load->model('masters/customer_area_model');
    $this->load->model('masters/customer_address_model');
    $this->load->helper('customer');
    $this->load->helper('saleman');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'cu_code', ''),
      'group' => get_filter('group', 'cu_group', 'all'),
      'kind' => get_filter('kind', 'cu_kind', 'all'),
      'type' => get_filter('type', 'cu_type', 'all'),
      'grade' => get_filter('grade', 'cu_grade', 'all'),
      'area' => get_filter('area', 'cu_area', 'all'),
      'status' => get_filter('status', 'cu_status', 'all')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->customers_model->count_rows($filter);
      $filter['data'] = $this->customers_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init  = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/customers/customers_list', $filter);
    }
  }


  public function add_new()
  {
    $this->load->model('users/permission_model', 'perm');
    
    $ds = array(
      'auto_gen' => getConfig('CUSTOMER_CODE_GEN'),
      'run_digit' => getConfig('RUN_DIGIT_CUSTOMER_CODE'),
      'separator' => getConfig('CUSTOMER_CODE_SEPARATOR'),
      'isAllow' => (object) array(
        'group' => $this->perm->can_add('DBCGRT', $this->_user->id_profile), //-- customer group
        'kind' => $this->perm->can_add('DBCKND', $this->_user->id_profile), //-- customer kind
        'type' => $this->perm->can_add('DBCTYP', $this->_user->id_profile), //-- customer type
        'class' => $this->perm->can_add('DBCCLS', $this->_user->id_profile), //-- customer class
        'area' => $this->perm->can_add('DBCARE', $this->_user->id_profile)  //-- customer area
      )
    );

    $this->load->view('masters/customers/customers_add', $ds);
  }


  public function add()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      if ($this->customers_model->is_exists_code($ds->code))
      {
        $sc = FALSE;
        set_error('exists', $ds->code);
      }

      if ($sc === TRUE)
      {
        $arr = array(
          'code' => $ds->code,
          'name' => $ds->name,
          'tax_id' => $ds->taxId,
          'group_code' => get_null($ds->group),
          'class_code' => get_null($ds->grade),
          'kind_code' => get_null($ds->kind),
          'type_code' => get_null($ds->type),
          'area_code' => get_null($ds->area),
          'sale_id' => get_null($ds->saleId),
          'active' => $ds->active == 1 ? 1 : 0,
          'user' => $this->_user->uname
        );

        if (! $this->customers_model->add($arr))
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


  public function edit($id, $tab = 'infoTab')
  {
    $this->load->model('users/permission_model', 'perm');
    $customer = $this->customers_model->get_by_id($id);

    if (! empty($customer))
    {
      $ds = array(
        'ds' => $customer,
        'bill_to' => $this->customer_address_model->get_bill_to_address($customer->code),
        'ship_to' => $this->customer_address_model->get_ship_to_address($customer->code),
        'tab' => $tab,
        'isAllow' => (object) array(
          'group' => $this->perm->can_add('DBCGRT', $this->_user->id_profile), //-- customer group
          'kind' => $this->perm->can_add('DBCKND', $this->_user->id_profile), //-- customer kind
          'type' => $this->perm->can_add('DBCTYP', $this->_user->id_profile), //-- customer type
          'class' => $this->perm->can_add('DBCCLS', $this->_user->id_profile), //-- customer class
          'area' => $this->perm->can_add('DBCARE', $this->_user->id_profile)  //-- customer area
        )
      );

      $this->load->view('masters/customers/customers_edit', $ds);
    }
    else
    {
      $this->page_error();
    }
  }


  public function update()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds) && ! empty($ds->id) && ! empty($ds->name))
    {
      $arr = array(
        'name' => $ds->name,
        'tax_id' => get_null($ds->taxId),
        'group_code' => get_null($ds->group),
        'class_code' => get_null($ds->grade),
        'kind_code' => get_null($ds->kind),
        'type_code' => get_null($ds->type),
        'area_code' => get_null($ds->area),
        'sale_id' => get_null($ds->saleId),
        'active' => $ds->active == 1 ? 1 : 0,
        'update_user' => $this->_user->uname,
        'date_upd' => now()
      );

      if (! $this->customers_model->update($ds->id, $arr))
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

    $this->_response($sc);
  }


  public function view_detail($id, $tab = 'infoTab')
  {
    $customer = $this->customers_model->get_by_id($id);

    if (! empty($customer))
    {
      $ds = array(
        'ds' => $customer,
        'bill_to' => $this->customer_address_model->get_bill_to_address($customer->code),
        'ship_to' => $this->customer_address_model->get_ship_to_address($customer->code),
        'tab' => $tab
      );

      $this->load->view('masters/customers/customers_view_detail', $ds);
    }
    else
    {
      $this->page_error();
    }
  }


  public function is_exists_code()
  {
    $ds = json_decode(file_get_contents('php://input'));

    if (! empty($ds))
    {
      if ($this->customers_model->is_exists_code($ds->code))
      {
        echo 'exists';
      }
      else
      {
        echo 'not_exists';
      }
    }
  }


  public function gen_new_code()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));
    $code = NULL;

    if (! empty($ds) && ! empty($ds->prefix))
    {
      $prefix = $this->customers_model->get_prefix($ds->prefix);

      if (! empty($prefix))
      {
        $digit = intval(getConfig('RUN_DIGIT_CUSTOMER_CODE'));
        $separator = get_null(getConfig('CUSTOMER_CODE_SEPARATOR'));
        $pre = $ds->prefix . $separator;

        $code = $this->customers_model->get_max_code($pre);

        if (is_null($code))
        {
          $code = $pre . (sprintf("%0{$digit}d", '001'));
        }
        else
        {
          $running = mb_substr($code, ($digit * -1), NULL, 'UTF-8') + 1;
          $code = $pre . (sprintf('%0' . $digit . 'd', $running));
        }
      }
      else
      {
        $sc = FALSE;
        $this->error = "{$ds->prefix} Not found";
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
      'code' => $code
    );

    echo json_encode($arr);
  }


  public function add_address()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (
      ! empty($ds) && ! empty($ds->customerCode)
      && ! empty($ds->address) && ! empty($ds->addressType)
      && ! empty($ds->alias) && ! empty($ds->name)
    )
    {
      $arr = array(
        'customerCode' => $ds->customerCode,
        'addressType' => $ds->addressType,
        'alias' => $ds->alias,
        'name' => $ds->name,
        'branchCode' => get_null($ds->branchCode),
        'branchName' => get_null($ds->branchName),
        'address' => $ds->address,
        'subDistrict' => get_null($ds->subDistrict),
        'district' => get_null($ds->district),
        'province' => get_null($ds->province),
        'postcode' => get_null($ds->postcode),
        'phone' => get_null($ds->phone)
      );

      $id = $this->customer_address_model->add($arr);

      if ($id)
      {
        $arr['id'] = $id;
      }
      else
      {
        $sc = FALSE;
        set_error('insert');
      }
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }

    $res = array(
      'status' => $sc === TRUE ? 'success' : 'failed',
      'message' => $sc === TRUE ? 'success' : $this->error,
      'data' => $arr
    );

    echo json_encode($res);
  }


  public function update_address()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if (
      ! empty($ds) && ! empty($ds->id)
      && ! empty($ds->address) && ! empty($ds->alias)
      && ! empty($ds->name)
    )
    {
      $arr = array(
        'alias' => $ds->alias,
        'name' => $ds->name,
        'branchCode' => get_null($ds->branchCode),
        'branchName' => get_null($ds->branchName),
        'address' => $ds->address,
        'subDistrict' => get_null($ds->subDistrict),
        'district' => get_null($ds->district),
        'province' => get_null($ds->province),
        'postcode' => get_null($ds->postcode),
        'phone' => get_null($ds->phone)
      );

      if (! $this->customer_address_model->update($ds->id, $arr))
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

    $res = array(
      'status' => $sc === TRUE ? 'success' : 'failed',
      'message' => $sc === TRUE ? 'success' : $this->error,
      'data' => $ds
    );

    echo json_encode($res);
  }


  public function delete_address()
  {
    $sc = TRUE;
    $id = $this->input->post('id');

    if (! empty($id))
    {
      if ($this->pm->can_delete)
      {
        if (! $this->customer_address_model->delete($id))
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
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }

    $this->_response($sc);
  }


  public function delete($code)
  {
    if ($code != '')
    {
      $rs = $this->customers_model->delete($code);
      if ($rs === TRUE)
      {
        set_message('ลบข้อมูลเรียบร้อยแล้ว');
      }
      else
      {
        if ($rs['code'] === '23000/1451')
        {
          $message = "Customer alrady has transection(s)";
        }
        else
        {
          $message = "ลบข้อมูลไม่สำเร็จ";
        }
        set_error($message);
      }
    }
    else
    {
      set_error('ไม่พบข้อมูล');
    }

    redirect($this->home);
  }


  public function add_attribute()
  {
    $sc = TRUE;
    $type = $this->input->post('type');
    $name = $this->input->post('name');
    $code = $this->input->post('code');

    if (! empty($type) && ! empty($name))
    {
      $arr = array(
        'code' => $code,
        'name' => $name
      );

      switch ($type)
      {
        case 'group':
          $sc = $this->customer_group_model->add($arr);
          break;
        case 'kind':
          $sc = $this->customer_kind_model->add($arr);
          break;
        case 'type':
          $sc = $this->customer_type_model->add($arr);
          break;
        case 'class':
          $sc = $this->customer_class_model->add($arr);
          break;
        case 'area':
          $sc = $this->customer_area_model->add($arr);
          break;
      }

      if ($sc === FALSE)
      {
        set_error('insert');
      }
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }

    $this->_response($sc);
  }


  public function syncData()
  {
    $last_sync = $this->customers_model->get_last_sync_date();
    $ds = $this->customers_model->get_update_data($last_sync);
    if (!empty($ds))
    {
      foreach ($ds as $rs)
      {
        $arr = array(
          'code' => $rs->code,
          'name' => $rs->name,
          'Tax_Id' => $rs->Tax_Id,
          'DebPayAcct' => $rs->DebPayAcct,
          'CardType' => $rs->CardType,
          'GroupCode' => $rs->GroupCode,
          'cmpPrivate' => $rs->CmpPrivate,
          'GroupNum' => $rs->GroupNum,
          'sale_code' => $rs->sale_code,
          'CreditLine' => floatval($rs->CreditLine),
          'old_code' => $rs->old_code,
          'last_sync' => now()
        );

        if ($this->customers_model->is_exists($rs->code) === TRUE)
        {
          $this->customers_model->update($rs->code, $arr);
        }
        else
        {
          $this->customers_model->add($arr);
        }
      }
    }

    set_message('Sync completed');
  }



  public function syncAllData()
  {
    $last_sync = from_date('2020-01-01');
    $ds = $this->customers_model->get_update_data($last_sync);
    if (!empty($ds))
    {
      foreach ($ds as $rs)
      {
        $arr = array(
          'code' => $rs->code,
          'name' => $rs->name,
          'Tax_Id' => $rs->Tax_Id,
          'DebPayAcct' => $rs->DebPayAcct,
          'CardType' => $rs->CardType,
          'GroupCode' => $rs->GroupCode,
          'cmpPrivate' => $rs->CmpPrivate,
          'GroupNum' => $rs->GroupNum,
          'sale_code' => $rs->sale_code,
          'CreditLine' => floatval($rs->CreditLine),
          'old_code' => $rs->old_code,
          'last_sync' => now()
        );

        if ($this->customers_model->is_exists($rs->code) === TRUE)
        {
          $this->customers_model->update($rs->code, $arr);
        }
        else
        {
          $this->customers_model->add($arr);
        }
      }
    }

    set_message('Sync completed');
  }


  public function clear_filter()
  {
    $filter = array(
      'cu_code',
      'cu_status',
      'cu_group',
      'cu_kind',
      'cu_type',
      'cu_class',
      'cu_area'
    );

    return clear_filter($filter);
  }


  public function get_new_code($code)
  {
    $max = $this->customer_address_model->get_max_code($code);
    $max++;
    return $max;
  }

  public function get_ship_to_table()
  {
    $sc = TRUE;
    if ($this->input->post('customer_code'))
    {
      $code = $this->input->post('customer_code');
      if (!empty($code))
      {
        $ds = array();
        $this->load->model('address/customer_address_model');
        $adrs = $this->customer_address_model->get_ship_to_address($code);
        if (!empty($adrs))
        {
          foreach ($adrs as $rs)
          {
            $arr = array(
              'id' => $rs->id,
              'name' => $rs->name,
              'address' => $rs->address . ' ' . $rs->subDistrict . ' ' . $rs->district . ' ' . $rs->province . ' ' . $rs->postcode,
              'phone' => $rs->phone,
              'email' => $rs->email,
              'alias' => $rs->alias,
              'default' => $rs->is_default == 1 ? 1 : ''
            );
            array_push($ds, $arr);
          }
        }
        else
        {
          $sc = FALSE;
        }
      }
      else
      {
        $sc = FALSE;
      }
    }

    echo $sc === TRUE ? json_encode($ds) : 'noaddress';
  }



  public function delete_shipping_address()
  {
    $this->load->model('address/address_model');
    $id = $this->input->post('id_address');
    $rs = $this->address_model->delete_shipping_address($id);
    echo $rs === TRUE ? 'success' : 'fail';
  }
} //---
