<?php
class Warehouse extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/template";
	public $title = "Warehouse";
	
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."admin/warehouse";
		$this->load->model("admin/warehouse_model");
	}
	
	public function index()
	{
		$rs = $this->warehouse_model->get_data();
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "admin/warehouse_view";
		$data['page_title'] = $this->title;
		$this->load->view($this->layout, $data);
	}
	

	
}// End class


?>