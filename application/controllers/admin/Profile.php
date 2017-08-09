<?php 
class Profile extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $title = "Profile";
	public $layout = "include/template";
	public $view = "admin/user_profile";
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->model("admin/profile_model");
		$this->home = base_url()."admin/profile";
	}
	public function index()
	{
		$rs = $this->profile_model->get_data($this->session->userdata("id_user"));
		$data['data'] = $rs;
		$data['id_menu']	= $this->id_menu;
		$data['view']			= "admin/user_profile";
		$data['page_title'] 	= "Profile";
		$this->load->view($this->layout, $data);
	}
	
	public function update_lang($lang)
	{
		$rs = $this->profile_model->update_lang($this->session->userdata("id_user"),urldecode($lang));
		if($rs)
		{
			echo "success";
		}else{
			echo "false";
		}
	}
	
}// End class

?>