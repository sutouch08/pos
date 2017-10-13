<?php 
function get_user_profile($id)
{
	$c =& get_instance();
	$rs = $c->db->where("id_user", $id)->get("tbl_user");
	if($rs->num_rows() == 1)
	{
		return $rs->result_array();
	}else{
		return false;
	}
}


function error($label)
{
	$ci =& get_instance();
	$language = get_lang($ci->session->userdata("id_user"));
	$ci->lang->load($language,$language);
	$rs = $ci->lang->line($label);
	if($rs)
	{
		return $rs;
	}else{
		return $label;
	}
}

function label($label)
{
	$ci =& get_instance();
	$rs = $ci->lang->line($label);
	if($rs)
	{
		return $rs;
	}else{
		return $label;
	}
}

function multi_lang()
{
	$ci =& get_instance();
	$rs = $ci->db->select("value")->get_where("tbl_config", array("config_name"=>"MULTI_LANG"),1);
	if($rs->num_rows() == 1)
	{
		$re = $rs->row()->value;
		if($re == 1 )
		{
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}


function utf8($in) {
$out = "";
for ($i = 0; $i < strlen($in); $i++)
{
if (ord($in[$i]) <= 126)
$out .= $in[$i];
else
$out .= "&#" . (ord($in[$i]) - 161 + 3585) . ";";
}
return $out;
}



?>