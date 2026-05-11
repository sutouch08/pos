<?php
function select_unit($id = NULL)
{
  $ds = "";

  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $units = $ci->unit_model->get_all();

  if(!empty($units))
  {
    foreach($units as $unit)
    {
      $selected = strval($id) == strval($unit->id) ? 'selected' : '';
      $ds .= '<option value="'.$unit->id.'" data-code="'.$unit->code.'" '.$selected.'>'.$unit->name.'</option>';
    }
  }

  return $ds;
}


function select_unit_group($id = NULL)
{
  $ds = "";

  $ci =& get_instance();
  $ci->load->model('masters/unit_group_model');
  $groups = $ci->unit_group_model->get_all();

  if(!empty($groups))
  {
    foreach($groups as $group)
    {
      $selected = strval($id) == strval($group->id) ? 'selected' : '';
      $ds .= '<option value="'.$group->id.'" '.$selected.'>'.$group->name.'</option>';
    }
  }

  return $ds;
}


function select_unit_by_group ($group_id, $id = NULL)
{
  $ds = "";

  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $units = $ci->unit_model->get_all_by_group($group_id);

  if(!empty($units))
  {
    foreach($units as $unit)
    {
      $selected = strval($id) == strval($unit->id) ? 'selected' : '';
      $ds .= '<option value="'.$unit->id.'" data-code="'.$unit->code.'" '.$selected.'>'.$unit->name.'</option>';
    }
  }

  return $ds;
}


function unit_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $unit = $ci->unit_model->get_by_id($id);

  return $unit ? $unit->name : '';
}


function unit_name_by_code($code)
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $unit = $ci->unit_model->get_by_code($code);

  return $unit ? $unit->name : ''; 
}


function unit_code($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $unit = $ci->unit_model->get_by_id($id);

  return $unit ? $unit->code : '';
}


function unit_code_array()
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $units = $ci->unit_model->get_all();

  $arr = array();

  if(!empty($units))
  {
    foreach($units as $unit)
    {
      $arr[$unit->code] = $unit;
    }
  }

  return $arr;
}


function unit_array()
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_model');
  $units = $ci->unit_model->get_all();

  $arr = array();

  if(!empty($units))
  {
    foreach($units as $unit)
    {
      $arr[$unit->id] = $unit;
    }
  }

  return $arr;
}


function unit_group_array()
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_group_model');
  $groups = $ci->unit_group_model->get_all();

  $arr = array();

  if(!empty($groups))
  {
    foreach($groups as $group)
    {
      $arr[$group->id] = $group;
    }
  }

  return $arr;
}


function unit_group_code_array()
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_group_model');
  $groups = $ci->unit_group_model->get_all();

  $arr = array();

  if(!empty($groups))
  {
    foreach($groups as $group)
    {
      $arr[$group->code] = $group;
    }
  }

  return $arr;
}


function unit_group_name($id)
{
  $ci =& get_instance();
  $ci->load->model('masters/unit_group_model');
  $group = $ci->unit_group_model->get_by_id($id);

  return $group ? $group->name : '';
}

 ?>
