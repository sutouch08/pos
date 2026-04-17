<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channels extends PS_Controller
{
  public $menu_code = 'DBCHAN';
	public $menu_group_code = 'DB';
	public $title = 'ช่องทางขาย';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'masters/channels';
    $this->load->model('masters/channels_model');
		$this->load->helper('channels');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'channels_code', ''),
      'name' => get_filter('name', 'channels_name', ''),
      'active' => get_filter('active', 'channels_active', 'all')
    );

		if($this->input->post('search'))
    {
      redirect($this->home);
    }
    else 
    {
      $perpage = get_rows();
      $rows = $this->channels_model->count_rows($filter);
      $filter['data'] = $this->channels_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home.'/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/channels/channels_list', $filter);
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
        if($this->channels_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if($sc === TRUE && $this->channels_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'active' => $ds->active,
            'user' => $this->_user->uname
          );

          $id = $this->channels_model->add($arr);

          if( ! $id)
          {
            $sc = FALSE;
            set_error('insert');
          }

          if($sc === TRUE)
          {
            $res = $this->channels_model->get($id);

            if( ! empty($res))
            {
              $res->is_active = is_active($res->active);
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


  public function update()
  {
    $sc = TRUE;
    $res = NULL;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_edit)
    {
      if( ! empty($ds) && ! empty($ds->id) && ! empty($ds->name))
      {
        if($this->channels_model->is_exists_name($ds->name, $ds->id))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if($sc === TRUE)
        {
          $arr = array(
            'name' => $ds->name,
            'active' => $ds->active,
            'update_user' => $this->_user->uname
          );

          if( ! $this->channels_model->update($ds->id, $arr))
          {
            $sc = FALSE;
            set_error('update');
          }

          if($sc === TRUE)
          {
            $res = $this->channels_model->get($ds->id);

            if( ! empty($res))
            {
              $res->is_active = is_active($res->active);
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

    if(! empty($ds) && ! empty($ds->id))
    {
      $res = $this->channels_model->get($ds->id);

      if(empty($res))
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
      'message' => get_error(),
      'data' => $res
    );

    echo json_encode($arr);
  }


  public function delete()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if($this->pm->can_delete)
    {
      if( ! empty($ds) && ! empty($ds->id))
      {
        $channels = $this->channels_model->get($ds->id);

        if( ! empty($channels))
        {
          if($this->channels_model->has_transaction($channels->code))
          {
            $sc = FALSE;
            set_error('transaction');
          }

          if($sc === TRUE)
          {
            if( ! $this->channels_model->delete($ds->id))
            {
              $sc = FALSE;
              set_error('delete');
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


  public function is_exists_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && ! empty($ds->code))
    {
      $exists = $this->channels_model->is_exists_code($ds->code, $ds->id);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if( ! empty($ds) && ! empty($ds->name))
    {
      $exists = $this->channels_model->is_exists_name($ds->name, $ds->id);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }

  public function clear_filter()
	{
		return clear_filter(array('channels_code', 'channels_name', 'channels_active'));
	}

}//--- end class
 ?>
