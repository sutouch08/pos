<?php
	class index extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
			$data['page_title'] = "Welcome";
			$this->load->view("index" ,$data);	
		}
		
		public function switch_lang($lang="")
		{
			if($lang =="" || $lang == "thai")	
			{
				$this->session->set_userdata("lang", "english");
			}else if($lang == "english"){
				$this->session->set_userdata("lang","thai");
			}else{
				$this->session->set_userdata("lang", "english");
			}
			echo "ok";
		}
	}
	
?>