<?php 
class Size extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/template";
	public $title = "Size";
	 
	 public function __construct()
	 {
		 parent:: __construct();
		 $this->home = base_url()."admin/size";
		 $this->load->model("admin/size_model");
	 }
	 public function index()
	 {
		$rs = $this->size_model->get_data();
		$last = $this->size_model->top_position();
		$data['last'] 		= $last;
		$data['data']			= $rs;
		$data['id_menu']		= $this->id_menu;
		$data['page_title'] 	= $this->title;
		$data['view']			= "admin/size_view";
		$this->load->view($this->layout, $data);		 
	 }
	 
	 public function add_size()
	 {
		 if( $this->input->post("add") )
		 {
			 $data['size_code'] = $this->input->post("size_code");
			 $data['size_name'] = $this->input->post("size_name");
			 if( $this->verify->validate($this->id_menu, "add") )
			 {
				 $rs = $this->size_model->add($data);
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
			 $data['view'] = "admin/add_size_view";
			 $this->load->view($this->layout, $data);		 
		 }
	 }
	 
	 
	 
	  public function edit_size($id)
	 {
		 if( $this->input->post("edit") )
		 {
			 $data['size_code'] = $this->input->post("size_code");
			 $data['size_name'] = $this->input->post("size_name");
			 if( $this->verify->validate($this->id_menu, "edit") )
			 {
				 $rs = $this->size_model->update($id, $data);
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
			 $rs = $this->size_model->get_data($id);
			 $data['data'] = $rs;
			 $data['id_menu'] = $this->id_menu;
			 $data['page_title'] = $this->title;
			 $data['view'] = "admin/edit_size_view";
			 $data['id_size'] = $id;
			 $this->load->view($this->layout, $data);		 
		 }
	 }
	 
	 
	 
	 public function delete_size($id)
	 {
		 if( $this->verify->validate($this->id_menu, "delete") )
		 {
			 $rs = $this->size_model->delete($id);
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
				$rs = $this->size_model->move_up($id, $position);
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
				$rs = $this->size_model->move_down($id, $position);
			}
			redirect($this->home);
		}else{
			action_deny();
		}		
	}
	
	
	
	
	
	
	
	/********************* ตรวจสอบ รหัสซ้ำ  ******************/
	public function valid_code($code, $id="")
	{
		if( $this->size_model->valid_code(urldecode($code), $id) )
		{
			echo "1"; // ซ้ำ
		}else{
			echo "0"; //ไม่ซ้ำ
		}
	}
	
	public function valid_name($name, $id="")
	{
		if( $this->size_model->valid_name(urldecode($name), $id) )
		{
			echo "1"; // ซ้ำ
		}else{
			echo "0"; //ไม่ซ้ำ
		}
	}
	
}// End class

?>