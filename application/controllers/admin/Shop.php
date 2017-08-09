<?php
class Shop extends CI_Controller
{
	public $id_menu	= 5;
	public $layout		= 'include/template';
	public $title			= 'เพิ่ม/แก้ไข ร้านค้า';
	public $home;
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/shop_model');
		$this->home 	= base_url() . 'admin/shop';	
	}
	
	public function index()
	{
		$search_text	= "";
		if($this->input->post("shop_search") != "")
		{
			$this->session->set_userdata("shop_search_text", $this->input->post("shop_search"));
			$search_text 	= $this->input->post("shop_search");
		}
		$row 						= $this->shop_model->count_row($search_text);
		$config 					= paginationConfig();
		$config['base_url'] 		= $this->home."/index/";
		$config['per_page'] 	= $this->input->cookie('row') ? $this->input->cookie('row') : getConfig("PER_PAGE");
		$config['total_rows'] 	=  $row != false ? $row : 0;
		if($this->session->userdata("shop_search_text"))
		{
			$rs 	= $this->shop_model->get_search_data($this->session->userdata("shop_search_text"), $config['per_page'], $this->uri->segment($config['uri_segment']));
			$txt 	= $this->session->userdata("shop_search_text");
		}
		else
		{
			$rs	= $this->shop_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
			$txt	= "";
		}
		$data['data'] 			= $rs;
		$data['id_menu'] 		= $this->id_menu;
		$data['view']				= "admin/shop_view";
		$data['page_title'] 		= $this->title;
		$data['row']				= $config['per_page'];
		$data['total_row']		= $row;
		$data['shop_search']	= $txt;
		$this->pagination->initialize($config);	
		$this->load->view($this->layout, $data);
	}
	
	public function getShop($id)
	{
		$ds = 'fail';
		$rs = $this->shop_model->get_data($id);
		if( $rs )
		{
			$data = array(
				'id'				=> $rs->id_shop,
				'code'			=> $rs->shop_code,
				'name'			=> $rs->shop_name,
				'address'	=> $rs->address,
				'province'	=> selectProvince($rs->province),
				'phone'		=> $rs->phone,
				'active'		=> $rs->active,
				'success'	=> $rs->active == 1 ? 'btn-success' : '',
				'danger'		=> $rs->active == 0 ? 'btn-danger' : ''
			);
			$ds = json_encode($data);
		}
		echo $ds;
	}
	
	public function addShop()
	{
		$sc = 'fail';
		if( $this->input->post('code') && $this->input->post('name') )
		{
			$data = array(
				'shop_code'		=> $this->input->post('code'),
				'shop_name'		=> $this->input->post('name'),
				'address'		=> $this->input->post('address'),
				'province'		=> $this->input->post('province'),
				'post_code'		=> $this->input->post('post_code'),
				'phone'			=> $this->input->post('phone'),
				'active'			=> $this->input->post('active')		
			);	
			$rs = $this->shop_model->addShop($data);
			if( $rs )
			{
				$datax = array(
					'id'				=> $rs,
					'code'			=> $this->input->post('code'),
					'name'			=> $this->input->post('name'),
					'province'	=> $this->input->post('province'),
					'phone'		=> $this->input->post('phone'),
					'active'		=> isActived($this->input->post('active'))		
				);
				$sc = json_encode($datax);				
			}
		}
		echo $sc;
	}
	
	public function updateShop($id)
	{
		$sc = 'fail';
		if( $this->input->post('code') && $this->input->post('name') )
		{
			$data = array(
				'shop_code'		=> $this->input->post('code'),
				'shop_name'		=> $this->input->post('name'),
				'address'		=> $this->input->post('address'),
				'province'		=> $this->input->post('province'),
				'post_code'		=> $this->input->post('post_code'),
				'phone'			=> $this->input->post('phone'),
				'active'			=> $this->input->post('active')		
			);	
			$rs = $this->shop_model->updateShop($id, $data);
			if( $rs )
			{
				$sc = 'success';
			}
		}
		echo $sc;
	}	
	
	public function deleteShop($id)
	{
		$sc = 'fail';
		$rd	= $this->shop_model->isTransection($id, 'tbl_order');
		$pm	= $this->shop_model->isTransection($id, 'tbl_payment');
		$st	= $this->shop_model->isTransection($id, 'tbl_stock');
		if( $rd === FALSE && $pm === FALSE && $st === FALSE )
		{
			$rs = $this->shop_model->deleteShop($id);
			if( $rs )
			{
				$this->shop_model->removeFromShop($id);
				$sc = 'success';
			}
		}
		else
		{
			$sc = 'transection';
		}
		echo $sc;
	}
	public function addToShop()
	{
		$sc = 'success';
		if( $this->input->post('id_shop') && $this->input->post('id_employee') )
		{
			$id_emp 		= $this->input->post('id_employee');
			$id_shop		= $this->input->post('id_shop');	
			$rd 			= $this->shop_model->isInShop($id_emp, $id_shop);
			if( $rd === FALSE )
			{
				$rs = $this->shop_model->addToShop($id_emp, $id_shop);
				if( !$rs )
				{
					$sc = 'fail';
				}
			}	
		}
		else
		{
			$sc = 'fail';
		}
		echo $sc;
	}
	
	public function removeFromShop($id_employee)
	{
		$rs = $this->shop_model->removeEmpShop($id_employee);
		if( $rs )
		{
			echo 'success';
		}
		else
		{
			echo 'fail';
		}
	}

	public function shopEmp($id)
	{
		$data = array();
		$rs = $this->shop_model->getShopEmp($id);
		if( $rs )
		{
			foreach($rs as $rd)
			{
				$arr = array(
								'id' 			=> $rd->id_employee, 
								'code' 		=> $rd->code, 
								'empName'	=> $rd->first_name.' '.$rd->last_name, 
								'phone' 		=> $rd->phone, 
								'active' 		=> isActived($rd->active)
							);
				array_push($data, $arr);
			}
			echo json_encode($data);
		}
		else
		{
			$data = 'noemployee';
			echo $data;
		}
	}
	
	public function validShop()
	{
		$sc = 'ok';
		$id = $this->input->post('id_shop') ? $this->input->post('id_shop') : '';
		$rs = $this->shop_model->isCodeExists($this->input->post('code'), $id);
		$rd = $this->shop_model->isNameExists($this->input->post('name'), $id);
		if( $rd === TRUE ){ $sc = 'name'; }
		if( $rs === TRUE ){ $sc = 'code'; }
		echo $sc;
	}
	
	public function clearFilter()
	{
		$this->session->unset_userdata("shop_search_text");
		echo "success";	
	}
	
}/// end class

?>