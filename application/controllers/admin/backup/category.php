<?php 
class Category extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/template";
	public $title = "หมวดหมู่สินค้า";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."admin/category";
		$this->load->model("admin/category_model");
	}
	
	public function index()
	{
		$rs = $this->category_model->get_data();
		$data['id_menu'] = $this->id_menu;
		$data['page_title'] = $this->title;
		$data['view'] = "admin/category_view";
		$data['data'] = $rs;
		$this->load->view($this->layout, $data);		
	}
	
	public function add_category()
	{
		if($this->input->post("add") )
		{
			if( $this->verify->validate($this->id_menu, "add") )
			{
				$data['category_name'] = $this->input->post("category_name");
				$data['id_parent'] = $this->input->post("id_parent");
				$data['level'] = $this->category_model->get_level($this->input->post("id_parent"));
				$data['show'] = $this->input->post("visible");
				$data['active'] = $this->input->post("active");
				if( $this->category_model->add($data) )
				{
					redirect($this->home);
				}else{
					setError("เพิ่มหมวดหมู่ไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
				action_deny();
			}
		}else{
			$rs = $this->category_model->get_category_by_parent(1);
			$data['cate'] = $rs;
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "admin/add_category_view";
			$this->load->view($this->layout, $data);
		}
	}
	
	public function edit_category($id)
	{
		if( $this->input->post("edit") )
		{
			$data['category_name'] = $this->input->post("category_name");
			$data['id_parent'] = $this->input->post("id_parent");
			$data['level'] = $this->category_model->get_level($this->input->post("id_parent"));
			$data['show'] = $this->input->post("visible");
			$data['active'] = $this->input->post("active");
			if( $this->verify->validate($this->id_menu, "edit") )
			{
				if( $this->category_model->update($id, $data) )
				{
					setMessage("แก้ไขรายการเรียบร้อย");
					redirect($this->home);
				}else{
					setError("แก้ไขข้อมูลไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
				action_deny();
			}
		}else{
			$rs = $this->category_model->get_category_by_parent(1);
			$ro = $this->category_model->get_data($id);
			$data['id_category'] = $id;
			$data['cate'] = $rs;
			$data['data'] = $ro;
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "admin/edit_category_view";
			$this->load->view($this->layout, $data);
		}
	}
	
	
	public function delete_category($id)
	{
		if( $this->verify->validate($this->id_menu, "delete") )
		{
			if( !$this->category_model->have_children($id) )
			{
				if($this->category_model->delete($id))
				{
					setMessage("ลบรายการเรียบร้อยแล้ว");
				}else{
					setError("ลบรายการไม่สำเร็จ");
				}
			}else{
				setError("ไม่สามารถลบรายการนี้ได้ เนื่องจากยังมีรายการอื่นอยู่ภายในรายการนี้");
			}
			redirect($this->home);
		}else{
			action_deny();	
		}
	}
	
	
	
	public function display_children($parent, $checked="", $me=""){
		$rs = $this->category_model->get_category_by_parent($parent);
		if($rs != false) 
		{
    		echo "<ul class='tree-branch-children'>";
    		foreach($rs as $ra) 
			{
				if($ra->id_category != $me)
				{
					echo "<li class='tree-branch tree-open'>
								<div class='tree-branch-header'>
									<span class='tree-branch-name'>
										<span class='tree-label'>
											 <label for='". $ra->category_name."'>
												 <input type='radio' name='id_parent' value='". $ra->id_category."' id='".$ra->category_name."' class='ace' ".isChecked($ra->id_category, $checked)." />
												 <span class='lbl'> ".$ra->category_name."<br></span>
											</label>
										</span>
									</span>
								</div>";
				}
            $this->display_children($ra->id_category, $checked);
            echo "</li>";
			}
			echo "</ul>";
        }
}


	/********************* ตรวจสอบ หมวดหมู่ซ้ำ  ******************/
	
	public function valid_name($name, $id="")
	{
		if( $this->category_model->valid_name(urldecode($name), $id) )
		{
			echo "1"; // ซ้ำ
		}else{
			echo "0"; //ไม่ซ้ำ
		}
	}
	
	
}// End class

?>