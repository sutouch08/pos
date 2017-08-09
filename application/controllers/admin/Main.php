<?php 
class Main extends CI_Controller
{
	public $id_menu = 0;
	public $home;
	public $layout = "include/template";
	public $title = "Welcome";
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->model("admin/main_model");
		$this->home = base_url()."admin/main";
	}
	public function index()
	{	
		$data['id_menu']	= $this->id_menu;
		$data['view']			= "admin/main_view";
		$data['page_title'] 	= "Welcome";
		$this->load->view($this->layout, $data);
	}
}// End class

?>