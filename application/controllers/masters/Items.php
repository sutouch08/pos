<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Items extends PS_Controller
{
  public $menu_code = 'DBITEM';
  public $menu_group_code = 'DB';
  public $menu_sub_group_code = 'PRODUCT';
  public $title = 'เพิ่ม/แก้ไข รายการสินค้า';
  public $segment = 4;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url() . 'masters/items';

    //--- load model
    $this->load->model('masters/items_model');

    $this->load->helper('product_color');
    $this->load->helper('product_size');
    $this->load->helper('product_group');
    $this->load->helper('product_main_group');
    $this->load->helper('product_gender');
    $this->load->helper('product_kind');
    $this->load->helper('product_type');
    $this->load->helper('product_category');
    $this->load->helper('product_brand');
    $this->load->helper('unit');
    $this->load->helper('vat');
  }


  public function index()
  {
    $filter = array(
      'code' => get_filter('code', 'item_code', ''),
      'name' => get_filter('name', 'item_name', ''),
      'barcode' => get_filter('barcode', 'item_barcode', ''),
      'style' => get_filter('style', 'item_style', ''),
      'color' => get_filter('color', 'item_color', ''),
      'size' => get_filter('size', 'item_size', ''),
      'group' => get_filter('group', 'item_group', 'all'),
      'main_group' => get_filter('main_group', 'item_main_group', 'all'),
      'kind' => get_filter('kind', 'item_kind', 'all'),
      'type' => get_filter('type', 'item_type', 'all'),
      'category' => get_filter('category', 'item_category', 'all'),
      'brand' => get_filter('brand', 'item_brand', 'all'),
      'year' => get_filter('year', 'item_year', 'all'),
      'active' => get_filter('active', 'item_active', 'all')
    );

    if ($this->input->post('search'))
    {
      redirect($this->home);
    }
    else
    {
      $perpage = get_rows();
      $rows = $this->items_model->count_rows($filter);
      $filter['data'] = $this->items_model->get_list($filter, $perpage, $this->uri->segment($this->segment));
      $init = pagination_config($this->home . '/index/', $rows, $perpage, $this->segment);
      $this->pagination->initialize($init);
      $this->load->view('masters/items/items_list', $filter);
    }
  }


  public function add_new()
  {
    $this->load->model('users/permission_model', 'perm');

    $ds = array(
      'can_add_color' => $this->perm->can_add('DBPDCL', $this->_user->id_profile),
      'can_add_size' => $this->perm->can_add('DBPDSI', $this->_user->id_profile),
      'can_add_group' => $this->perm->can_add('DBPDGP', $this->_user->id_profile),
      'can_add_main_group' => $this->perm->can_add('DBPDMG', $this->_user->id_profile),
      'can_add_gender' => $this->perm->can_add('DBPDGD', $this->_user->id_profile),
      'can_add_kind' => $this->perm->can_add('DBPDKN', $this->_user->id_profile),
      'can_add_type' => $this->perm->can_add('DBPDTY', $this->_user->id_profile),
      'can_add_category' => $this->perm->can_add('DBPDCR', $this->_user->id_profile),
      'can_add_brand' => $this->perm->can_add('DBPDBR', $this->_user->id_profile),
      'can_add_unit' => $this->perm->can_add('DBPUOM', $this->_user->id_profile),
      'default_unit_group' => getConfig('DEFAULT_UNIT_GROUP')
    );

    $this->load->view('masters/items/items_add', $ds);
  }


  public function add()
  {
    $sc = TRUE;

    if ($this->pm->can_add)
    {
      $ds = json_decode(file_get_contents('php://input'));

      if (!empty($ds) && ! empty($ds->code) && ! empty($ds->name) && ! empty($ds->unit))
      {
        if ($this->items_model->is_exists_code($ds->code))
        {
          $sc = FALSE;
          set_error('exists', $ds->code);
        }

        if ($sc === TRUE && $this->items_model->is_exists_name($ds->name))
        {
          $sc = FALSE;
          set_error('exists', $ds->name);
        }

        if ($sc === TRUE && ! empty($ds->barcode) && $this->items_model->is_exists_barcode($ds->barcode))
        {
          $sc = FALSE;
          set_error('exists', $ds->barcode);
        }

        $this->load->model('masters/product_style_model');

        $style = ! empty($ds->style) ? $ds->style : NULL;
        $style_id = empty($style) ? NULL : $this->items_model->get_id($style);

        if ($sc === TRUE)
        {
          $arr = array(
            'code' => $ds->code,
            'name' => $ds->name,
            'style_id' => get_null($style_id),
            'style_code' => empty($style_id) ? NULL : $style,
            'barcode' => get_null($ds->barcode),
            'cost' => $ds->cost,
            'price' => $ds->price,
            'unit_group_id' => get_null($ds->unit_group),
            'unit_id' => $ds->unit,
            'purchase_vat_code' => $ds->purchase_vat_code,
            'purchase_vat_rate' => $ds->purchase_vat_rate,
            'sale_vat_code' => $ds->sale_vat_code,
            'sale_vat_rate' => $ds->sale_vat_rate,
            'count_stock' => $ds->count_stock,
            'can_sell' => $ds->can_sell,
            'active' => $ds->active,
            'color_id' => get_null($ds->color),
            'size_id' => get_null($ds->size),
            'main_group_id' => get_null($ds->main_group),
            'group_id' => get_null($ds->group),
            'gender_id' => get_null($ds->gender),
            'kind_id' => get_null($ds->kind),
            'type_id' => get_null($ds->type),
            'category_id' => get_null($ds->category),
            'brand_id' => get_null($ds->brand),
            'year' => get_null($ds->year),
            'user' => $this->_user->uname
          );

          if (! $this->items_model->add($arr))
          {
            $sc = FALSE;
            set_error('insert');
          }
        }
        else
        {
          $sc = FALSE;
          set_error('required');
        }
      }
      else
      {
        $sc = FALSE;
        set_error('permission');
      }

      $this->_response($sc);
    }
  }


  public function is_exists_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (!empty($ds) && !empty($ds->code))
    {
      $code = $ds->code;
      $exists = $this->items_model->is_exists_code($code);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function is_exists_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (!empty($ds) && !empty($ds->name))
    {
      $name = $ds->name;
      $exists = $this->items_model->is_exists_name($name);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function is_exists_barcode()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (!empty($ds) && isset($ds->barcode) && $ds->barcode != '')
    {
      $barcode = $ds->barcode;
      $exists = $this->items_model->is_exists_barcode($barcode);
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }

  public function is_exists_attribute_code()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (!empty($ds) && !empty($ds->attribute) && !empty($ds->code))
    {
      $attribute = $ds->attribute;
      $code = $ds->code;

      switch ($attribute)
      {
        case 'color':
          $this->load->model('masters/product_color_model');
          $exists = $this->product_color_model->is_exists_code($code);
          break;

        case 'size':
          $this->load->model('masters/product_size_model');
          $exists = $this->product_size_model->is_exists_code($code);
          break;

        case 'group':
          $this->load->model('masters/product_group_model');
          $exists = $this->product_group_model->is_exists_code($code);
          break;

        case 'main-group':
          $this->load->model('masters/product_main_group_model');
          $exists = $this->product_main_group_model->is_exists_code($code);
          break;

        case 'gender':
          $this->load->model('masters/product_gender_model');
          $exists = $this->product_gender_model->is_exists_code($code);
          break;

        case 'kind':
          $this->load->model('masters/product_kind_model');
          $exists = $this->product_kind_model->is_exists_code($code);
          break;

        case 'type':
          $this->load->model('masters/product_type_model');
          $exists = $this->product_type_model->is_exists_code($code);
          break;

        case 'category':
          $this->load->model('masters/product_category_model');
          $exists = $this->product_category_model->is_exists_code($code);
          break;

        case 'brand':
          $this->load->model('masters/product_brand_model');
          $exists = $this->product_brand_model->is_exists_code($code);
          break;
      }
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function is_exists_attribute_name()
  {
    $exists = FALSE;
    $ds = json_decode(file_get_contents('php://input'));

    if (!empty($ds) && !empty($ds->attribute) && !empty($ds->name))
    {
      $attribute = $ds->attribute;
      $name = $ds->name;

      switch ($attribute)
      {
        case 'color':
          $this->load->model('masters/product_color_model');
          $exists = $this->product_color_model->is_exists_name($name);
          break;

        case 'size':
          $this->load->model('masters/product_size_model');
          $exists = $this->product_size_model->is_exists_name($name);
          break;

        case 'group':
          $this->load->model('masters/product_group_model');
          $exists = $this->product_group_model->is_exists_name($name);
          break;

        case 'main-group':
          $this->load->model('masters/product_main_group_model');
          $exists = $this->product_main_group_model->is_exists_name($name);
          break;

        case 'gender':
          $this->load->model('masters/product_gender_model');
          $exists = $this->product_gender_model->is_exists_name($name);
          break;

        case 'kind':
          $this->load->model('masters/product_kind_model');
          $exists = $this->product_kind_model->is_exists_name($name);
          break;

        case 'type':
          $this->load->model('masters/product_type_model');
          $exists = $this->product_type_model->is_exists_name($name);
          break;

        case 'category':
          $this->load->model('masters/product_category_model');
          $exists = $this->product_category_model->is_exists_name($name);
          break;

        case 'brand':
          $this->load->model('masters/product_brand_model');
          $exists = $this->product_brand_model->is_exists_name($name);
          break;
      }
    }

    echo $exists === TRUE ? 'exists' : 'not_exists';
  }


  public function add_attribute()
  {
    $sc = TRUE;
    $this->load->model('users/permission_model', 'perm');
    $res = NULL;
    $attr = $this->input->post('attribute');
    $ds = json_decode($this->input->post('data'));

    if (!empty($attr) && !empty($ds) && ! empty($ds->code) && !empty($ds->name))
    {
      switch ($attr)
      {
        case 'color':
          if ($this->perm->can_add('DBPDCL', $this->_user->id_profile))
          {
            $res = $this->add_color($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add color');
          }

          break;

        case 'size':
          if ($this->perm->can_add('DBPDSI', $this->_user->id_profile))
          {
            $res = $this->add_size($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add size');
          }

          break;

        case 'group':
          if ($this->perm->can_add('DBPDGP', $this->_user->id_profile))
          {
            $res = $this->add_group($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add group');
          }

          break;

        case 'main-group':
          if ($this->perm->can_add('DBPDMG', $this->_user->id_profile))
          {
            $res = $this->add_main_group($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add main group');
          }

          break;

        case 'gender':
          if ($this->perm->can_add('DBPDGD', $this->_user->id_profile))
          {
            $res = $this->add_gender($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add gender');
          }

          break;

        case 'kind':
          if ($this->perm->can_add('DBPDKN', $this->_user->id_profile))
          {
            $res = $this->add_kind($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add kind');
          }

          break;

        case 'type':
          if ($this->perm->can_add('DBPDTY', $this->_user->id_profile))
          {
            $res = $this->add_type($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add type');
          }

          break;

        case 'category':
          if ($this->perm->can_add('DBPDCR', $this->_user->id_profile))
          {
            $res = $this->add_category($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add category');
          }

          break;

        case 'brand':
          if ($this->perm->can_add('DBPDBR', $this->_user->id_profile))
          {
            $res = $this->add_brand($ds);
          }
          else
          {
            $sc = FALSE;
            set_error('You do not have permission to add brand');
          }

          break;
      }

      if (! $res)
      {
        $sc = FALSE;
        set_error('Failed to add new attribute');
      }
    }
    else
    {
      $sc = FALSE;
      set_error('required');
    }

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? 'Attribute added' : $this->error,
      'data' => $sc === TRUE ? $res : NULL
    );

    echo json_encode($arr);
  }


  private function add_color($ds)
  {
    $this->load->model('masters/product_color_model');

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name,
        'group_id' => get_null($ds->group_id),
        'active' => 1
      );
      $id = $this->product_color_model->add($arr);

      if ($id)
      {
        $res = $this->product_color_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_size($ds)
  {
    $this->load->model('masters/product_size_model');

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name,
        'group_id' => get_null($ds->group_id)
      );

      $id = $this->product_size_model->add($arr);

      if ($id)
      {
        $res = $this->product_size_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_main_group($ds)
  {
    $this->load->model('masters/product_main_group_model');

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_main_group_model->add($arr);

      if ($id)
      {
        $res = $this->product_main_group_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_group($ds)
  {
    $this->load->model('masters/product_group_model');

    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_group_model->add($arr);

      if ($id)
      {
        $res = $this->product_group_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_gender($ds)
  {
    $this->load->model('masters/product_gender_model');
    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_gender_model->add($arr);

      if ($id)
      {
        $res = $this->product_gender_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_category($ds)
  {
    $this->load->model('masters/product_category_model');
    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_category_model->add($arr);

      if ($id)
      {
        $res = $this->product_category_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_kind($ds)
  {
    $this->load->model('masters/product_kind_model');
    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_kind_model->add($arr);

      if ($id)
      {
        $res = $this->product_kind_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_type($ds)
  {
    $this->load->model('masters/product_type_model');
    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_type_model->add($arr);

      if ($id)
      {
        $res = $this->product_type_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  private function add_brand($ds)
  {
    $this->load->model('masters/product_brand_model');
    if (! empty($ds) && ! empty($ds->code) && ! empty($ds->name))
    {
      $arr = array(
        'code' => $ds->code,
        'name' => $ds->name
      );

      $id = $this->product_brand_model->add($arr);

      if ($id)
      {
        $res = $this->product_brand_model->get($id);

        if (! empty($res))
        {
          $res->name = $res->code . ' | ' . $res->name;
        }

        return $res;
      }

      return FALSE;
    }

    $this->error = "Missing required fields";
    return FALSE;
  }


  public function get_units_by_group()
  {
    $sc = TRUE;
    $ds = json_decode(file_get_contents('php://input'));
    $options = '<option value="">เลือก</option>';

    if (! empty($ds) && ! empty($ds->group_id) && isset($ds->unit_id))
    {
      $options .= select_unit_by_group($ds->group_id, get_null($ds->unit_id));
    }
    else
    {
      $sc = FALSE;
      set_error('Invalid unit group');
    }

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? '' : $this->error,
      'options' => $sc === TRUE ? $options : NULL
    );

    echo json_encode($arr);
  }


  public function clear_filter()
  {
    $filter = array(
      'item_code',
      'item_name',
      'item_barcode',
      'item_style',
      'item_color',
      'item_size',
      'item_group',
      'item_main_group',
      'item_kind',
      'item_type',
      'item_category',
      'item_brand',
      'item_year',
      'item_active'
    );

    return clear_filter($filter);
  }
}
