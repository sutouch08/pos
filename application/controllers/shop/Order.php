<?php 
	class Order extends CI_Controller
	{
	public $id_menu 	= 5;
	public $home;
	public $layout 		= "include/template";
	public $title 			= "เพิ่ม/แก้ไข รายการสินค้า";
		
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."shop/order";
		$this->load->model("admin/product_model");
		$this->load->model('shop/main_model');
		$this->load->model('shop/order_model');
		$this->load->model('shop/payment_model');
		
	}
	
	public function index()
	{	
		
	}
	
	public function editOrder($id)
	{
			
	}
	
}/// endclass
	

?>