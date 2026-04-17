<?php
function bankLogoUrl($code)
{
  $CI =& get_instance();
  $img  = $code.'.png';
  $path	= base_url().$CI->config->item('image_path').'banks/';
  $image_path = $path.$img;
  $noimg = $path.'noimg.png';
 	$file = $CI->config->item('image_file_path').'banks/'.$img;
 	if( ! file_exists($file) )
 	{
 		return $noimg;
 	}

 	return $image_path;
}


function select_bank_account($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/bank_model');
  $list = $ci->bank_model->get_all(TRUE);

  if( ! empty($list))
  {
    foreach($list as $rs)
    {
      $ds .= '<option value="'.$rs->id.'" '.is_selected($id, $rs->id).'>'.$rs->acc_name.'#'.$rs->acc_no.'</option>';
    }
  }

  return $ds;
}


function select_bank($code = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/bank_code_model');
  $list = $ci->bank_code_model->get_all(TRUE);
  if( ! empty($list))
  {
    foreach($list as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" '.is_selected($code, $rs->code).'>'.$rs->code.' - '.$rs->name.'</option>';
    }
  }

  return $ds;
}


function account_name_array()
{
  $ds = array();
  $ci =& get_instance();
  $ci->load->model('masters/bank_model');

  $list = $ci->bank_model->get_all();

  if( ! empty($list))
  {
    foreach($list as $rs)
    {
      $ds[$rs->id] = $rs->acc_name;
    }
  }

  return $ds;
}


function get_account_text($id)
{
  $name = "";
  $ci =& get_instance();
  $ci->load->model('masters/bank_model');
  $rs = $ci->bank_model->get($id);
  if( ! empty($rs))
  {
    $name = $rs->acc_name.'#'.$rs->acc_no;
  }

  return $name;
}


function bank_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/bank_code_model');
  return $ci->bank_code_model->get_name($id);
}

