<?php
class Color extends CI_Controller
{
	public $id_menu = 1;
	public $layout = "include/template";
	public $home;
	public $title = "สี";
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->model("admin/color_model");
		$this->home = base_url()."admin/color";
	}
	
	public function index()
	{
		$rs = $this->color_model->get_color();
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "admin/color_view";
		$data['page_title'] = "เพิ่ม/แก้ไข สี";
		$this->load->view($this->layout, $data);
	}
	
	public function add_color()
	{
		if( $this->input->post("add") )
		{
			$data['color_code'] = $this->input->post("color_code");
			$data['color_name'] = $this->input->post("color_name");
			$data['id_color_group'] = $this->input->post("id_color_group");
			if($this->verify->validate($this->id_menu, "add"))
			{
				$rs = $this->color_model->add_color($data);
				if($rs)
				{
					setMessage("เพิ่ม 1 รายการเรียบร้อย");
					redirect($this->home."/add_color");
				}else{
					setError("เพิ่มรายการไม่สำเร็จ");
					redirect($this->home."/add_color");
				}
			}else{
				action_deny();
			}
		}else{
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "admin/add_color_view";
			$data['page_title'] = "เพิ่ม สี";
			$this->load->view($this->layout, $data);	
		}
	}
	public function valid_code($code, $id="")
	{
		if($this->color_model->valid_code(urldecode($code), $id))
		{
			echo "1"; // รหัสซ้ำ
		}else{
			echo "0"; // ไม่ซ้ำ
		}
	}
	
	public function edit_color($id)
	{
		if( $this->input->post("edit") )
		{
			$data['color_code'] = $this->input->post("color_code");
			$data['color_name'] = $this->input->post("color_name");
			$data['id_color_group'] = $this->input->post("id_color_group");
			if($this->verify->validate($this->id_menu, "edit"))
			{
				$rs = $this->color_model->update_color($id, $data);
				if($rs)
				{
					setMessage("แก้ไข 1 รายการเรียบร้อย");
					redirect($this->home);
				}else{
					setError("แก้ไขรายการไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
				action_deny();
			}
		}else{
			$rs = $this->color_model->get_color($id);
			$data['data'] = $rs;
			$data['id'] = $id;
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "admin/edit_color_view";
			$data['page_title'] = "แก้ไขสี";
			$this->load->view($this->layout, $data);
		}
	}
	
	
	public function delete_color($id)
	{
		if( $this->verify->validate($this->id_menu, "delete") )
		{
			$rs = $this->color_model->delete_color($id);
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
	
	
	public function valid_name($name, $id="")
	{
		if($this->color_model->valid_name(urldecode($name), $id))
		{
			echo "1"; // รหัสซ้ำ
		}else{
			echo "0"; // ไม่ซ้ำ
		}
	}
	/*************************  Color Group Section  ***************************/
	public function color_group()
	{
		$rs = $this->color_model->get_group();
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['view'] = "admin/color_group_view";
		$data['page_title'] = "เพิ่ม/แก้ไข กลุ่มสี";
		$this->load->view($this->layout, $data);
	}
	
	public function add_group()
	{
		if($this->input->post("add"))
		{
			$data['group_name'] 	= $this->input->post("group_name");
			$data['active']			= $this->input->post("active");
			if($this->verify->validate($id_menu, "add") )
			{
				$rs = $this->color_model->add_group($data);
				if($rs){
					setMessage("เพิ่มกลุ่มสีเรียบร้อยแล้ว");
					redirect($this->home."/color_group");
				}else{
					setError("เพิ่มกลุ่มสีไม่สำเร็จ");
					redirect($this->home."/color_group");
				}
			}else{
				action_deny();
			}
			
		}else{
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "admin/add_color_group_view";
			$data['page_title'] = "เพิ่ม กลุ่มสี";
			$this->load->view($this->layout, $data);
		}
	}
	
	public function edit_group($id)
	{
		if( $this->input->post("edit") )
		{
			$data['group_name'] 	= $this->input->post("group_name");
			$data['active']			= $this->input->post("active");
			if($this->verify->validate($id_menu, "edit") )
			{
				$rs = $this->color_model->update_group($id, $data);
				if($rs){
					setMessage("แก้ไขกลุ่มสีเรียบร้อยแล้ว");
					redirect($this->home."/color_group");
				}else{
					setError("แก้ไขกลุ่มสีไม่สำเร็จ");
					redirect($this->home."/color_group");
				}
			}else{
				action_deny();
			}
		}else{
			$rs = $this->color_model->get_group($id);
			$data['id_color_group'] = $id;
			$data['data'] = $rs;
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "admin/edit_color_group_view";
			$data['page_title'] = "แก้ไข กลุ่มสี";
			$this->load->view($this->layout, $data);
		}
	}
	
	public function delete_group($id)
	{
		if($this->verify->validate($this->id_menu, "delete") )
		{
			$rs = $this->color_model->delete_group($id);
			if($rs)
			{
				setMessage("ลบรายการสำเร็จ");
				redirect($this->home."/color_group");
			}else{
				setError("ลบรายการไม่สำเร็จ");
				redirect($this->home."/color_group");
			}
		}else{
			action_deny();	
		}
	}
			
}// end class


?>