<?php
  function select_product_gender($id = NULL)
  {
    $ds = '';
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    $list = $ci->product_gender_model->get_all();

    if(!empty($list))
    {
      foreach($list as $rs)
      {
        $selected = strval($id) === strval($rs->id) ? 'selected' : '';
        $ds .= '<option value="'.$rs->id.'" '.$selected.'>'.$rs->code.' | '.$rs->name.'</option>';
      }
    }

    return $ds;
  }

  function gender_code_array()
  {
    $arr = array();
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    $list = $ci->product_gender_model->get_all();

    if(!empty($list))
    {
      foreach($list as $rs)
      {
        $arr[$rs->code] = $rs;
      }
    }

    return $arr;
  }

  function gender_array()
  {
    $arr = array();
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    $list = $ci->product_gender_model->get_all();

    if(!empty($list))
    {
      foreach($list as $rs)
      {
        $arr[$rs->id] = $rs;
      }
    }

    return $arr;
  }

  function gender_name($id)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    return $ci->product_gender_model->get_name($id);
  }

  function gender_name_by_code($code)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    return $ci->product_gender_model->get_name_by_code($code);
  }

  function gender_code($id)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    return $ci->product_gender_model->get_code($id);
  }

  function gender_id($code)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_gender_model');
    return $ci->product_gender_model->get_id($code);
  }