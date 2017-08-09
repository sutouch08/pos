<?php 
class Report extends CI_Controller
{
public $id_menu = 8;
public $home;
public $layout = "include/template";
public $title = "รายงานสรุปยอดขาย";
		
public function __construct()
{
	parent:: __construct();	
	$this->load->model("shop/report_model");
	$this->home = base_url()."shop/report";
}
		
public function index()
{	
	$data['id_menu'] 		= $this->id_menu;
	$data['view'] 			= "shop/sell_summary_view";
	$data['page_title'] 		= $this->title;
	$this->load->view($this->layout, $data);
}
public function summaryReport()
{
	if( $this->input->post('from_date') && $this->input->post('to_date') )
	{
		$from = fromDate($this->input->post('from_date'));
		$to 	= toDate($this->input->post('to_date'));
		
		$data = array(
					"from"				=> thaiDate($from, FALSE, '/'),
					"to"				=> thaiDate($to, FALSE, '/'),
					"qty"				=> number_format($this->report_model->getTotalSellQty($from, $to)),
					"amount"			=> number_format($this->report_model->getTotalSellAmount($from, $to),2),
					"cash"				=> number_format($this->report_model->getTotalSellCash($from, $to),2),
					"credit_card"	=> number_format($this->report_model->getTotalSellCard($from, $to),2)
		);
		
		echo json_encode($data);
			
	}
}




}// end class

?>