<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends PS_Controller
{
  public $menu_code = 'DBBANK';
  public $menu_sub_group_code = 'BANK';
	public $menu_group_code = 'DB';
	public $title = 'บัญชีธนาคาร';
	public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/bank';
    $this->load->model('masters/bank_model');
    $this->load->model('masters/bank_code_model');
    $this->load->helper('bank');
  }


  public function index()
  {
    $filter = array(
      'account_name' => get_filter('account_name', 'account_name', ''),
      'account_no' => get_filter('account_no', 'account_no', ''),
      'branch' => get_filter('branch', 'account_branch', ''),
      'bank_code' => get_filter('bank_code', 'account_bank', 'all'),
      'active' => get_filter('active', 'account_status', 'all')
    );

    if($this->input->get('search'))
    {
      redirect($this->home);
    }
    else 
    {      
      $perpage = get_rows();
      $rows = $this->bank_model->count_rows($filter);
      $filter['data'] = $this->bank_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/bank/bank_account_list', $filter);
    }		
  }


  public function add_new()
  {
    $this->load->view('masters/bank/bank_account_add');
  }


	public function add()
  {
    $sc = TRUE;

    if($this->pm->can_add)
    {
      $ds = json_decode(file_get_contents('php://input'));

      if( ! empty($ds) && $ds->bank_code && $ds->account_no && $ds->account_name)
      {
        $bank = $this->bank_code_model->get_by_code($ds->bank_code);

        if( ! empty($bank))
        {
          if($this->bank_model->is_exists_account_no($ds->account_no))
          {
            $sc = FALSE;
            set_error('exists', $ds->account_no);
          }

          if($sc === TRUE)
          {
            $arr = array(
              'bank_id' => $bank->id,
              'bank_code' => $bank->code,              
              'branch' => $ds->branch,
              'acc_name' => $ds->account_name,
              'acc_no' => $ds->account_no,            
              'active' => $ds->active,
              'user' => $this->_user->uname
            );

            if( ! $this->bank_model->add($arr))
            {
              $sc = FALSE;
              set_error('insert');
            }
          }          
        }
        else
        {
          $sc = FALSE;
          set_error('Please select a valid bank');
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

  
  public function update()
  {
    $sc = TRUE;

    if($this->pm->can_edit)
    {
      $ds = json_decode(file_get_contents('php://input'));

      if( ! empty($ds) && $ds->id && $ds->bank_code && $ds->account_no && $ds->account_name)
      {
        $bank = $this->bank_code_model->get_by_code($ds->bank_code);

        if( ! empty($bank))
        {
          if($this->bank_model->is_exists_account_no($ds->account_no, $ds->id))
          {
            $sc = FALSE;
            set_error('exists', $ds->account_no);
          }

          if($sc === TRUE)
          {
            $arr = array(
              'bank_id' => $bank->id,
              'bank_code' => $bank->code,              
              'branch' => $ds->branch,
              'acc_name' => $ds->account_name,
              'acc_no' => $ds->account_no,            
              'active' => $ds->active,
              'update_user' => $this->_user->uname
            );

            if( ! $this->bank_model->update($ds->id, $arr))
            {
              $sc = FALSE;
              set_error('update');
            }
          }          
        }
        else
        {
          $sc = FALSE;
          set_error('Please select a valid bank');
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
      $data = $this->bank_model->get($id);

      if( ! empty($data))
      {
        $ds['data'] = $data;
        $this->load->view('masters/bank/bank_account_edit', $ds);
      }
      else 
      {
        $this->page_error();
      }
    }
    else
    {
      $this->deny_page();
    }    
  }


  public function view_detail($id)
  {
    $data = $this->bank_model->get($id);

    if( ! empty($data))
    {
      $ds['data'] = $data;
      $this->load->view('masters/bank/bank_account_detail', $ds);
    }
    else 
    {
      $this->page_error();
    }
  }


  public function delete()
  {
    $sc = TRUE;

    if($this->pm->can_delete)
    {
      $ds = json_decode(file_get_contents('php://input'));
      
      if( ! empty($ds) && $ds->id)
      {
        if($this->bank_model->has_transection($ds->id))
        {
          $sc = FALSE;
          set_error('transection');
        }

        if($sc === TRUE)
        {
          if( ! $this->bank_model->delete($ds->id))
          {
            $sc = FALSE;
            set_error('delete');
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


  public function is_exists_account_no()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && $ds->account_no)
    {
      $exists = $this->bank_model->is_exists_account_no($ds->account_no, $ds->id);
    }

    echo $exists === TRUE ? 'exists' : 'not exists';
  }


  public function clear_filter()
  {
    $filter = array(
      'account_name', 
      'account_no', 
      'account_branch', 
      'account_bank', 
      'account_status'
    );

    return clear_filter($filter);
  }


} //---- end class
?>
