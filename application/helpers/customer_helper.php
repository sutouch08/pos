<?php

function select_customer_group($code = NULL)
{
  $ds = "";
  $ci = &get_instance();
  $ci->load->model('masters/customer_group_model');
  $options = $ci->customer_group_model->get_all();

  if (!empty($options))
  {
    foreach ($options as $rs)
    {
      $ds .= '<option value="' . $rs->code . '" ' . is_selected(strval($code), strval($rs->code)) . '>' .$rs->code.' | '. $rs->name . '</option>';
    }
  }

  return $ds;
}


function select_customer_kind($code = NULL)
{
  $ds = '';
  $ci = &get_instance();
  $ci->load->model('masters/customer_kind_model');
  $options = $ci->customer_kind_model->get_all();

  if (!empty($options))
  {
    foreach ($options as $rs)
    {
      $ds .= '<option value="' . $rs->code . '" ' . is_selected(strval($code), strval($rs->code)) . '>' .$rs->code.' | '. $rs->name . '</option>';
    }
  }

  return $ds;
}


function select_customer_type($code = NULL)
{
  $ds = '';
  $ci = &get_instance();
  $ci->load->model('masters/customer_type_model');
  $options = $ci->customer_type_model->get_all();

  if (!empty($options))
  {
    foreach ($options as $rs)
    {
      $ds .= '<option value="' . $rs->code . '" ' . is_selected(strval($code), strval($rs->code)) . '>' .$rs->code.' | '. $rs->name . '</option>';
    }
  }

  return $ds;
}


function select_customer_class($code = NULL)
{
  $ds = '';
  $ci = &get_instance();
  $ci->load->model('masters/customer_class_model');
  $options = $ci->customer_class_model->get_all();

  if (!empty($options))
  {
    foreach ($options as $rs)
    {
      $ds .= '<option value="' . $rs->code . '" ' . is_selected(strval($code), strval($rs->code)) . '>' .$rs->code.' | '. $rs->name . '</option>';
    }
  }

  return $ds;
}


function select_customer_area($code = NULL)
{
  $ds = '';
  $ci = &get_instance();
  $ci->load->model('masters/customer_area_model');
  $options = $ci->customer_area_model->get_all();

  if (!empty($options))
  {
    foreach ($options as $rs)
    {
      $ds .= '<option value="' . $rs->code . '" ' . is_selected(strval($code), strval($rs->code)) . '>' .$rs->code.' | '. $rs->name . '</option>';
    }
  }

  return $ds;
}


function customer_in($txt)
{
  $ds = array('0');
  $ci = &get_instance();
  $ci->load->model('masters/customers_model');
  $rs = $ci->customers_model->search($txt);

  if (!empty($rs))
  {
    foreach ($rs as $cs)
    {
      $ds[] = $cs->code;
    }
  }

  return $ds;
}


function customer_attribute_name_array($table = NULL)
{
  $ds = [];

  if (! empty($table))
  {
    $tables = array(
      'group' => 'customer_group',
      'class' => 'customer_class',
      'grade' => 'customer_class',
      'kind' => 'customer_kind',
      'type' => 'customer_type',
      'area' => 'customer_area'
    );

    if (! empty($tables[$table]))
    {
      $tb = $tables[$table];
      $ci = &get_instance();
      $data = $ci->db->get($tb);

      if ($data->num_rows() > 0)
      {
        foreach ($data->result() as $rs)
        {
          $ds[$rs->code] = $rs->name;
        }
      }
    }
  }

  return $ds;
}


function customer_attribute_name($code, array $ds = array())
{
  $code = empty($code) ? '' : $code;
  return empty($ds[$code]) ? $code : $ds[$code];
}


function select_customer_code_prefix($code = NULL)
{
  $ds = '';
  $ci = &get_instance();
  $ci->load->model('masters/customers_model');
  $list = $ci->customers_model->get_prefix_list();

  if (! empty($list))
  {
    foreach ($list as $rs)
    {
      $ds .= '<option value="' . $rs->code . '" ' . is_selected(strval($code), strval($rs->code)) . '>' . $rs->code . '</option>';
    }
  }

  return $ds;
}
