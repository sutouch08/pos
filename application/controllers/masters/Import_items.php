<?php
// require_once FCPATH . 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\IOFactory;

class Import_items extends CI_Controller
{
  public $_user;
  public $error;
  public $home;

  function __construct()
  {
    parent::__construct();
    $uid = get_cookie('uid');
    $this->_user = $this->user_model->get_by_uid($uid);
    $this->home = base_url() . 'masters/items';
    $this->load->model('masters/items_model');
    $this->load->model('masters/product_style_model');
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
    $sc = TRUE;
    $imported = 0; //-- count imported rows
    $added = 0; //-- count added rows
    $updated = 0; //-- count updated rows
    $error = 0; //-- count error rows for error message

    $file = isset($_FILES['uploadFile']) ? $_FILES['uploadFile'] : FALSE;
    $path = $this->config->item('upload_file_path') . 'items/';
    $file  = 'uploadFile';
    $config = array(
      "allowed_types" => "xlsx",
      "upload_path" => $path,
      "file_name"  => "import-items-" . date('YmdHis') . ".xlsx",
      "max_size" => 5120,
      "overwrite" => TRUE
    );

    $this->load->library("upload", $config);

    if (! $this->upload->do_upload($file))
    {
      $sc = FALSE;
      $this->error = $this->upload->display_errors();
    }
    else
    {
      $info = $this->upload->data();
      $this->load->library('excel');
      $excel = PHPExcel_IOFactory::load($info['full_path']);
      $excel->setActiveSheetIndex(0);
      $sheet = $excel->getSheet(0);
      //$spreadsheet = IOFactory::load($info['full_path']);
      $collection  = $sheet->toArray(NULL, TRUE, TRUE, TRUE);
      $i = 1;
      $count = count($collection);
      $limit = intval(getConfig('IMPORT_ROWS_LIMIT')) + 1;

      if ($count <= $limit)
      {
        $firstRow = $collection[1]; //--- get header row for validate file format        

        if (!empty($firstRow))
        {
          $expectedHeader = array(
            'A' => 'ItemCode',
            'B' => 'ItemName',
            'C' => 'Barcode',
            'D' => 'ItemCost',
            'E' => 'ItemPrice',
            'F' => 'UnitCode',
            'G' => 'UnitGroup',
            'H' => 'SaleVatCode',
            'I' => 'PurchaseVatCode',
            'J' => 'InventoryItem',
            'K' => 'SaleItem',
            'L' => 'PurchaseItem',
            'M' => 'Active',
            'N' => 'ModelCode',
            'O' => 'MainGroupCode',
            'P' => 'GroupCode',
            'Q' => 'GenderCode',
            'R' => 'CategoryCode',
            'S' => 'KindCode',
            'T' => 'TypeCode',
            'U' => 'BrandCode',
            'V' => 'ColorCode',
            'W' => 'SizeCode',
            'X' => 'ItemYear',
            'Y' => 'UseBatch'
          );

          foreach ($expectedHeader as $col => $header)
          {
            if ($firstRow[$col] !== $header)
            {
              $sc = FALSE;
              $this->error = "Column {$col} should be {$header}";
              break;
            }
          }
        }
        else
        {
          $sc = FALSE;
          $this->error = "The first row of the file is empty. Please make sure the file format is correct.";
        }

        if ($sc === TRUE)
        {
          //--- remove header row
          array_shift($collection);
          $ds = $this->parseCollection($collection);

          if ($ds === FALSE)
          {
            $sc = FALSE;
          }
          else
          {
            foreach ($ds as $arr)
            {
              $id = $this->items_model->get_id($arr['code']);

              if (! $id)
              {
                $arr['create_by'] = $this->_user->id;
                if (! $this->items_model->add($arr))
                {
                  $error++;
                  $this->error .= "Failed to import item : {$arr['code']} <br>";
                }
                else
                {
                  $added++;
                }
              }
              else
              {
                $arr['update_by'] = $this->_user->id;
                
                if (! $this->items_model->update($id, $arr))
                {
                  $error++;
                  $this->error .= "Failed to update item : {$arr['code']} <br>";
                }
                else
                {
                  $updated++;
                }
              }

              $imported++;
            }
          }
        } //-- end foreach        
      }
      else
      {
        $sc = FALSE;
        $this->error = "จำนวนนำเข้าสูงสุดได้ไม่เกิน {$limit} บรรทัด";
      } //-- end if count limit
    } //--- end if else

    $message = "ทั้งหมด: {$imported} <br> เพิ่ม: {$added}<br> แก้ไข: {$updated}<br> ข้อผิดพลาด: {$error}<br>";
    $message .= $this->error;

    $arr = array(
      'status' => $sc === TRUE ? 'success' : 'error',
      'message' => $sc === TRUE ? $message : $this->error
    );

    echo json_encode($arr);
  }


