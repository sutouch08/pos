<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_methods extends PS_Controller
{
  public $menu_code = 'DBPAYM';
	public $menu_group_code = 'DB';
	public $title = 'ช่องทางการชำระเงิน';
  public $segment = 4;
  
  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/payment_methods';
    $this->load->model('masters/payment_methods_model');
    $this->load->helper('payment_method');
    $this->load->helper('bank');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'pm_code', ''),
      'name' => get_filter('name', 'pm_name', ''),
      'role' => get_filter('role', 'pm_role', 'all'),
      'has_term' => get_filter('has_term', 'pm_term', 'all'),
      'active' => get_filter('active', 'pm_active', 'all')
    );

    if($this->input->post('search'))
    {
      redirect($this->home);
    }
    else 
    {
      $perpage = get_rows();
      $rows = $this->payment_methods_model->count_rows($filter);
      $filter['data'] = $this->payment_methods_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/payment_methods/payment_methods_list', $filter);
    }				
  }


  public function add_new()
  {
    $this->load->view('masters/payment_methods/payment_methods_add');
  }

  public function add()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_add)
    {
      if( ! empty($ds) && ! empty($ds->code) && ! empty($ds->name) && $ds->role != '')
      {
        
        if($sc === TRUE && $this->payment_methods_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if($sc === TRUE && $this->payment_methods_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'has_term' => ($ds->role == 4 || $ds->role == 5) ? 1 : 0,
            'role' => $ds->role,
            'account_id' => get_null($ds->account_id),
            'active' => $ds->active,
            'user' => $this->_user->uname
          );

          $id = $this->payment_methods_model->add($arr);
          if( ! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if($sc === TRUE)          
          {
            $res = $this->payment_methods_model->get($id);

            if( ! empty($res))
            {
              $this->load->model('masters/bank_model');
              $account = $this->bank_model->get_account_detail($res->account_id);
              $res->is_active = is_active($res->active);              
              $res->has_term = is_active($res->has_term, FALSE);
              $res->account = empty($res->account_id) ? '' : (empty($account) ? 'ไม่พบข้อมูลบัญชีธนาคาร' : '# '.$account->acc_no.'<br/>'.$account->acc_name);
              $res->role_name = payment_role_name($res->role);
              $res->date_upd = thai_date($res->date_upd, TRUE, '/');
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
      'message' => get_error(),
      'data' => $res
    );

    echo json_encode($arr);
  }

  
  public function get_data()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));
    
    if( ! empty($ds) && ! empty($ds->id))
    {
      $res = $this->payment_methods_model->get($ds->id);

      if(empty($res))
      {
        $sc = FALSE;
        set_error('not_found');
      }
      else 
      {
        $res->accountDisabled = ($res->role == 2 && ! empty($res->account_id)) ? '' : 'disabled';
      }
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => get_error(),
      'data' => $res
    );

    echo json_encode($arr);
  }


  public function update()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_edit)
    {
      if( ! empty($ds) && ! empty($ds->id) && ! empty($ds->name) && $ds->role != '')
      {        
        if($sc === TRUE && $this->payment_methods_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $arr = array(            
            'name' => $ds->name,
            'has_term' => ($ds->role == 4 || $ds->role == 5) ? 1 : 0,
            'role' => $ds->role,
            'account_id' => get_null($ds->account_id),
            'active' => $ds->active,
            'date_upd' => now(),
            'update_user' => $this->_user->uname
          );

          if( ! $this->payment_methods_model->update_by_id($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }

          if($sc === TRUE)
          {
            $res = $this->payment_methods_model->get($ds->id);

            if( ! empty($res))
            {
              $this->load->model('masters/bank_model');
              $account = $this->bank_model->get_account_detail($res->account_id);
              $res->is_active = is_active($res->active);              
              $res->has_term = is_active($res->has_term, FALSE);
              $res->account = empty($res->account_id) ? '' : (empty($account) ? 'ไม่พบข้อมูลบัญชีธนาคาร' : '# '.$account->acc_no.'<br/>'.$account->acc_name);
              $res->role_name = payment_role_name($res->role);
              $res->date_upd = thai_date($res->date_upd, TRUE, '/');
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
      'message' => get_error(),
      'data' => $res
    );

    echo json_encode($arr);
  }


  public function is_exists_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if(! empty($ds) && ! empty($ds->code))
    {
      $exists = $this->payment_methods_model->is_exists_code($ds->code, $ds->id);
    }

    echo $exists ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if(! empty($ds) && ! empty($ds->name))
    {
      $exists = $this->payment_methods_model->is_exists_name($ds->name, $ds->id);
    }

    echo $exists ? 'exists' : 'not_exists';
  }


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_delete)
    {
      if( ! empty($ds) && ! empty($ds->id))
      {
        if($this->payment_methods_model->has_transaction($ds->id))
        {
          $sc = FALSE;
          set_error('has_transaction');
        }

        if($sc === TRUE && ! $this->payment_methods_model->delete($ds->id))
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



  //--- เช็คว่าการชำระเงินเป็นแบบเครดิตหรือไม่
  public function is_credit_payment($code)
  {
    //---- ตรวจสอบว่าเป็นเครดิตหรือไม่
    $rs = $this->payment_methods_model->has_term($code);
    echo $rs === TRUE ? 1 : 0;
  }


  public function clear_filter()
	{
		return clear_filter(array('pm_code', 'pm_name', 'pm_role', 'pm_term', 'pm_active'));
	}

}//--- end class
 ?>
