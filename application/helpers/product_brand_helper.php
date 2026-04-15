<?php 
function select_product_brand($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_brand_model');
  $list = $ci->product_brand_model->get_all();

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