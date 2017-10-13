<?php
class Authentication extends CI_Controller
{
	public $home;
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."authentication";
		$this->load->model("login_model");
		$this->load->model('admin/employee_model');
	}

	public function index()
	{
		$this->load->view("login");
	}

	public function validate_credentials()
	{
		if( $this->input->post('user_name') && $this->input->post('password') )
		{
			$user_name = $this->input->post('user_name');
			$password = $this->input->post('password');
			$rs = $this->login_model->validate($user_name, $password);
			if($rs === 8)
			{
				$data = array(
					"id_user"=>-1,
					"id_employee" => 0,
					"user_name"=>"super admin",
					"id_profile"=> 0
				);
				
				$this->session->set_userdata($data);
				echo 'success';
			}
			else if($rs === 'noUser' OR $rs === 'notActive')
			{
				echo $rs;
			}
			else
			{
				$ro = $this->login_model->get_profile($rs->id_user);
				$data = array(
					"id_user"			=>$rs->id_user,
					"id_employee" 	=> $rs->id_employee,
					"id_shop"			=> $this->employee_model->getShopId($rs->id_employee),
					"user_name"		=>$rs->user_name,
					"id_profile"		=>$ro->id_profile
				);
				$this->session->set_userdata($data);
				if( !$this->input->cookie('com_id') )
				{
					$ds = array(
								'name' 	=> 'com_id',
								'value'  	=> uniqid(),
								'expire' 	=> '315360000',
								'path'   	=> '/'
								);
					$this->input->set_cookie($ds);
				}
				echo 'success';
			}
		}
	}

	public function logout()
	{
		$this->session->unset_userdata("id_user");
		$this->session->unset_userdata("id_employee");
		$this->session->unset_userdata("user_name");
		$this->session->unset_userdata("id_profile");
		$this->session->unset_userdata('id_shop');
		redirect($this->home);
	}

}

?>
