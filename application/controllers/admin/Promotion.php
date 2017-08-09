<?php 
class Promotion extends CI_Controller
{

public $id_menu = 4;
public $home;
public $layout = "include/template";
public $title = "เพิ่ม/แก้ไข โปรโมชั่น";
public $csv_path;
		
public function __construct()
{
	parent:: __construct();
	$this->home = base_url()."admin/promotion";
	$this->load->model('admin/promotion_model');
	$this->load->model("admin/product_model");
	$this->csv_path = "images/csv";
}

public function index()
{
	$search_text	= "";
	if($this->input->post("search_text") != "")
	{
		$this->session->set_userdata("promo_search_text", $this->input->post("search_text"));
		$search_text 	= $this->input->post("search_text");
	}
	$row 						= $this->promotion_model->count_row($search_text);
	$config 					= paginationConfig();
	$config['base_url'] 		= $this->home."/index/";
	$config['per_page'] 	= $this->input->cookie('row') ? $this->input->cookie('row') : getConfig("PER_PAGE");
	$config['total_rows'] 	=  $row != false ? $row : 0;
	if($this->session->userdata("promo_search_text"))
	{
		$rs 	= $this->promotion_model->get_search_data($this->session->userdata("promo_search_text"), $config['per_page'], $this->uri->segment($config['uri_segment']));
		$txt 	= $this->session->userdata("promo_search_text");
	}
	else
	{
		$rs	= $this->promotion_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
		$txt	= "";
	}
	$data['data'] 			= $rs;
	$data['id_menu'] 		= $this->id_menu;
	$data['view'] 			= "admin/promotion_view";
	$data['page_title'] 		= $this->title;
	$data['row']				= $config['per_page'];
	$data['search_text']	= $txt;
	$this->pagination->initialize($config);	
	$this->load->view($this->layout, $data);
}

public function addPromotionItems($code)
{ 
	$search_text = '';
	if($this->input->post("search_text") != "")
	{
		$this->session->set_userdata("promo_items_search_text", $this->input->post("search_text"));
		$search_text 	= $this->input->post("search_text");
	}
	$search_text = $search_text == '' ? $this->session->userdata('promo_items_search_text') : $search_text;
	$row 						= $this->promotion_model->count_style_row($search_text);
	$config 					= paginationConfig();
	$config['base_url'] 		= $this->home."/addPromotionItems/".$code."/";
	$config['per_page'] 	= $this->input->cookie('row') ? $this->input->cookie('row') : getConfig("PER_PAGE");
	$config['total_rows'] 	=  $row != false ? $row : 0;
	$config['uri_segment']	= 5;
	if($this->session->userdata("promo_items_search_text"))
	{
		$rs 	= $this->product_model->getProductStyle($this->session->userdata("promo_items_search_text"), $config['per_page'], $this->uri->segment($config['uri_segment']));
		$txt 	= $this->session->userdata("promo_items_search_text");
	}
	else
	{
		$rs	= $this->product_model->getProductStyle("", $config['per_page'], $this->uri->segment($config['uri_segment']));
		$txt	= "";
	}
	$data['data']				= $rs;
	$data['id_menu']		= $this->id_menu;
	$data['code']			= $code;
	$data['view']				= 'admin/promotion_items_view';
	$data['page_title']		= 'เพิ่มสินค้าโปรโมชั่น';
	$data['row']				= $config['per_page'];
	$data['total_rows']		= $row;
	$data['search_text']	= $txt;
	$this->pagination->initialize($config);	
	$this->load->view($this->layout, $data);
	
}


public function applyPromotion($code)
{
	$items = $this->input->post('style');
	$id_promo = $this->promotion_model->getIdPromotionByCode($code);
	$res = TRUE;
	$this->db->trans_begin();
	foreach( $items as $item )
	{
		$rs = $this->product_model->getItemsFromStyle($item);
		if( $rs )
		{
			//print_r($rs);
			foreach( $rs as $rd )
			{
				if( !$this->promotion_model->isExists($rd->barcode, $id_promo) )
				{
					$data = array( 'barcode' => $rd->barcode, 'id_promotion' => $id_promo );
					$ds = $this->promotion_model->addPromotionItem($data);	
					if( !$ds ){ $res == FALSE; }
				}
			}
		}
	}

	if( $res === TRUE )
	{
		$this->db->trans_commit();
		echo "success";
	}
	else
	{
		$this->db->trans_rollback();
		echo "fail";
	}
}

public function add()
{
	$code 	= new_promotion_code();
	$data = array(
					'code'				=> $code,
					'promo_name' 	=> $this->input->post('name'),
					'set_price'		=> $this->input->post('price'),
					'percent'			=> $this->input->post('percent'),
					'amount'			=> $this->input->post('amount'),
					'start_date'		=> fromDate($this->input->post('start')),
					'end_date'		=> toDate($this->input->post('end')),
					'active'			=> $this->input->post('active')
					);
	$rs = $this->promotion_model->add_promotion($data);
	if( $rs )
	{
		$result = array( 
						'id'				=> $rs->id,
						'code'			=> $rs->code,
						'name' 		=> $rs->promo_name,
						'price' 		=> number_format($rs->set_price,2),
						'percent' 	=> number_format($rs->percent,2),
						'amount' 		=> number_format($rs->amount,2),
						'start'			=> thaiDate($rs->start_date),
						'end'			=> thaiDate($rs->end_date),
						'active'		=> isActived($rs->active),
						'date_upd' 	=> thaiDate($rs->date_upd)
						);
		echo json_encode($result);
	}
	else
	{
		echo 'fail';
	}
}	

public function deleteImported($id)
{
	$rs = $this->promotion_model->deleteImported($id);
	if( $rs )
	{
		echo "success";
	}
	else
	{
		echo "fail";
	}
}

public function import_items()
{
	$id_promo = $this->input->post('id_promotion');
	$csv	= 'user_file';
	$config = array(   // initial config for upload class
		"allowed_types" => "xls|xlsx",
		"upload_path" => $this->csv_path,
		"file_name"	=> "import_promotion_items",
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
			else if( !$this->promotion_model->isExists($barcode, $id_promo) ) 
			{
				$item = array(
						"barcode" 	=> $rs['A'],
						"id_promotion" => $id_promo
							);
						
				$cs = $this->promotion_model->addPromotionItem($item);
				if($cs){ $success++; }else{ $fail++; }
			}
			else
			{
				$update++;
			}
		}
		setInfo("นำเข้า ".$import." รายการ <br/> เพิ่มใหม่ ".$success." รายการ <br/> อัพเดต ".$update." รายการ <br/> ไม่สำเร็จ ".$fail." รายการ <br/>ข้าม(ไม่มีบาร์โค้ด) ".$skip." รายการ");
	}
	redirect($this->home);
}	

public function clear_filter()
{
	$this->session->unset_userdata("promo_search_text");
	$this->session->unset_userdata("promo_items_search_text");	
	echo "success";	
}

		
}// End class

?>