<?php
function select_product_main_group($id = NULL)
{
  $ds = '';
  $ci =& get_instance();
  $ci->load->model('masters/product_main_group_model');
  $list = $ci->product_main_group_model->get_all();

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
