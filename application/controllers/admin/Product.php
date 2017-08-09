<?php
class Product extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/template";
	public $title = "เพิ่ม/แก้ไข รายการสินค้า";
	public $csv_path;
		
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."admin/product";
		$this->load->model("admin/product_model");
		$this->csv_path = "images/csv";
	}
	
	public function index()
	{	
		$search_text	= "";
		if($this->input->post("search_text") != "")
		{
			$this->session->set_userdata("search_text", $this->input->post("search_text"));
			$search_text 	= $this->input->post("search_text");
		}
		$row 						= $this->product_model->count_row($search_text);
		$config 					= paginationConfig();
		$config['base_url'] 		= $this->home."/index/";
		$config['per_page'] 	= $this->input->cookie('row') ? $this->input->cookie('row') : getConfig("PER_PAGE");
		$config['total_rows'] 	=  $row != false ? $row : 0;
		if($this->session->userdata("search_text"))
		{
			$rs 	= $this->product_model->get_search_data($this->session->userdata("search_text"), $config['per_page'], $this->uri->segment($config['uri_segment']));
			$txt 	= $this->session->userdata("search_text");
		}
		else
		{
			$rs	= $this->product_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
			$txt	= "";
		}
		$data['data'] 			= $rs;
		$data['brand']			= $this->product_model->getAllBrand();
		$data['id_menu'] 		= $this->id_menu;
		$data['view'] 			= "admin/product_view";
		$data['page_title'] 		= $this->title;
		$data['row']				= $config['per_page'];
		$data['search_text']	= $txt;
		$this->pagination->initialize($config);	
		$this->load->view($this->layout, $data);
	}
	
	public function clear_filter()
	{
		$this->session->unset_userdata("search_text");
		$this->index();	
	}
	
	
	public function import_items()
	{
		$csv	= 'user_file';
		$config = array(   // initial config for upload class
			"allowed_types" => "xls|xlsx",
			"upload_path" => $this->csv_path,
			"file_name"	=> "import_items",
			"max_size" => 5120,
			"overwrite" => TRUE
			);
			$this->load->library("upload", $config);	
			if(!$this->upload->do_upload($csv)){
				echo $this->upload->display_errors();				
			}
			else
			{
				$import	 	= 0;
				$success	= 0;
				$fail			= 0;
				$skip			= 0;
				$update		= 0; 
				$info = $this->upload->data();
				$this->load->library("excel");
				/// read file
				$excel = PHPExcel_IOFactory::load($info['full_path']);
				//get only the Cell Collection
				$cell_collection = $excel->getActiveSheet()->getCellCollection();
				//extract to a PHP readable array format
				foreach ($cell_collection as $cell) {
					$column 	= $excel->getActiveSheet()->getCell($cell)->getColumn();
					$row 		= $excel->getActiveSheet()->getCell($cell)->getRow();
					$data_value = $excel->getActiveSheet()->getCell($cell)->getValue();
					//header will/should be in row 1 only. of course this can be modified to suit your need.
					if ($row == 1) {
						$header[$row][$column] = $data_value;
					} else {
						$arr_data[$row][$column] = $data_value;
					}
				}
				foreach($arr_data as $rs)
				{
					$import++;
					$barcode = $rs['A'];
					if( $barcode == "")
					{
						$skip++;
					}
					else if( !$this->product_model->isExists($barcode) ) 
					{
						$item = array(
									"barcode" 	=> $rs['A'],
									"item_code" 	=> $rs['B'],
									"item_name" 	=> $rs['C'],
									"style" 		=> $rs['D'],
									"cost" 		=> $rs['E'],
									"price" 		=> $rs['F'],
									"id_brand"	=> $rs['G'],
									"category"	=> $rs['H']
									);
						
						$cs = $this->product_model->add_item($item);
						if($cs){ $success++; }else{ $fail++; }
					}
					else
					{
						$item = array(
									"item_code" 	=> $rs['B'],
									"item_name" 	=> $rs['C'],
									"style" 		=> $rs['D'],
									"cost" 		=> $rs['E'],
									"price" 		=> $rs['F'],
									"id_brand"	=> $rs['G'],
									"category"	=> $rs['H']
									);
						$cs = $this->product_model->update_import_item($barcode, $item);
						if($cs){ $update++; }else{ $fail++; }
					}
				}
				setInfo("นำเข้า ".$import." รายการ <br/> เพิ่มใหม่ ".$success." รายการ <br/> อัพเดต ".$update." รายการ <br/> ไม่สำเร็จ ".$fail." รายการ <br/>ข้าม(ไม่มีบาร์โค้ด) ".$skip." รายการ");
			}
			redirect($this->home);
	}	

	
	public function delete_item($id)
	{
		$rs = $this->product_model->delete_item($id);
		if($rs)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function update_item()
	{
		$sc = 'fail';
		if($this->input->post("barcode"))
		{
			$data = array(
							"barcode" 	=> $this->input->post("barcode"),
							"item_code" 	=> $this->input->post("item_code"),
							"item_name" 	=> $this->input->post("item_name"),
							"style" 		=> $this->input->post("style"),
							"category"	=> $this->input->post('category'),
							"cost" 		=> $this->input->post("cost"),
							"price" 		=> $this->input->post("price"),
							"active" 		=> $this->input->post("active"),
							"id_brand"	=> $this->input->post("id_brand")
							);
			$rs = $this->product_model->update_item($this->input->post("id"), $data);
			if($rs)
			{
				$sc = "success";	
			}
		}
		echo $sc;
	}
	
	public function add_item()
	{
		$sc = 'fail';
		if( $this->input->post("barcode") )
		{
			$rd = $this->product_model->check_barcode($this->input->post("barcode"));
			if(!$rd)
			{
				$data = array(
							"barcode" 	=> trim($this->input->post("barcode")),
							"item_code" 	=> trim($this->input->post("item_code")),
							"item_name" 	=> trim($this->input->post("item_name")),
							"style" 		=> trim($this->input->post("style")),
							"category"	=> trim($this->input->post('category')),
							"cost" 		=> $this->input->post("cost"),
							"price" 		=> $this->input->post("price"),
							"active" 		=> $this->input->post("active"),
							"id_brand"	=> $this->input->post("id_brand")
							);
				$rs = $this->product_model->add_item($data);
				if($rs)
				{
					$data['id'] = $rs;
					$data['active'] = isActived($this->input->post("active"));
					$data['brand']	= brandName($this->input->post('id_brand'));
					$sc = json_encode($data);	
				}	
			}
			else
			{
				$sc = "duplicate_barcode";	
			}
		}
		echo $sc;
	}
	
	public function get_item($id = "")
	{
		$sc = 'fail';
		$rs = $this->product_model->get_item($id);
		if($rs)
		{
			$data = array(
							"id_item" 		=> $rs->id_item,
							"barcode" 	=> $rs->barcode,
							"item_code" 	=> $rs->item_code,
							"item_name" 	=> $rs->item_name,
							"style" 		=> $rs->style,
							"category"	=> $rs->category,
							"cost" 		=> $rs->cost,
							"price" 		=> $rs->price,
							"active" 		=> $rs->active,
							"option"		=> select_brand($rs->id_brand),
							"enable"		=> $rs->active == 1 ? "btn-success" : "",
							"disable"		=> $rs->active == 0 ? "btn-danger" : "" 
							);	
			$sc = json_encode($data);
		}
		echo $sc;
	}
	

	public function valid_barcode($barcode, $id = "")
	{
		if($id != "")
		{
			$rs = $this->product_model->check_barcode(urldecode($barcode), $id);
			if(!$rs)  /// ถ้าไม่ซ้ำ
			{
				echo "ok";
			}
			else
			{
				echo "fail";
			}
		}
	}
	
}// End class


?>