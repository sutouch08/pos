<?php

function select_channels($code = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/channels_model');
  $list = $ci->channels_model->get_all();

  if(!empty($list))
  {
    foreach($list as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" data-id="'.$rs->id.'" '.is_selected($rs->code, $code).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}


function channels_name_by_id($id)
{
  $ci =& get_instance();
  $rs = $ci->db->select('name')->where('id', $id)->get('channels');

  if($rs->num_rows() === 1)
  {
    return $rs->row()->name;
  }

  return NULL;
}


function channels_name_by_code($code)
{
  $ci =& get_instance();
  $rs = $ci->db->select('name')->where('code', $code)->get('channels');

  if($rs->num_rows() === 1)
  {
    return $rs->row()->name;
  }

  return NULL;
}


function channels_array()
{
  $ds = array();
  $ci =& get_instance();
  $ci->load->model('masters/channels_model');

  $list = $ci->channels_model->get_all();

  if( ! empty($list))
  {
    foreach($list as $rs)
    {
      $ds[$rs->code] = $rs->name;
    }
  }

  return $ds;
}

