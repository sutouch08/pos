<?php
class Items_model extends CI_Model
{
  private $tb = "products";

  public function __construct()
  {
    parent::__construct();
  }


  public function count_rows(array $ds = array())
  {
    $this->db    
    ->from($this->tb.' AS i')
    ->join('product_style AS s', 'i.style_id = s.id', 'left')
    ->join('product_color AS co', 'i.color_id = co.id', 'left')
    ->join('product_size AS si', 'i.size_id = si.id', 'left');

    if(!empty($ds['code']))
    {
      $this->db->like('i.code', $ds['code']);
    }

    if(!empty($ds['name']))
    {
      $this->db->like('i.name', $ds['name']);
    }

    if(isset($ds['barcode']) && $ds['barcode'] != '')
    {
      $this->db->like('i.barcode', $ds['barcode']);
    }

    if(!empty($ds['style']))
    {
      $this->db->like('s.code', $ds['style']);
    }

    if(!empty($ds['group']) && $ds['group'] !== 'all')
    {
      $this->db->where('i.group_id', $ds['group']);
    }

    if(!empty($ds['main_group']) && $ds['main_group'] !== 'all')
    {
      $this->db->where('i.main_group_id', $ds['main_group']);
    }

    if(!empty($ds['kind']) && $ds['kind'] !== 'all')
    {
      $this->db->where('i.kind_id', $ds['kind']);
    }

    if(!empty($ds['type']) && $ds['type'] !== 'all')
    {
      $this->db->where('i.type_id', $ds['type']);
    }

    if(!empty($ds['category']) && $ds['category'] !== 'all')
    {
      $this->db->where('i.category_id', $ds['category']);
    }

    if(!empty($ds['brand']) && $ds['brand'] !== 'all')
    {
      $this->db->where('i.brand_id', $ds['brand']);
    }

    if(!empty($ds['year']) && $ds['year'] !== 'all')
    {
      $this->db->where('i.year', $ds['year']);
    }

    if(isset($ds['active']) && $ds['active'] !== 'all')
    {
      if($ds['active'] == 1)
      {
        $this->db->where('i.active', 1);
      }
      else
      {
        $this->db->where('i.active', 0);
      }
    }

    return $this->db->count_all_results();
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {  
    $this->db
    ->select('i.*, s.code AS style_code')
    ->select('co.code AS color_code, co.name AS color_name')
    ->select('si.code AS size_code, si.name AS size_name')
    ->select('g.name AS group_name')
    ->select('mg.name AS main_group_name')
    ->select('k.name AS kind_name')
    ->select('t.name AS type_name')
    ->select('c.name AS category_name')
    ->select('b.name AS brand_name')
    ->from($this->tb.' AS i')
    ->join('product_style AS s', 'i.style_id = s.id', 'left')
    ->join('product_color AS co', 'i.color_id = co.id', 'left')
    ->join('product_size AS si', 'i.size_id = si.id', 'left')
    ->join('product_group AS g', 'i.group_id = g.id', 'left')
    ->join('product_main_group AS mg', 'i.main_group_id = mg.id', 'left')
    ->join('product_kind AS k', 'i.kind_id = k.id', 'left')
    ->join('product_type AS t', 'i.type_id = t.id', 'left')
    ->join('product_category AS c', 'i.category_id = c.id', 'left')
    ->join('product_brand AS b', 'i.brand_id = b.id', 'left');

    if(!empty($ds['code']))
    {
      $this->db->like('i.code', $ds['code']);
    }

    if(!empty($ds['name']))
    {
      $this->db->like('i.name', $ds['name']);
    }

    if(isset($ds['barcode']) && $ds['barcode'] != '')
    {
      $this->db->like('i.barcode', $ds['barcode']);
    }

    if(!empty($ds['style']))
    {
      $this->db->like('s.code', $ds['style']);
    }

    if(!empty($ds['color']))
    {
      $this->db->like('co.code', $ds['color']);
    }

    if(!empty($ds['size']))
    {
      $this->db->like('si.code', $ds['size']);
    }

    if(!empty($ds['group']) && $ds['group'] !== 'all')
    {
      $this->db->where('i.group_id', $ds['group']);
    }

    if(!empty($ds['main_group']) && $ds['main_group'] !== 'all')
    {
      $this->db->where('i.main_group_id', $ds['main_group']);
    }

    if(!empty($ds['kind']) && $ds['kind'] !== 'all')
    {
      $this->db->where('i.kind_id', $ds['kind']);
    }

    if(!empty($ds['type']) && $ds['type'] !== 'all')
    {
      $this->db->where('i.type_id', $ds['type']);
    }

    if(!empty($ds['category']) && $ds['category'] !== 'all')
    {
      $this->db->where('i.category_id', $ds['category']);
    }

    if(!empty($ds['brand']) && $ds['brand'] !== 'all')
    {
      $this->db->where('i.brand_id', $ds['brand']);
    }

    if(!empty($ds['year']) && $ds['year'] !== 'all')
    {
      $this->db->where('i.year', $ds['year']);
    }

    if(isset($ds['active']) && $ds['active'] !== 'all')
    {
      if($ds['active'] == 1)
      {
        $this->db->where('i.active', 1);
      }
      else
      {
        $this->db->where('i.active', 0);
      }
    }
    
    $this->db->order_by('s.code', 'ASC');
    $this->db->order_by('co.code', 'ASC');
    $this->db->order_by('si.position', 'ASC');

    $rs = $this->db->limit($perpage, $offset)->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function is_exists_code($code, $id = NULL)
  {
    if(!empty($code))
    {
      $this->db->where('code', $code);

      if(!empty($id))
      {
        $this->db->where('id !=', $id);
      }

      return $this->db->count_all_results($this->tb) > 0;
    }

    return FALSE;
  }


  public function is_exists_name($name, $id = NULL)
  {
    if(!empty($name))
    {
      $this->db->where('name', $name);

      if(!empty($id))
      {
        $this->db->where('id !=', $id);
      }

      return $this->db->count_all_results($this->tb) > 0;
    }

    return FALSE;
  }


  public function is_exists_barcode($barcode, $id = NULL)
  {
    if(!empty($barcode))
    {
      $this->db->where('barcode', $barcode);

      if(!empty($id))
      {
        $this->db->where('id !=', $id);
      }

      return $this->db->count_all_results($this->tb) > 0;
    }

    return FALSE;
  }

} 
//---- End Class ----