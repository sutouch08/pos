<?php
function select_profile($id = '')
{
  $sc = '';
  $ci =& get_instance();
  $ci->load->model('users/profile_model');
  $list = $ci->profile_model->get_all();

  if( ! empty($list))
  {
    foreach($list as $rs)
    {
      $sc .= "<option value=\"{$rs->id}\" data-uid=\"{$rs->uid}\" ".is_selected($id, $rs->id).">{$rs->name}</option>";
    }
  }

  return $sc;
}

function profile_name($id)
{
  $ci =& get_instance();
  $ci->load->model('users/profile_model');
  return $ci->profile_model->get_name($id);
}
