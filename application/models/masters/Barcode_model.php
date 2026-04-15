<?php 
class Barcode_model extends CI_Model
{
  private $tb = "barcode";

  public function __construct()
  {
    parent::__construct();
  }

  
  public function is_unique_exists($barcode, $product_code, $unit_id)
  {
    $this->db->where('barcode', $barcode);
    $this->db->where('product_code', $product_code);
    $this->db->where('unit_id', $unit_id);
    
    return $this->db->count_all_results($this->tb) > 0;
  }


  public function add(array $ds = array())
  {
    if (!empty($ds))
    {
      return $this->db->insert($this->tb, $ds);
    }

    return FALSE;
  }


  public function update($id, array $ds = array())
  {
    if (!empty($ds))
    {
      return $this->db->where('id', $id)->update($this->tb, $ds);
    }

    return FALSE;
  }


  public function delete($id)
  {
    return $this->db->where('id', $id)->delete($this->tb);
  }


  public function get($barcode)
  {
    $rs = $this->db->where('barcode', $barcode)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_by_item($code)
  {
    $rs = $this->db->where('product_code', $code)->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_by_unit($code, $unit_id)
  {
    $rs = $this->db->where('product_code', $code)->where('unit_id', $unit_id)->get($this->tb);

    if ($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }
  
}
