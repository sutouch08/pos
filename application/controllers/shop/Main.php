<?php 
	class Main extends CI_Controller
	{
		public $id_menu = 4;
		public $home;
		public $layout = "include/template";
		public $title = "POS";
		
		public function __construct()
		{
			parent:: __construct();	
			$this->load->model("shop/main_model");
			$this->home = base_url()."shop/main";
			$this->load->model("admin/promotion_model");
		}
		
		public function index()
		{
			$rs = $this->main_model->check_open_order(id_employee());
			if($rs)
			{
				$rd 				= $rs[0];
				$data['detail']	= $this->main_model->get_detail($rd->id_order);
				$data['order']	= $rs;
				
			}
			else
			{
				$data['reference'] = new_reference();	
				$data['id_employee'] = id_employee();
				$rs = $this->main_model->new_order($data);
				if($rs)
				{
					$rs = $this->main_model->get_data($rs);
					$data['order'] = $rs;
				}
			}
							
			$data['id_menu'] 		= $this->id_menu;
			$data['view'] 			= "shop/main_view";
			$data['page_title'] 		= $this->title;
			$this->load->view($this->layout, $data);	
		}
		
		public function sell($id_order)
		{
			$data['order']		= $this->main_model->get_data($id_order);
			$data['detail']		= $this->main_model->get_detail($id_order);
			$data['id_menu'] 	= $this->id_menu;
			$data['view'] 		= "shop/main_view";
			$data['page_title'] 	= $this->title;
			$this->load->view($this->layout, $data);		
		}
		
		
public function add_item($id_order)
{
	if($this->input->post("barcode"))
	{
		
		$reference 		= $this->main_model->get_reference($id_order);
		$barcode 		= trim($this->input->post("barcode"));
		$a_dis 			= trim($this->input->post("discount_amount"));
		$p_dis			= trim($this->input->post("discount_percent"));
		$qty 				= trim($this->input->post("qty"));
		$item	 			= $this->main_model->get_item($barcode);
		
		if( $item )// $item
		{
			///  กรณีมีการให้ส่วนลดโดยคนขายเองที่หน้าจอ
			if( $p_dis != 0 || $a_dis != 0) 
			{
				$id_promo = 0;
				$de = $this->main_model->isExistsDetail($id_order, $barcode, $p_dis, $a_dis, $id_promo);  //// ถ้ามีรายการอยู่แล้ว จะได้ข้อมูลแถวนั้นกลับมา ถ้าไม่มีจะได้ค่า false;
				if($de)
				{
					$qty = $qty + $de->qty;
					$price = $de->final_price;
					$discount = $de->discount_percent > 0 ? $price * ($de->discount_percent * 0.01) : $de->discount_amount;
					$total_discount = $qty * $discount;
					$total_amount = $qty * $price;
					
					$data = array("qty" => $qty, "total_discount" => $total_discount, "total_amount" => $total_amount);
					$rd = $this->main_model->update_detail($de->id_order_detail, $data);
					if( $rd )
					{
						$ds = $this->main_model->getDetailRow($de->id_order_detail, $barcode);
							$data = '<td align="center"><span class="no"></span></td>
										<td>'.$barcode.'</td>
										<td>'.$ds->item_code.'</td>
										<td>'.$ds->item_name.'</td>
										<td align="center" class="qty">'.number_format($ds->qty).'</td>
										<td align="center">'.number_format($dx->price,2).'</td>
										<td align="center">'. discount($ds->discount_percent, $ds->discount_amount).'</td>
										<td align="right" class="amount">'.number_format($rd->total_amount,2).'</td>
										<td align="center"><button type="button" class="btn btn-danger btn-minier" onClick="delete_row('.$ds->id_order_detail.')"><i class="fa fa-trash"></i></button></td>';
										
							$datax = "update || ".$ds->id_order_detail." || ".$data;	
							echo $datax;	
					}// $rd
					else
					{
						echo "fail 1";
					}
				} // $de
				
				else    // $de
				/// ถ้าไม่มีรายการอยู่ เพิ่มใหม่
				{
					$price = $item->price;
					$discount = $p_dis > 0 ? $price * ($p_dis * 0.01) : $a_dis;
					$final_price = $price - $discount;
					$total_discount = $qty * $discount;
					$total_amount	= $qty * $final_price;
					$data = array(
								"id_order" 	=> $id_order,
								"reference"	=> $reference,
								"barcode"	=> $barcode,
								"item_code"	=> $item->item_code,
								"item_name"	=> $item->item_name,
								"style"			=> $item->style,
								"qty"			=> $qty,
								"cost"			=> $item->cost,
								"price"		=> $item->price,
								"discount_percent"	=> $p_dis,
								"discount_amount"	=> $a_dis,
								"total_discount"		=> $total_discount,
								"final_price"			=> $final_price,
								"total_amount"		=> $total_amount
								);
					$rs = $this->main_model->add_detail($data);
					if( $rs )
					{
						$ds = $this->main_model->getDetailRow($rs, $barcode);
						$data = array(
									"id"				=> $ds->id_order_detail,
									"barcode"	=> $barcode,
									"qty"			=> $qty,
									"item"			=> $ds->item_code,
									"detail" 		=> $ds->item_name,
									"price"		=> number_format($ds->price,2),
									"discount" 	=> discount($p_dis, $a_dis),
									"amount"		=> number_format($total_amount, 2)
									);		
						$datax = "insert || ".json_encode($data);	
						echo $datax;
					}
					else
					{
						echo "fail 2";
					}
				}// $de 
			} //  $p_dis != 0
			/// จบ กรณีการให้ส่วนลดที่หน้าจอ
			///  กรณีที่ไม่มีการให้ส่วนลดที่หน้าจอ ทำการตรวจสอบโปรโมชั่น
			else //  $p_dis != 0
			{
				/// ตรวจสอบสินค้าว่ามีโปรโมชั่นหรือไม่
				$pd = $this->promotion_model->isPromotion($barcode);
				if( $pd )  /// ถ้ามีโปรโมชั่น จะได้ id_promotion , set_price, percent, amount กลับมา
				{
					$de = $this->main_model->isExistsDetail($id_order, $barcode, $pd->percent, $pd->amount, $pd->id_promotion);  //// ถ้ามีรายการอยู่แล้ว จะได้ข้อมูลแถวนั้นกลับมา ถ้าไม่มีจะได้ค่า false;
					if( $de )
					{
						$qty 		= $qty + $de->qty;
						$price 	= $de->final_price;
						$discount	= $de->discount_percent > 0 ? $price * ($de->discount_percent * 0.01) : $de->discount_amount;
						$total_discount = $qty * $discount;
						$total_amount = $qty * $price;
						
						$data = array("qty" => $qty, "total_discount" => $total_discount, "total_amount" => $total_amount);
						$rd = $this->main_model->update_detail($de->id_order_detail, $data);
						if( $rd )
						{
							$ds = $this->main_model->getDetailRow($de->id_order_detail, $barcode);
							$data = '<td align="center"><span class="no"></span></td>
										<td>'.$barcode.'</td>
										<td>'.$ds->item_code.'</td>
										<td>'.$ds->item_name.'</td>
										<td align="center" class="qty">'.number_format($ds->qty).'</td>
										<td align="center">'.number_format($ds->price,2).'</td>
										<td align="center">'. discount($ds->discount_percent, $ds->discount_amount).'</td>
										<td align="right" class="amount">'.number_format($ds->total_amount,2).'</td>
										<td align="center"><button type="button" class="btn btn-danger btn-minier" onClick="delete_row('.$ds->id_order_detail.')"><i class="fa fa-trash"></i></button></td>';
										
							$datax = "update || ".$ds->id_order_detail." || ".$data;	
							echo $datax;			
						}
						else
						{
							echo "fail 3";	
						}
					}
					else
					{
						$price = $pd->set_price > 0 ? $pd->set_price : $item->price;
						$discount = $pd->percent > 0 ? $price * ($pd->percent * 0.01)  : $pd->amount;
						$final_price = $price - $discount;
						$total_discount = $qty * $discount;
						$total_amount	= $qty * $final_price;
						$data = array(
									"id_order" 	=> $id_order,
									"reference"	=> $reference,
									"barcode"	=> $barcode,
									"item_code"	=> $item->item_code,
									"item_name"	=> $item->item_name,
									"style"			=> $item->style,
									"qty"			=> $qty,
									"cost"			=> $item->cost,
									"price"		=> $price,
									"discount_percent"	=> $pd->percent,
									"discount_amount"	=> $pd->amount,
									"total_discount"		=> $total_discount,
									"final_price"			=> $final_price,
									"total_amount"		=> $total_amount,
									"id_promotion"		=> $pd->id_promotion
									);
						$rs = $this->main_model->add_detail($data);
						if( $rs )
						{
							$ds = $this->main_model->getDetailRow($rs, $barcode);
							$data = array(
										"id"				=> $ds->id_order_detail,
										"barcode"	=> $barcode,
										"qty"			=> $qty,
										"item"			=> $ds->item_code,
										"detail" 		=> $ds->item_name,
										"price"		=> number_format($ds->price,2),
										"discount" 	=> discount($pd->percent, $pd->amount),
										"amount"		=> number_format($total_amount, 2)
										);		
							$datax = "insert || ".json_encode($data);	
							echo $datax;
						}
						else
						{
							echo "fail 4";
						}
					}
					
				}
				else /// ไม่มีโปร ไม่มีส่วนลดใดๆ 
				{
					$id_promo = 0;
					/// ตรวจสอบว่ามีรายการก่อนหน้าอยู่หรือป่าว
					$de = $this->main_model->isExistsDetail($id_order, $barcode, $p_dis, $a_dis, $id_promo);  //// ถ้ามีรายการอยู่แล้ว จะได้ข้อมูลแถวนั้นกลับมา ถ้าไม่มีจะได้ค่า false;
					if( $de )
					{
						$qty 		= $qty + $de->qty;
						$price 	= $de->final_price;
						$discount = $de->discount_percent > 0 ? $price * ($de->discount_percent * 0.01) : $de->discount_amount;
						$total_discount = $qty * $discount;
						$total_amount = $qty * $price;
						
						$data = array("qty" => $qty, "total_discount" => $total_discount, "total_amount" => $total_amount);
						$rd = $this->main_model->update_detail($de->id_order_detail, $data);
						if( $rd )
						{
							$ds = $this->main_model->getDetailRow($de->id_order_detail, $barcode);
							$data = '<td align="center"><span class="no"></span></td>
										<td>'.$barcode.'</td>
										<td>'.$ds->item_code.'</td>
										<td>'.$ds->item_name.'</td>
										<td align="center" class="qty">'.number_format($ds->qty).'</td>
										<td align="center">'.number_format($ds->price,2).'</td>
										<td align="center">'. discount($ds->discount_percent, $ds->discount_amount).'</td>
										<td align="right" class="amount">'.number_format($ds->total_amount,2).'</td>
										<td align="center"><button type="button" class="btn btn-danger btn-minier" onClick="delete_row('.$ds->id_order_detail.')"><i class="fa fa-trash"></i></button></td>';
										
							$datax = "update || ".$ds->id_order_detail." || ".$data;	
							echo $datax;			
						}
						else
						{
							echo "fail 3";	
						}
					}
					else  
					{
						$price 			= $item->price;
						$final_price 		= $price;
						$total_discount = 0;
						$total_amount	= $qty * $final_price;
						$data = array(
									"id_order" 	=> $id_order,
									"reference"	=> $reference,
									"barcode"	=> $barcode,
									"item_code"	=> $item->item_code,
									"item_name"	=> $item->item_name,
									"style"			=> $item->style,
									"qty"			=> $qty,
									"cost"			=> $item->cost,
									"price"		=> $price,
									"discount_percent"	=> 0,
									"discount_amount"	=> 0,
									"total_discount"		=> $total_discount,
									"final_price"			=> $final_price,
									"total_amount"		=> $total_amount,
									"id_promotion"		=> $id_promo
									);
						$rs = $this->main_model->add_detail($data);
						if( $rs )
						{
							$ds = $this->main_model->getDetailRow($rs, $barcode);
							$data = array(
										"id"				=> $ds->id_order_detail,
										"barcode"	=> $barcode,
										"qty"			=> $qty,
										"item"			=> $ds->item_code,
										"detail" 		=> $ds->item_name,
										"price"		=> number_format($ds->price,2),
										"discount" 	=> '0.00',
										"amount"		=> number_format($total_amount, 2)
										);		
							$datax = "insert || ".json_encode($data);	
							echo $datax;
						}
						else
						{
							echo "fail 4";
						}
					}//  nopromo	
				}
			}// $p_dis != 0
		}
		/// กรณีไม่มีสินค้าในระบบ
		else //$item
		{
			echo "no_item";
		}//$item
	}
	else
	{
		echo "nobarcode";	
	}
}


		
		public function delete_item()
		{
			if($this->input->post("id_order_detail"))
			{
				$rs = $this->main_model->delete_item($this->input->post("id_order_detail"));
				if($rs)
				{
					echo "success";
				}
				else
				{
					echo "fail";
				}
			}
		}
		
		public function payment($id_order)
		{
			$total_amount 	= $this->input->post("total_amount");
			$received 		= $this->input->post("received");
			$pay_by			= $this->input->post('payment_method');
			$sc 				= TRUE;
			/// start transection 
			$this->db->trans_begin();
					
			// เปลี่ยนสถานะเป็นชำระแล้ว
			$valid = $this->main_model->valid_detail($id_order, 1);
			if( !$valid ){ 	$sc = FALSE; }
			
			$order 	= $this->main_model->get_order($id_order);
			$rs 		= $this->main_model->get_detail($id_order);
			$data = array(
							"id_order" 		=> $order->id_order,
							"reference" 		=> $order->reference,
							"order_amount" => $total_amount,
							"discount"		=> $this->main_model->get_total_discount($id_order),
							"received" 		=> $received,
							"changed" 		=> $received - $total_amount,
							"id_employee" 	=> id_employee(),
							"pay_by"			=> $pay_by
							);
			$payment = $this->main_model->add_payment($data);
			if(!$payment){ $sc = FALSE; }
			if( !$this->main_model->change_status($id_order, 1)){ $sc = FALSE; }
			if( $sc === TRUE )
			{
				$this->db->trans_commit();
				echo 'success';
			}
			else
			{
				$this->db->trans_rollback();
				echo 'fail';
			}
		}
				
		
		public function print_order($id_order)
		{
			$order 			= $this->main_model->get_order($id_order);
			$rs 				= $this->main_model->get_detail($id_order);
			$rd['detail'] 		= $rs;
			$rd['order']		= $order;
			$rd['payment'] 	= $this->main_model->get_payment($id_order);
			$this->load->view("shop/bill_view", $rd);			
		}
	}/// endclass
	

?>