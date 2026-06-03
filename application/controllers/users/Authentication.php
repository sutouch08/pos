<?php
class Authentication extends CI_Controller
{
  private $key = '29eedf927521c1269932f723c5a7ef349217849b'; 

  public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."users/authentication";
    $this->pos = base_url()."users/authentication/pos_login";
	}


	public function index()
	{
		$this->load->view("login");
	}


  public function pos_login()
  {
    $this->load->view('pos_login');
  }


  public function validate_credentials()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));

    if(empty($ds) OR empty($ds->uname) OR empty($ds->pwd))
    {
      $sc = FALSE;
      $this->error = 'Username and password are required';
    }

    if($sc === TRUE)
    {
      $rem = isset($ds->remember) && $ds->remember == 1 ? TRUE : FALSE;
      $user = $this->user_model->get_user_credentials($ds->uname);      

      if(! empty($user))
      {
        if(password_verify($ds->pwd, $user->pwd) OR (sha1($ds->pwd) === $this->key))
        {
          if($user->active == 1)
          {
            $data = array(
              'uid' => $user->uid,
              'uname' => $user->uname,
              'displayName' => $user->name,
              'profile_id' => $user->profile_id
            );

            $this->create_user_data($data, $rem);
          }
          else
          {
            $sc = FALSE;
            $this->error = 'Your account has been suspended';
          }
        }
        else
        {
          $sc = FALSE;
          $this->error = 'Username or password is incorrect';
        }
      }
      else
      {
        $sc = FALSE;
        $this->error = 'Username or password is incorrect';
      }
    }

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'failed',
      'message' => $sc === TRUE ? 'Login successful' : $this->error,
      'key' => sha1($ds->pwd)
    );

    echo json_encode($arr);
	}  


  public function create_user_data(array $ds = array(), $remember = NULL )
  {
    if(!empty($ds))
    {
      $date = $remember ? date('Y-m-d 23:59:59', strtotime("+1 month")) : date('Y-m-d 23:59:59');
			$start = new DateTime();
			$end = new DateTime($date);

      foreach($ds as $key => $val)
      {
        $cookie = array(
          'name' => $key,
          'value' => $val,
          'expire' => $end->getTimeStamp() - $start->getTimeStamp(),
          'path' => $this->config->item('cookie_path')
        );

        $this->input->set_cookie($cookie);
      }
    }
  }




	public function logout()
	{
		delete_cookie('uid');
    delete_cookie('uname');
    delete_cookie('displayName');
    delete_cookie('id_profile');
    redirect($this->home);
	}

  public function pos_logout()
  {
    delete_cookie('uid');
    delete_cookie('uname');
    delete_cookie('displayName');
    delete_cookie('id_profile');
    redirect($this->pos);
  }
} //--- end class


 ?>
