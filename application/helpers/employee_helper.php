<?php

function select_employee($id = NULL)
{
  $ds = "";
  $ci =& get_instance();
  $ci->load->model('masters/employee_model');
  $list = $ci->employee_model->get_all();

  if (!empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= '<option value="' . $rs->id . '" ' . is_selected($rs->id, $id) . '>' . $rs->firstName . ' ' . $rs->lastName . '</option>';
    }
  }

  return $ds;
}


function employee_name($id)
{
  $ci = &get_instance();
  $ci->load->model('masters/employee_model');
  return $ci->employee_model->get_name($id);
}


function employee_name_array()
{
  $ds = array();
  $ci =& get_instance();
  $ci->load->model('masters/employee_model');
  $list = $ci->employee_model->get_all();

  if (! empty($list))
  {
    foreach ($list as $rs)
    {
      $ds[$rs->id] = $rs->firstName . ' ' . $rs->lastName;
    }
  }

  return $ds;
}


function select_position($id = NULL)
{
  $ci =& get_instance();
  $ci->load->model('masters/position_model');
  $list = $ci->position_model->get_all();

  $ds = "";

  if (!empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= '<option value="' . $rs->id . '" ' . is_selected($rs->id, $id) . '>' . $rs->name . '</option>';
    }
  }

  return $ds;
}


function select_department($id = NULL)
{
  $ci =& get_instance();
  $ci->load->model('masters/department_model');
  $list = $ci->department_model->get_all();

  $ds = "";

  if (!empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= '<option value="' . $rs->id . '" ' . is_selected($rs->id, $id) . '>' . $rs->name . '</option>';
    }
  }

  return $ds;
}


function employee_status_text($status)
{
  $statusText = [
    'normal' => 'ปกติ',
    'resign' => 'ลาออก',
    'suspend' => 'พักงาน',
    'probation' => 'ทดลองงาน',
    'retire' => 'เกษียณ',
    'terminate' => 'เลิกจ้าง'
  ];

  return  isset($statusText[$status]) ? $statusText[$status] : 'ไม่ระบุ';
}


function select_employment_status($status = NULL)
{
  $list = [
    'normal' => 'ปกติ',
    'resign' => 'ลาออก',
    'suspend' => 'พักงาน',
    'probation' => 'ทดลองงาน',
    'retire' => 'เกษียณ',
    'terminate' => 'เลิกจ้าง'
  ];

  $ds = "";

  if (!empty($list))
  {
    foreach ($list as $code => $name)
    {
      $ds .= '<option value="' . $code . '" ' . is_selected($code, $status) . '>' . $name . '</option>';
    }
  }

  return $ds;
}
