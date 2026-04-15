<?php
function select_product_category($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_category_model');
  $list = $ci->product_category_model->get_all();

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
