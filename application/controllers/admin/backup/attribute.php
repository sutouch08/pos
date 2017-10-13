<?php 
class Attribute extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/template";
	public $title = "คุณลักษณะ";
	 
	 public function __construct()
	 {
		 parent:: __construct();
		 $this->home = base_url()."admin/attribute";
		 $this->load->model("admin/attribute_model");
	 }
	 public function index()
	 {
		$rs = $this->attribute_model->get_data();
		$last = $this->attribute_model->top_position();
		$data['last'] 		= $last;
		$data['data']			= $rs;
		$data['id_menu']		= $this->id_menu;
		$data['page_title'] 	= $this->title;
		$data['view']			= "admin/attribute_view";
		$this->load->view($this->layout, $data);		 
	 }
	 
	 public function add_attribute()
	 {
		 if( $this->input->post("add") )
		 {
			 $data['attribute_code'] = $this->input->post("attribute_code");
			 $data['attribute_name'] = $this->input->post("attribute_name");
			 if( $this->verify->validate($this->id_menu, "add") )
			 {
				 $rs = $this->attribute_model->add($data);
				 if($rs)
				 {
					 setMessage("เพิ่ม 1 รายการ สำเร็จ");
				 }else{
					 setError("เพิ่มรายการไม่สำเร็จ");
				 }
				 redirect($this->home);				 
			 }else{
				action_deny();
			 }
		 }else{
			 $data['id_menu'] = $this->id_menu;
			 $data['page_title'] = $this->title;
			 $data['view'] = "admin/add_attribute_view";
			 $this->load->view($this->layout, $data);		 
		 }
	 }
	 
	 
	 
	  public function edit_attribute($id)
	 {
		 $this->title = "แก้ไขคุณลักษณะ";
		 if( $this->input->post("edit") )
		 {
			 $data['attribute_code'] = $this->input->post("attribute_code");
			 $data['attribute_name'] = $this->input->post("attribute_name");
			 if( $this->verify->validate($this->id_menu, "edit") )
			 {
				 $rs = $this->attribute_model->update($id, $data);
				 if($rs)
				 {
					 setMessage("แก้ไข 1 รายการ สำเร็จ");
				 }else{
					 setError("แก้ไขรายการไม่สำเร็จ");
				 }
				 redirect($this->home);				 
			 }else{
				action_deny();
			 }
		 }else{
			 $rs = $this->attribute_model->get_data($id);
			 $data['data'] = $rs;
			 $data['id_menu'] = $this->id_menu;
			 $data['page_title'] = $this->title;
			 $data['view'] = "admin/edit_attribute_view";
			 $data['id_attribute'] = $id;
			 $this->load->view($this->layout, $data);		 
		 }
	 }
	 
	 
	 
	 public function delete_attribute($id)
	 {
		 if( $this->verify->validate($this->id_menu, "delete") )
		 {
			 $rs = $this->attribute_model->delete($id);
			 if($rs)
			 {
				 setMessage("ลบ 1 รายการ สำเร็จ");
			 }else{
				 setError("ลบรายการไม่สำเร็จ");
			 }
			 redirect($this->home);
		 }else{
			 action_deny();
		 }
	 }
	
	
	public function move_up($id, $position)
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			if($id !="" || $position !="")
			{
				$rs = $this->attribute_model->move_up($id, $position);
			}
			redirect($this->home);
		}else{
			action_deny();
		}
	}
	
	public function move_down($id, $position)
	{
		if( $this->verify->validate($this->id_menu, "edit") )
		{
			if($id !="" || $position !="")
			{
				$rs = $this->attribute_model->move_down($id, $position);
			}
			redirect($this->home);
		}else{
			action_deny();
		}		
	}
	
	
	
	
	
	
	
	/********************* ตรวจสอบ รหัสซ้ำ  ******************/
	public function valid_code($code, $id="")
	{
		if( $this->attribute_model->valid_code(urldecode($code), $id) )
		{
			echo "1"; // ซ้ำ
		}else{
			echo "0"; //ไม่ซ้ำ
		}
	}
	
	public function valid_name($name, $id="")
	{
		if( $this->attribute_model->valid_name(urldecode($name), $id) )
		{
			echo "1"; // ซ้ำ
		}else{
			echo "0"; //ไม่ซ้ำ
		}
	}
	
}// End class

?>