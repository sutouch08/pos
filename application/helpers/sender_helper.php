<?php

function select_common_sender($id = NULL)
{
	$ds = '';
	$ci =& get_instance();
	$ci->load->model('masters/sender_model');

	$list = $ci->sender_model->get_common_list();

	if(! empty($list))
	{
		foreach($list as $rs)
		{
			$selected = $id == $rs->id ? 'selected' : '';
			$ds .= '<option value="'.$rs->id.'" data-code="'.$rs->code.'" '.$selected.'>'.$rs->code.' | '.$rs->name.'</option>';
		}
	}

	return $ds;
}


 ?>
