<?php 
	class Sell_report extends CI_Controller
	{
		public $id_menu = 6;
		public $home;
		public $layout = "include/template";
		public $title = "รายงานการขาย";
		
		public function __construct()
		{
			parent:: __construct();	
			$this->load->model("shop/report_model");
			$this->home = base_url()."shop/sell_report";
		}
		
	public function index()
	{	
		$data['id_menu'] 		= $this->id_menu;
		$data['view'] 			= "shop/sell_report_view";
		$data['page_title'] 		= $this->title;
		$this->load->view($this->layout, $data);
	}
	
	public function get_report()
	{
		if($this->input->post("from_date") && $this->input->post('to_date') )
		{
			$from = fromDate($this->input->post('from_date'));
			$to 	= toDate($this->input->post("to_date"));
			$rs = $this->report_model->get_sell_data($from, $to);
			if($rs)
			{
				$total_dis = 0;
				$total_qty = 0;
				$total_amount = 0;
				$data = array();
				foreach($rs as $ra)
				{
					$arr = array(
								"reference" => $ra->reference,
								"item_code" => $ra->item_code,
								"price" => number_format($ra->price,2),
								"discount" => number_format($ra->total_discount,2),
								"qty" => number_format($ra->qty),
								"total_amount" => number_format($ra->total_amount,2),
								"pay_by"		=> paymentMethod($ra->id_order),
								"date_upd" => thaiDate($ra->date_upd, true),
								"style"			=> $ra->style,
								"brand"		=> brandName(getIdBrandByBarcode($ra->barcode)),
								"emp"			=> employee_name(empIdByOrder($ra->id_order))
								);
					array_push($data, $arr);		
					$total_qty += $ra->qty; $total_dis += $ra->total_discount; $total_amount += $ra->total_amount;						
				}
				$arr = array(
								"discount" => number_format($total_dis,2),
								"qty" => number_format($total_qty),
								"total_amount" => number_format($total_amount,2)
								);
				array_push($data, $arr);		
				echo json_encode($data);
			}
			else
			{
				echo "fail";
			}
		}
	}
	
	public function export_report()
	{
		if($this->input->post("from_date"))
		{
			$from = fromDate($this->input->post('from_date'));
			$to 	= toDate($this->input->post("to_date"));
			$rs = $this->report_model->get_sell_data($from, $to);
			if($rs)
			{
				$data = array();
				$arr = array("รายงานการขาย วันที่ ".thaiDate($from)." ถึง ".thaiDate($to));
				array_push($data, $arr);
				$arr = array("เลขที่เอกสาร", "รหัสสินค้า", "ราคา", "ส่วนลด", "จำนวน", "มูลค่า", "การชำระ", "วันที่", "รุ่น", "กลุ่ม", "พนักงาน");
				array_push($data, $arr);
				foreach($rs as $ra)
				{
					$arr = array($ra->reference, $ra->item_code, $ra->price, $ra->total_discount, $ra->qty, $ra->total_amount, paymentMethod($ra->id_order), $ra->date_upd, $ra->style, brandName(getIdBrandByBarcode($ra->barcode)), employee_name(empIdByOrder($ra->id_order)) );
					array_push($data, $arr);								
				}
			}
			$this->load->library('export');
			$this->export->addArray($data);
			$this->export->excel("sell_report");
		}
		else
		{
			setError("ไม่มีข้อมูล");
			redirect($this->home);
		}
	}
	public function clear_filter()
	{
		$this->session->unset_userdata("bill_search");
		$this->index();	
	}
	
	
	
	}/// endclass
	

?>