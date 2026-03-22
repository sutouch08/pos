<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profiles extends PS_Controller
{
  public $menu_code = 'SCPROF'; //--- Add/Edit Profile
  public $menu_group_code = 'SC'; //--- System security
  public $title = 'Profiles';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'users/profiles';
    $this->load->model('users/profile_model');
  }


  public function index()
  {
    $filter = array(
      'name' => get_filter('name', 'profile_name', '')
    );

    if($this->input->post('search'))
    {
      redirect($this->home);
    }
    else 
    {
      $perpage = get_rows();
      $rows = $this->profile_model->count_rows($filter);
      $filter['data'] = $this->profile_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);

      if( ! empty($filter['data']))
      {
        foreach($filter['data'] as $rs)
        {
          $rs->member = $this->profile_model->count_members($rs->id);
        }
      }

      $this->load->view('users/profile_list', $filter);
    }    
  }


  public function add_new()
  {
    if($this->pm->can_add)
    {
      $this->load->view('users/profile_add');
    }
    else 
    {
      $this->deny_page();
    }    
  }



  public function add()
  {
    $sc = TRUE;
    $name = trim($this->input->post('name'));   

    if(empty($name))
    {
      $sc = FALSE;
      set_error('required');
    }

    if($sc === TRUE)
    {
      if($this->profile_model->is_exists($name))
      {
        $sc = FALSE;
        set_error('exists', $name);
      }
    }

    if($sc === TRUE)
    {
      $arr = array('name' => $name);

      if( ! $this->profile_model->add($arr))
      {
        $sc = FALSE;
        set_error('insert');
      }
    }

    $this->_response($sc);
  }


  public function edit($id)
  {
    if($this->pm->can_edit)
    {
      $ds['ds'] = $this->profile_model->get($id);
      $this->load->view('users/profile_edit', $ds);
    }
    else 
    {
      $this->deny_page();
    }
  }


  public function update()
  {
    $sc = TRUE;
    $id = $this->input->post('id');
    $name = trim($this->input->post('name'));

    if(empty($id) OR empty($name))
    {
      $sc = FALSE;
      set_error('required');
    }

    if($sc === TRUE)
    {
      if($this->profile_model->is_exists($name, $id))
      {
        $sc = FALSE;
        set_error('exists', $name);
      }
    }

    if($sc === TRUE)
    {
      $arr = array('name' => $name);

      if( ! $this->profile_model->update($id, $arr))
      {
        $sc = FALSE;
        set_error('update');
      }
    }

    $this->_response($sc);
  }


  public function delete()
  {
    $sc = TRUE;
    $id = $this->input->post('id');

    if( ! $this->pm->can_delete)
    {
      $sc = FALSE;
      set_error('permission');
    }

    if($sc === TRUE)
    {
      if($this->profile_model->count_members($id) > 0)
      {
        $sc = FALSE;
        $this->error = "Delete failed : This profile has active members. Please remove them before delete it.";
      }
    }

    if($sc === TRUE)
    {
      if( ! $this->profile_model->delete($id))
      {
        $sc = FALSE;
        set_error('delete');
      }
    }

    $this->_response($sc);
  }

   public function clear_filter()
  {    
    return clear_filter(['profile_name']);
  }
}