  public function parseCollection(array $collection = array())
  {
    $ds = []; //--- temp array for import data
    $err = 0; //-- count error rows for error message

    if (empty($collection))
    {
      $this->error = "No data to import";
      return FALSE;
    }

    if (! empty($collection))
    {
      $styles = []; //--- temp array for style code and id
      $units = unit_code_array(); //--- temp array for unit code and id
      $unitGroups = unit_group_code_array(); //--- temp array for unit group code and id
      $mainGroups = main_group_code_array(); //--- temp array for main group code and id
      $groups = group_code_array(); //--- temp array for group code and id
      $genders = gender_code_array(); //--- temp array for gender code and id
      $categories = category_code_array(); //--- temp array for category code and id
      $kinds = kind_code_array(); //--- temp array for kind code and id
      $types = type_code_array(); //--- temp array for type code and id
      $brands = brand_code_array(); //--- temp array for brand code and id
      $colors = color_code_array(); //--- temp array for color code and id
      $sizes = size_code_array(); //--- temp array for size code and id
      $sv = sale_vat_code_array(); //--- temp array for sale vat code and id
      $pv = purchase_vat_code_array(); //--- temp array for purchase vat code and id

      $dfSaleVatCode = getConfig('DEFAULT_SALE_VAT_CODE');
      $dfPurchaseVatCode = getConfig('DEFAULT_PURCHASE_VAT_CODE');
      $dfUnitCode = getConfig('DEFAULT_UNIT_CODE');
      $dfUnitGroupCode = getConfig('DEFAULT_UNIT_GROUP_CODE');

      $pattern = '/^[a-zA-Z0-9\*\-\_@]+$/'; //--- pattern for code validation 

      $i = 2; //--- start from row 2 because row 1 is header
      foreach ($collection as $rs)
      {
        $sc = TRUE; //--- flag for check if the row is valid for import

        if (empty(trim((string)$rs['A'])) && empty(trim((string)$rs['B'])))
        {
          //--- skip empty row
          $sc = FALSE;
          $err++;
          $this->error .= "Row {$i} is empty or missing required fields. <br>";
          $i++;
          continue;
        }

        $code = str_replace(["\n", "\r"], '', trim((string)$rs['A'])); //--- เอาตัวขึ้นบรรทัดใหม่ออก            
        $name = str_replace(["\n", "\r"], '', trim((string)$rs['B']));
        $barcode = empty($rs['C']) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['C']));
        $cost = floatval(trim((string)$rs['D']));
        $price = floatval(trim((string)$rs['E']));
        $unitCode = empty(trim((string)$rs['F'])) ? $dfUnitCode : str_replace(["\n", "\r"], '', trim((string)$rs['F']));
        $unitGroup = empty(trim((string)$rs['G'])) ? $dfUnitGroupCode : str_replace(["\n", "\r"], '', trim((string)$rs['G']));
        $saleVatCode = empty(trim((string)$rs['H'])) ? $dfSaleVatCode : str_replace(["\n", "\r"], '', trim((string)$rs['H']));
        $purchaseVatCode = empty(trim((string)$rs['I'])) ? $dfPurchaseVatCode : str_replace(["\n", "\r"], '', trim((string)$rs['I']));
        $inventoryItem = trim((string)$rs['J']) === 'N' ? 0 : 1;
        $saleItem = trim((string)$rs['K']) === 'N' ? 0 : 1;
        $purchaseItem = trim((string)$rs['L']) === 'N' ? 0 : 1;
        $active = trim((string)$rs['M']) === 'N' ? 0 : 1;
        $styleCode = empty(trim((string)$rs['N'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['N']));
        $mainGroupCode = empty(trim((string)$rs['O'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['O']));
        $groupCode = empty(trim((string)$rs['P'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['P']));
        $genderCode = empty(trim((string)$rs['Q'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['Q']));
        $categoryCode = empty(trim((string)$rs['R'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['R']));
        $kindCode = empty(trim((string)$rs['S'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['S']));
        $typeCode = empty(trim((string)$rs['T'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['T']));
        $brandCode = empty(trim((string)$rs['U'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['U']));
        $colorCode = empty(trim((string)$rs['V'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['V']));
        $sizeCode = empty(trim((string)$rs['W'])) ? NULL : str_replace(["\n", "\r"], '', trim((string)$rs['W']));
        $year = empty(trim((string)$rs['X'])) ? NULL : intval(trim((string)$rs['X']));
        $useBatch = trim((string)$rs['Y']) === 'Y' ? 1 : 0;

        if (!isValidPattern($code, $pattern))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Invalid Item Code : {$code} at cell A{$i} <br>";
        }

        //--- check attribute code 
        if (! empty($unitCode) && ! isset($units[$unitCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Unit : {$unitCode} does not exists at cell F{$i} <br>";
        }

        if (! empty($unitGroup) && ! isset($unitGroups[$unitGroup]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Unit Group : {$unitGroup} does not exists at cell G{$i} <br>";
        }

        if (! empty($saleVatCode) && ! isset($sv[$saleVatCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Sale Vat Code : {$saleVatCode} does not exists at cell H{$i} <br>";
        }

        if (! empty($purchaseVatCode) && ! isset($pv[$purchaseVatCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Purchase Vat Code : {$purchaseVatCode} does not exists at cell I{$i} <br>";
        }

        if (! empty($styleCode) && ! isset($styles[$styleCode]))
        {
          $style = $this->product_style_model->get_by_code($styleCode);

          if (empty($style))
          {
            $sc = FALSE;
            $err++;
            $this->error .= "Model : {$styleCode} does not exists at cell N{$i} <br>";
          }
          else
          {
            $styles[$styleCode] = $style;
          }
        }

        if (! empty($mainGroupCode) && ! isset($mainGroups[$mainGroupCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Main Group : {$mainGroupCode} does not exists at cell O{$i} <br>";
        }

        if (! empty($groupCode) && ! isset($groups[$groupCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Group : {$groupCode} does not exists at cell P{$i} <br>";
        }

        if (! empty($genderCode) && ! isset($genders[$genderCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Gender : {$genderCode} does not exists at cell Q{$i} <br>";
        }

        if (! empty($categoryCode) && ! isset($categories[$categoryCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Category : {$categoryCode} does not exists at cell R{$i} <br>";
        }

        if (! empty($kindCode) && ! isset($kinds[$kindCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Kind : {$kindCode} does not exists at cell S{$i} <br>";
        }

        if (! empty($typeCode) && ! isset($types[$typeCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Type : {$typeCode} does not exists at cell T{$i} <br>";
        }

        if (! empty($brandCode) && ! isset($brands[$brandCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Brand : {$brandCode} does not exists at cell U{$i} <br>";
        }

        if (! empty($colorCode) && ! isset($colors[$colorCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Color : {$colorCode} does not exists at cell V{$i} <br>";
        }

        if (! empty($sizeCode) && ! isset($sizes[$sizeCode]))
        {
          $sc = FALSE;
          $err++;
          $this->error .= "Size : {$sizeCode} does not exists at cell W{$i} <br>";
        }

        if ($sc === TRUE)
        {
          $ds[] = array(
            'code' => $code,
            'name' => $name,
            'style_id' => empty($styleCode) ? NULL : (isset($styles[$styleCode]) ? $styles[$styleCode]->id : NULL),
            'style_code' => get_null($styleCode),
            'barcode' => get_null($barcode),
            'cost' => $cost,
            'price' => $price,
            'unit_group_id' => isset($unitGroups[$unitGroup]) ? $unitGroups[$unitGroup]->id : NULL,
            'unit_id' => isset($units[$unitCode]) ? $units[$unitCode]->id : NULL,
            'purchase_vat_code' => $purchaseVatCode,
            'purchase_vat_rate' => $pv[$purchaseVatCode]->rate,
            'sale_vat_code' => $saleVatCode,
            'sale_vat_rate' => $sv[$saleVatCode]->rate,
            'inventoryItem' => $inventoryItem,
            'saleItem' => $saleItem,
            'purchaseItem' => $purchaseItem,
            'active' => $active,
            'color_id' => isset($colors[$colorCode]) ? $colors[$colorCode]->id : NULL,
            'size_id' => isset($sizes[$sizeCode]) ? $sizes[$sizeCode]->id : NULL,
            'main_group_id' => isset($mainGroups[$mainGroupCode]) ? $mainGroups[$mainGroupCode]->id : NULL,
            'group_id' => isset($groups[$groupCode]) ? $groups[$groupCode]->id : NULL,
            'gender_id' => isset($genders[$genderCode]) ? $genders[$genderCode]->id : NULL,
            'category_id' => isset($categories[$categoryCode]) ? $categories[$categoryCode]->id : NULL,
            'kind_id' => isset($kinds[$kindCode]) ? $kinds[$kindCode]->id : NULL,
            'type_id' => isset($types[$typeCode]) ? $types[$typeCode]->id : NULL,
            'brand_id' => isset($brands[$brandCode]) ? $brands[$brandCode]->id : NULL,
            'year' => get_null($year),
            'useBatch' => $useBatch
          );
        }

        $i++;
      } //--- end foreach

      if ($err > 0)
      {
        $this->error = "Found {$err} error(s) in the file. Please fix the errors and try again.<br>" . $this->error;
      }
      else if (empty($ds))
      {
        $this->error = "No valid data to import";
      }
      else
      {
        return $ds; //--- return data array for import
      }
    }
    else
    {
      $this->error = "No data to import";
    }

    return FALSE;
  }
}//--- end class