<?php
class Barcode extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/template";
	public $title = "พิมพ์บาร์โค้ด";
	public $csv_path;
		
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."admin/barcode";
		$this->csv_path = "images/csv";
	}
	
	public function index()
	{	
		$data['id_menu'] 		= $this->id_menu;
		$data['view'] 			= "admin/barcode_view";
		$data['page_title'] 		= $this->title;
		$this->load->view($this->layout, $data);
	}
	
	public function print_barcode()
	{
		$this->load->library("printer");
		$this->load->library("csvreader");
		$data['data'] = $this->csvreader->parse_file(base_url()."images/csv/barcode_items.csv");
		$this->load->view("admin/print_barcode", $data);	
	}
		
	public function import_items()
	{
		$csv	= 'user_file';
		$config = array(   // initial config for upload class
			"allowed_types" => "csv",
			"upload_path" => $this->csv_path,
			"file_name"	=> "barcode_items",
			"max_size" => 5120,
			"overwrite" => TRUE
			);
			$this->load->library("upload", $config);	
			if(!$this->upload->do_upload($csv)){
				echo $this->upload->display_errors();				
			}
			else
			{
				$info = $this->upload->data();	
			}
			redirect($this->home);
	}
	
	
}// End class


?>