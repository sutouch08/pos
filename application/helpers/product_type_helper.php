<?php
  function select_product_type($id = NULL)
  {
    $ds = '';
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    $list = $ci->product_type_model->get_all();

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


  function type_code_array()
  {
    $arr = array();
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    $list = $ci->product_type_model->get_all();

    if(!empty($list))
    {
      foreach($list as $rs)
      {
        $arr[$rs->code] = $rs;
      }
    }

    return $arr;
  }


  function type_array()
  {
    $arr = array();
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    $list = $ci->product_type_model->get_all();

    if(!empty($list))
    {
      foreach($list as $rs)
      {
        $arr[$rs->id] = $rs;
      }
    }

    return $arr;
  }

  function type_name($id)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    return $ci->product_type_model->get_name($id);
  }

  function type_name_by_code($code)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    return $ci->product_type_model->get_name_by_code($code);
  }

  function type_code($id)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    return $ci->product_type_model->get_code($id);
  }

  function type_id($code)
  {
    $ci =& get_instance();
    $ci->load->model('masters/product_type_model');
    return $ci->product_type_model->get_id($code);
  }

