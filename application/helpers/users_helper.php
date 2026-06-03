<?php
function _check_login()
{
  $ci = &get_instance();
  $uid = get_cookie('uid');
  if ($uid === NULL or $ci->user_model->verify_uid($uid) === FALSE)
  {
    redirect(base_url() . 'users/authentication');
  }
}

function get_permission($menu, $uid)
{
  $ci = &get_instance();  
  $user = $ci->user_model->get_by_uid($uid);

  if (empty($user))
  {
    return reject_permission();
  }

  //--- If super admin
  if ($user->profile_id == '40a11bc9bc4740a2')
  {
    return (object) array(
      'can_view' => 1,
      'can_add' => 1,
      'can_edit' => 1,
      'can_delete' => 1,
      'can_approve' => 1
    );
  }
  else
  {
    $pm = $ci->user_model->get_permission($menu, $user->id_profile);

    if (empty($pm))
    {
      return reject_permission();
    }
    return $pm;
  } 
}


function reject_permission()
{
  return (object) array(
    'can_view' => 0,
    'can_add' => 0,
    'can_edit' => 0,
    'can_delete' => 0,
    'can_approve' => 0
  );
}


function _can_view_page($can_view)
{
  if (! $can_view)
  {
    $ci = &get_instance();
    $ci->load->view('deny_page');    
  }
}


function select_user($id = '')
{
  $ds = "";
  $ci = &get_instance();
  $list = $ci->user_model->get_all();

  if( ! empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= "<option value=\"{$rs->id}\" " . is_selected($rs->id, $id) . ">{$rs->uname} : {$rs->name}</option>";
    }
  }

  return $ds;
}


function select_uname($uname = '')
{
  $ds = '';
  $ci = &get_instance();
  $list = $ci->user_model->get_all();

  if( ! empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= "<option value=\"{$rs->uname}\" " . is_selected($rs->uname, $uname) . ">{$rs->uname}</option>";
    }
  }

  return $ds;
}


function display_name($id)
{
  $ci = &get_instance();
  return $ci->user_model->get_name($id);
}
