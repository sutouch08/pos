<?php 
	class Return_product extends CI_Controller
	{
		public $id_menu = 7;
		public $home;
		public $layout = "include/template";
		public $title = "Return product";
		
		public function __construct()
		{
			parent:: __construct();	
			$this->load->model("shop/payment_model");
			$this->load->model('shop/main_model');
			$this->load->model('shop/return_model');
			$this->home = base_url()."shop/return_product";
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
		$data['view'] 			= "shop/return_view";
		$data['page_title'] 		= $this->title;
		$data['row']				= $config['per_page'];
		$data['bill_search']		= $txt;
		$this->pagination->initialize($config);	
		$this->load->view($this->layout, $data);
	}
	
	public function returnProduct($id)
	{
		$data['id_order'] 	= $id;
		$data['order']		= $this->main_model->get_order($id);
		$data['detail']		= $this->main_model->get_detail($id);
		$data['returned']	= $this->return_model->getReturned($id);
		$data['id_menu']	= $this->id_menu;
		$data['page_title']	= $this->title;
		$data['view']			= 'shop/return_product_view';
		$this->load->view($this->layout, $data);
	}
	
	public function getReturnedItem($id_order_detail)
	{
		$barcode = trim($this->input->post('barcode'));
		$rs = $this->return_model->getReturnedItem($id_order_detail);
		echo $rs;
	}
	
public function add_item($id_order)
{
	$barcode 	= trim($this->input->post("barcode"));
	$id_order_detail = $this->input->post("id_order_detail");
	$item			= $this->main_model->getDetailRow($id_order_detail, $barcode);
	if( $item )
	{
		$rd = $this->return_model->isExists($id_order_detail, $id_order, $barcode);
		if( $rd )
		{
			$qty = $rd->qty + 1;
			if( $qty > $item->qty)
			{
				echo "completed";
			}
			else
			{
				$data = array(
						'qty'	=> $qty,
						'total_amount' => $qty * $rd->final_price
				);
				$rs = $this->return_model->updateReturnDetail($rd->id_return_product, $data);
				if( $rs )
				{
					echo $qty;	
				}
				else
				{
					echo 'fail';
				}
			}
		}
		else
		{
			$data = array(
						'id_order_detail'	=> $id_order_detail,
						'id_order'	=> $item->id_order,
						'reference'	=> $item->reference,
						'barcode'	=> $barcode,
						'item_code'	=> $item->item_code,
						'item_name'	=> $item->item_name,
						'style'			=> $item->style,
						'qty'			=> 1,
						'cost'			=> $item->cost,
						'price'			=> $item->price,
						'discount_percent'	=> $item->discount_percent,
						'discount_amount'	=> $item->discount_amount,
						'final_price'			=> $item->final_price,
						'total_amount'		=> $item->final_price,
						'id_promotion'		=> $item->id_promotion
			);
			$rs = $this->return_model->insertReturnDetail($data);
			if( $rs )
			{
				$ds = $this->return_model->getReturnDetail($rs);
				echo $ds->qty;
			}
			else
			{
				echo 'fail';
			}
		}
	}
	else
	{
		echo 'no_item';	
	}
}
	
	public function clearFilter()
	{
		$this->session->unset_userdata("bill_search");
		echo "success";
	}
	
public function total_rows($id_order)
{
	echo returnedItems($id_order);	
}
public function total_qty($id_order)
{
	echo returnedQty($id_order);	
}

public function total_amount($id_order)
{
	echo returnedAmount($id_order);	
}
	
	}/// endclass
	

?>