<?php 
class Rule extends CI_Controller
{

public $id_menu = 6;
public $home;
public $layout = "include/template";
public $title = "เงื่อนไขโปรโมชั่น";
		
public function __construct()
{
	parent:: __construct();
	$this->home = base_url()."admin/rule";
	$this->load->model('admin/rule_model');
}

public function index()
{
	$search_text	= "";
	if($this->input->post("search_text") != "")
	{
		$this->session->set_userdata("rule_search_text", $this->input->post("search_text"));
		$search_text 	= $this->input->post("search_text");
	}
	$row 						= $this->rule_model->countRow($search_text);
	$config 					= paginationConfig();
	$config['base_url'] 		= $this->home."/index/";
	$config['per_page'] 	= $this->input->cookie('row') ? $this->input->cookie('row') : getConfig("PER_PAGE");
	$config['total_rows'] 	=  $row != false ? $row : 0;
	if($this->session->userdata("rule_search_text"))
	{
		$rs 	= $this->rule_model->getSearchData($this->session->userdata("rule_search_text"), $config['per_page'], $this->uri->segment($config['uri_segment']));
		$txt 	= $this->session->userdata("rule_search_text");
	}
	else
	{
		$rs	= $this->rule_model->getData("", $config['per_page'], $this->uri->segment($config['uri_segment']));
		$txt	= "";
	}
	$data['data'] 			= $rs;
	$data['id_menu'] 		= $this->id_menu;
	$data['view'] 			= "admin/rule_view";
	$data['page_title'] 		= $this->title;
	$data['row']				= $config['per_page'];
	$data['total_row']		= $row;
	$data['search_text']	= $txt;
	$this->pagination->initialize($config);	
	$this->load->view($this->layout, $data);
}

public function addNewRule()
{
	$data['id_menu']	= $this->id_menu;
	$data['view']			= 'admin/add_rule_view';
	$data['page_title']	= 'เพิ่มกฏใหม่';
	$this->load->view($this->layout, $data);
}


		
}// End class

?>