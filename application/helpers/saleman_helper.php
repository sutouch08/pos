<?php

function select_saleman($id = NULL)
{
  $ds = "";
  $active = TRUE; // get only active rows
  $ci =& get_instance();
  $ci->load->model('masters/slp_model');
  $list = $ci->slp_model->get_all($active);

  if (!empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= '<option value="' . $rs->id . '" ' . is_selected($rs->id, $id) . '>' . $rs->name . '</option>';
    }
  }

  return $ds;
}


function sale_name($id)
{
  $ci = &get_instance();
  $ci->load->model('masters/slp_model');
  return $ci->slp_model->get_name($id);
}


function sale_name_array()
{
  $ds = array();
  $active = FALSE; // get all not only active rows
  $ci =& get_instance();
  $ci->load->model('masters/slp_model');
  $list = $ci->slp_model->get_all($active);

  if (! empty($list))
  {
    foreach ($list as $rs)
    {
      $ds[$rs->id] = $rs->name;
    }
  }

  return $ds;
}
