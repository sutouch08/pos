<?php 
	class Payment extends CI_Controller
	{
		public $id_menu = 5;
		public $home;
		public $layout = "include/template";
		public $title = "Order";
		
		public function __construct()
		{
			parent:: __construct();	
			$this->load->model("shop/payment_model");
			$this->home = base_url()."shop/payment";
		}
		
		public function index()
	{	
		$bill_search	= "";
		if($this->input->post("bill_search") != "")
		{
			$this->session->set_userdata("bill_search", $this->input->post("bill_search"));
			$emp_search 	= $this->input->post("bill_search");
		}
		$row 						= $this->payment_model->count_row($bill_search);
		$config 					= pagination_config();
		$config['base_url'] 		= $this->home."/index/";
		$config['per_page'] 	= $this->input->cookie('row') ? $this->input->cookie('row') : getConfig("PER_PAGE");
		$config['total_rows'] 	=  $row != false ? $row : 0;
		if($this->session->userdata("bill_search"))
		{
			$rs 	= $this->payment_model->get_search_data($this->session->userdata("bill_search"), $config['per_page'], $this->uri->segment($config['uri_segment']));
			$txt 	= $this->session->userdata("bill_search");
		}
		else
		{
			$rs	= $this->payment_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
			$txt	= "";
		}
		$data['data'] 			= $rs;
		$data['id_menu'] 		= $this->id_menu;
		$data['view'] 			= "shop/payment_view";
		$data['page_title'] 		= $this->title;
		$data['row']				= $config['per_page'];
		$data['bill_search']		= $txt;
		$this->pagination->initialize($config);	
		$this->load->view($this->layout, $data);
	}
	
	public function clearFilter()
	{
		$this->session->unset_userdata("bill_search");
		echo "success";
	}
	
	
	
	}/// endclass
	

?>