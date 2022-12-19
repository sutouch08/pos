<?php
function _check_login()
{
  $ci =& get_instance();
  $uid = get_cookie('uid');

  if($uid === NULL OR $ci->user_model->verify_uid($uid) === FALSE)
  {
    redirect(base_url().'users/authentication');
  }
}


function get_permission($menu, $uid = NULL, $group_id = NULL)
{
  $ci =& get_instance();

  $uid = $uid === NULL ? get_cookie('uid') : $uid;
  $user = $ci->user_model->get_user_by_uid($uid);

  if(empty($user))
  {
    return reject_permission();
  }

  //--- If super admin
  if($user->group_id == -987654321)
  {
    $pm = new stdClass();
    $pm->can_view = 1;
    $pm->can_add = 1;
    $pm->can_edit = 1;
    $pm->can_delete = 1;
    $pm->can_approve = 1;
  }
  else
  {
    $pm = $ci->user_model->get_permission($menu, $user->group_id);

    if(empty($pm))
    {
      return reject_permission();
    }
    else
    {
      if(getConfig('CLOSE_SYSTEM') == 2)
      {
        $pm->can_add = 0;
        $pm->can_edit = 0;
        $pm->can_delete = 0;
        $pm->can_approve = 0;
      }
    }
  }

  return $pm;
}


function reject_permission()
{
  $pm = new stdClass();
  $pm->can_view = 0;
  $pm->can_add = 0;
  $pm->can_edit = 0;
  $pm->can_delete = 0;
  $pm->can_approve = 0;

  return $pm;
}


function select_sales_team($id = NULL)
{
  $ci =& get_instance();
  $ci->load->model('masters/sales_team_model');
  $result = $ci->sales_team_model->get_all();
  $ds = '';
  if(!empty($result))
  {
    foreach($result as $rs)
    {
      $ds .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $id).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}



function select_employee($empID = NULL)
{
  $ds = '';
  $ci =& get_instance();
	$ci->load->model('masters/employee_model');
  $qs = $ci->employee_model->get_all();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $empID).'>'.$rs->firstName.' '.$rs->lastName.'</option>';
    }
  }

  return $ds;
}



function select_saleman($sale_id = '')
{
  $ds = '';
  $ci =& get_instance();
	$ci->load->model('masters/sales_person_model');
  $qs = $ci->sales_person_model->get_all();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $sale_id).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_user($user_id = NULL)
{
	$ds = '';
	$ci =& get_instance();
	$ci->load->model('users/user_model');
	$option = $ci->user_model->get_all_active();

	if( ! empty($option))
	{
		foreach($option as $rs)
		{
			$ds .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $user_id).'>'.$rs->uname.'</option>';
		}
	}

	return $ds;
}


function select_user_group($group_id = '')
{
  $ds = '';
  $ci =& get_instance();
	$ci->load->model('users/user_group_model');
  $qs = $ci->user_group_model->get_all();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $group_id).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}

function _can_view_page($can_view)
{
  if( ! $can_view)
  {
    $ci =& get_instance();
    $ci->load->view('deny_page');
    //redirect('deny_page');
  }
}



function user_in($txt)
{
  $sc = array('0');
  $ci =& get_instance();
  $ci->load->model('users/user_model');
  $users = $ci->user_model->search($txt);

  if(!empty($users))
  {
    foreach($users as $rs)
    {
      $sc[] = $rs->uname;
    }
  }

  return $sc;
}


 ?>
