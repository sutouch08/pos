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


 ?>
