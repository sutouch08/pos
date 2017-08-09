<?php
class Tool extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
	}
	
		
	public function set_rows()
	{
		$cookie = array("name"=>"row", "value"=>$this->input->post('rows'), "expire"=>"865000000");
		$this->input->set_cookie($cookie);
		echo 'success';
		
	}
	
	public function getShopNameAndId()
	{
		$sc = 'ไม่พบข้อมูล';
		$this->load->model('admin/shop_model');
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];	
			$rs = $this->shop_model->searchShop($txt);
			if( count($rs) > 0 )
			{
				$sc = json_encode($rs);
			}
		}	
		echo $sc;		
	}
	
	/********* ได้ข้อมูลพร้อม encode ทันที ***********/
	public function getShop()
	{
		$this->load->model('admin/shop_model');
		$sc = 'No data found';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];
			$rs = $this->shop_model->searchShop($txt);
			if( count($rs) > 0 )
			{
				$sc = json_encode($rs);
			}
		}
		echo $sc;
	}
	
	public function getEmployee()
	{
		$sc = 'No data found';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];	
			$rs = $this->db->where('id_shop', 0)->like("code", $txt)->or_like('first_name', $txt)->or_like('last_name', $txt)->get('tbl_employee');
			if( $rs->num_rows() > 0 )
			{
				$ds = array();
				foreach( $rs->result() as $rd)
				{
					$ds[] = $rd->code.' | '.$rd->first_name.' '.$rd->last_name.' | '.$rd->id_employee;	
				}
				$sc = json_encode($ds);
			}
		}	
		echo $sc;
	}
	
	public function getCategory()
	{
		$sc = '';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];	
			$rs = $this->db->like('category', $txt)->group_by('category')->get('tbl_items');
			if( $rs->num_rows() > 0 )
			{
				$ds = array();
				foreach( $rs->result() as $rd )
				{
					$ds[] = $rd->category;
				}
				$sc = json_encode($ds);
			}
		}
		echo $sc;
	}
	
	public function getStyle()
	{
		$sc = '';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];	
			$rs = $this->db->like('style', $txt)->group_by('style')->get('tbl_items');
			if( $rs->num_rows() > 0 )
			{
				$ds = array();
				foreach( $rs->result() as $rd )
				{
					$ds[] = $rd->style;
				}
				$sc = json_encode($ds);
			}
		}
		echo $sc;
	}
	
	public function getItem()
	{
		$sc = '';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];
			$rs = $this->db->like('item_code', $txt)->or_like('item_name', $txt)->get('tbl_items');
			if( $rs->num_rows() > 0 )
			{
				$ds = array();
				foreach($rs->result() as $rd )
				{
					$ds[] = $rd->item_code.' | '.$rd->id_item;
				}
				$sc = json_encode($ds);
			}
		}
		echo $sc;
	}
	
	public function getItemCode()
	{
		$sc = '';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];
			$rs = $this->db->like('item_code', $txt)->or_like('item_name', $txt)->get('tbl_items');
			if( $rs->num_rows() > 0 )
			{
				$ds = array();
				foreach($rs->result() as $rd )
				{
					$ds[] = $rd->item_code.' | '.$rd->item_name;
				}
				$sc = json_encode($ds);
			}
		}
		echo $sc;
	}
	
	public function getBrand()
	{
		$sc = '';
		if( isset( $_REQUEST['term'] ) )
		{
			$txt = $_REQUEST['term'];
			$rs = $this->db->like('name', $txt)->get('tbl_brand');
			if( $rs->num_rows() > 0 )
			{
				$ds = array();
				foreach($rs->result() as $rd )
				{
					$ds[] = $rd->name;	
				}
				$sc = json_encode($ds);
			}
		}
		echo $sc;
	}
	
}/// endclass


?>