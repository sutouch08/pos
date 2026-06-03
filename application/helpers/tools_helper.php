<?php
function setToken($token)
{
	$ci = &get_instance();
	$cookie = array(
		'name' => 'file_download_token',
		'value' => $token,
		'expire' => 3600,
		'path' => '/'
	);

	return $ci->input->set_cookie($cookie);
}


function parsePhoneNumber($phone, $length = 10)
{
	$find = [" ", "-", "+"];
	$rep = ["", "", ""];
	$length = $length * -1;

	if ($phone != "")
	{
		$phone = trim((string)$phone);
		$phone = str_replace($find, $rep, $phone);
		$phone = substr($phone, $length);

		return $phone;
	}

	return NULL;
}


function parseSubDistrict($ad, $province)
{
	if (! empty($ad))
	{
		if ($province === "จ. กรุงเทพมหานคร" 
				OR $province === 'จังหวัดกรุงเทพมหานคร' 
				OR $province === 'กรุงเทพ' 
				OR $province === 'กรุงเทพฯ' 
				OR $province == 'กรุงเทพมหานคร' 
				OR $province == 'กทม' 
				OR $province == 'กทม.' 
				OR $province == 'ก.ท.ม.')
		{
			$find = [' ', 'แขวง'];
			$rep = ['', ''];
			$ad = str_replace($find, $rep, $ad);
			return substr_replace($ad, 'แขวง', 0, 0);
		}
		else
		{
			$find = [' ', 'ต.', 'ตำบล'];
			$rep = ['', '', ''];
			$ad = str_replace($find, $rep, $ad);
			return substr_replace($ad, 'ต. ', 0, 0);
		}
	}

	return NULL;
}


function parseAddress($ad, $sub_district, $district, $province, $postcode)
{
	$province = parseProvince($province);
	$address = $ad . " " . parseSubDistrict($sub_district, $province) . " " . parseDistrict($district, $province) . " " . $province . " " . $postcode;
	return $address;
}


function parseDistrict($ad, $province)
{
	if (! empty($ad))
	{
		if ($province === "จ. กรุงเทพมหานคร" 
				OR $province === 'จังหวัดกรุงเทพมหานคร' 
				OR $province === 'กรุงเทพ' 
				OR $province === 'กรุงเทพฯ' 
				OR $province == 'กรุงเทพมหานคร' 
				OR $province == 'กทม' 
				OR $province == 'กทม.' 
				OR $province == 'ก.ท.ม.')
		{
			$find = [' ', 'เขต'];
			$rep = ['', ''];
			$ad = str_replace($find, $rep, $ad);
			return substr_replace($ad, 'เขต ', 0, 0);
		}
		else
		{
			$find = [' ', 'อ.', 'อำเภอ'];
			$rep = ['', '', ''];
			$ad = str_replace($find, $rep, $ad);
			return substr_replace($ad, 'อ. ', 0, 0);
		}
	}

	return NULL;
}


function parseProvince($ad)
{
	if (! empty($ad))
	{
		$find = [' ', 'จ.', 'จังหวัด', '.'];
		$rep = ['', '', '', '.'];
		$ad = str_replace($find, $rep, $ad);

		if ($ad == 'จังหวัดกรุงเทพ' OR $ad == 'จังหวัดกรุงเทพฯ' OR $ad == 'จังหวัดกทม')
		{
			$ad = 'กรุงเทพมหานคร';
		}

		return "จ. " . $ad;
	}

	return NULL;
}


function escapeQuote($text)
{
	return $text === NULL ? '' : trim(str_replace('"', '&quot;', $text));
}


//---	ตัดข้อความแล้วเติม ... ข้างหลัง
function limitText($str, $length)
{
	$txt = '...';
	if (strlen($str) >= $length)
	{
		return mb_substr($str, 0, $length) . $txt;
	}
	else
	{
		return $str;
	}
}


function is_selected($val, $select)
{
	$val = strtolower(strval($val));
	$select = strtolower(strval($select));
	return $val === $select ? 'selected' : '';
}


function is_checked($val1, $val2)
{
	$val1 = strtolower(strval($val1));
	$val2 = strtolower(strval($val2));
	return $val1 === $val2 ? 'checked' : '';
}


function is_active($val, $showIcon = TRUE)
{
	$val = strtolower(strval($val));
	$icon = "";
	
	if(($val === '1' || $val === 'y'))
	{
		$icon = '<i class="fa fa-check fa-lg green" title="Active"></i>';
	} 
	else if($val === '-1')
	{
		$icon = '<i class="fa fa-minus-circle fa-lg red" title="Deleted"></i>';
	}
	else 
	{
		$icon = $showIcon ? '<i class="fa fa-times fa-lg red" title="Inactive"></i>' : '';
	}
	
	return $icon;
}


function get_filter($postName, $cookieName, $defaultValue = "")
{
	$ci = &get_instance();
	$sc = '';

	if ($ci->input->post($postName) !== NULL)
	{
		$sc = trim($ci->input->post($postName));
		$ci->input->set_cookie(array('name' => $cookieName, 'value' => $sc, 'expire' => 3600, 'path' => '/'));
	}
	else if ($ci->input->cookie($cookieName) !== NULL)
	{
		$sc = $ci->input->cookie($cookieName);
	}
	else
	{
		$sc = $defaultValue;
	}

	return $sc;
}


function get_sort($field, $order_by = NULL, $sort_by = 'DESC')
{
	$sc = empty($order_by) ? '' : ($order_by === $field ? ($sort_by === 'DESC' ? 'sorting_desc' : 'sorting_asc') : '');
	return $sc;
}


function clear_filter($cookies)
{
	if (is_array($cookies))
	{
		foreach ($cookies as $cookie)
		{
			delete_cookie($cookie);
		}
	}
	else
	{
		delete_cookie($cookies);
	}
}


function set_rows($value = 20)
{
	$value = $value > 300 ? 300 : $value;

	$arr = array(
		'name' => 'rows',
		'value' => $value,
		'expire' => 259200,
		'path' => '/'
	);

	return set_cookie($arr);
}


function get_rows()
{
	$rows = get_cookie('rows');

	return $rows <= 0 ? 20 : ($rows > 300 ? 300 : $rows);
}


function number($val, $digit = 0)
{
	return number_format($val, $digit);
}


function ac_format($val, $digit = 0)
{
	return $val == 0 ? '-' : number_format($val, $digit);
}


function getConfig($code)
{
	$ci = &get_instance();
	$rs = $ci->db->select('value')->where('code', $code)->get('config');
	if ($rs->num_rows() == 1)
	{
		return $rs->row()->value;
	}

	return NULL;
}


//---- remove discount percent return price after discount
function get_price_after_discount($price, $disc = 0)
{
	$price = floatval($price);
	$find = array('%', ' ');
	$replace = array('', '');
	$disc = str_replace($find, $replace, $disc);
	$disc = floatval($disc);

	if ($disc > 0 && $disc <= 100)
	{
		$price = $price - ($price * ($disc * 0.01));
	}

	return $price;
}


//--- return discount amount calculate from price and discount percentage
function get_discount_amount($price, $disc = 0)
{
	$find = array('%', ' ');
	$replace = array('', '');
	$disc = str_replace($find, $replace, $disc);
	$disc = floatval($disc);

	if ($disc > 0 && $disc <= 100)
	{
		$amount = $price * ($disc * 0.01);
	}
	else
	{
		$amount = 0;
	}

	return $amount;
}


function set_error($key, $name = "data", $message = '')
{
	$error = array(
		'insert' => "Insert {$name} failed.{$message}",
		'update' => "Update {$name} failed.{$message}",
		'delete' => "Delete {$name} failed.{$message}",
		'permission' => "You don't have permission to perform this operation.{$message}",
		'required' => "Missing required parameter.{$message}",
		'exists' => "'{$name}' already exists.{$message}",
		'status' => "Invalid document status.{$message}",
		'notfound' => "Data or document number not found.{$message}",
		'not_found' => "Data or document number not found.{$message}",
		'transection' => "Unable to delete {$name} because transactions exists or link to other module.{$message}",
		'transections' => "Unable to delete {$name} because transactions exists or link to other module.{$message}",
		'transaction' => "Unable to delete {$name} because transactions exists or link to other module.{$message}",
		'transactions' => "Unable to delete {$name} because transactions exists or link to other module.{$message}"
	);	

	$ci = &get_instance();

	$ci->error = (!empty($error[$key]) ? $error[$key] : "Unknow error.");
}


function get_error()
{
	$ci = &get_instance();
	return $ci->error;
}


function set_error_message($message)
{
	$ci = &get_instance();
	$ci->session->set_flashdata('error', $message);
}


function set_message($message)
{
	$ci = &get_instance();
	$ci->session->set_flashdata('success', $message);
}


//--- return null if blank value
function get_null($value)
{
	return $value === '' ? NULL : $value;
}


//--- return TRUE if value ==  1 else return FALSE;
function is_true($value)
{
	$value = is_numeric($value) ? intval($value) : (is_string($value) ? strtolower(strval($value)) : $value);

	if ($value === 1 OR $value === '1' OR $value === 'y' OR $value === 'yes' OR $value === TRUE)
	{
		return TRUE;
	}

	return FALSE;
}


function get_zero($value)
{
	return ($value === NULL OR $value === '') ? 0 : $value;
}


function pagination_config($base_url, $total_rows = 0, $perpage = 20, $segment = 3)
{
	$rows = get_rows();
	$input_rows  = '<p class="pull-right pagination">';
	$input_rows .= 'ทั้งหมด ' . number($total_rows) . ' รายการ';
	$input_rows .= '<input type="number" name="set_rows" id="set-rows" class="input-mini text-center margin-left-15 margin-right-10" value="' . $rows . '" />';
	$input_rows .= 'ต่อหน้า ';
	$input_rows .= '<buton class="btn btn-success btn-xs" type="button" onClick="setRows()">แสดง</button>';
	$input_rows .= '</p>';

	$config['full_tag_open'] 		= '<nav id="pagination"><ul class="pagination">';
	$config['full_tag_close'] 		= '</ul>' . $input_rows . '</nav><hr class="hidden-xs">';
	$config['first_link'] 				= 'First';
	$config['first_tag_open'] 		= '<li>';
	$config['first_tag_close'] 		= '</li>';
	$config['next_link'] 				= 'Next';
	$config['next_tag_open'] 		= '<li>';
	$config['next_tag_close'] 	= '</li>';
	$config['prev_link'] 			= 'prev';
	$config['prev_tag_open'] 	= '<li>';
	$config['prev_tag_close'] 	= '</li>';
	$config['last_link'] 				= 'Last';
	$config['last_tag_open'] 		= '<li>';
	$config['last_tag_close'] 		= '</li>';
	$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
	$config['cur_tag_close'] 		= '</a></li>';
	$config['num_tag_open'] 		= '<li>';
	$config['num_tag_close'] 		= '</li>';
	$config['uri_segment'] 		= $segment;
	$config['per_page']			= $perpage;
	$config['total_rows']			= $total_rows != false ? $total_rows : 0;
	$config['base_url']				= $base_url;
	return $config;
}


function convert($txt)
{
	//return iconv('UTF-8', 'CP850', $txt);
	return $txt;
}


function statusBackgroundColor($is_expire, $status, $is_approve = 1)
{
	$bk_color = "";

	if ($is_expire == 1 or $status == 2)
	{
		$bk_color = $status == 2 ? "#f7c3bf" : "#dbdbdb";
	}
	else
	{
		switch ($status)
		{
			case -1:
				$bk_color = "#fff4d5";
				break;
			case 0:
				$bk_color = "#fbe4ff";
				break;
			case 1:
				$bk_color = $is_approve == 1 ? "#f4ffe7" : "#ddf0f9";
				break;
			case 2:
				$bk_color = "#f7c3bf";
				break;
			case 3:
				$bk_color = "#fbe4ff";
				break;
			case 4:
				$bk_color = "#ffe3b9";
				break;
		}
	}

	return "background-color:{$bk_color};";
}


function statusBgColor($status = 'O')
{
	//--- O = Open , C = Closed , D = Cancelled
	$color = "";

	switch ($status)
	{
		case 'C':
			$bk_color = "#39953c";
			break;
		case 'D':
			$bk_color = "#df473b";
			break;
		default:
			$bk_color = "";
			break;
	}

	return empty($bk_color) ? "" : "color:{$bk_color};";
}


function genUid($length = 16, $version = 4)
{
	$length = $length > 32 ? 32 : ($length < 16 ? 16 : $length);
	$length = $version === 7 ? ($length <= 24 ? 24 : $length) : $length;
	$version = $version == 7 ? 7 : 4;

	if($version === 7)
	{		
		$uuid = uuid_v7();
	}
	else if($version === 4)
	{
		$uuid = uuid_v4();
	}

	//--- Remove dashes
	$uuid = str_replace('-', '', $uuid);

	//---Normalize length
	if($length === NULL OR $length >= strlen($uuid))
	{
		return $uuid;
	}

	return substr($uuid, 0, $length);
}


function uuid_v7()
{
	// Get time in milliseconds	
	$time = (int) floor((microtime(true) * 1000));

	// Split time into high and low parts
	$timeHigh = ($time >> 32) & 0xffffffff; // Higher 32 bits
	$timeLow = $time & 0xffffffff; // Lower 32 bits

	// Generate random bytes for the rest of the UUID
	$rand = random_bytes(10);

	// Set version to 0111 (version 7) and variant to 10xx (RFC 9562)
	$rand[0] = chr((ord($rand[0]) & 0x0f) | 0x70); // Set Version 7 in the first byte of random
	$rand[2] = chr((ord($rand[2]) & 0x3f) | 0x80); // Set Variant 10xx in the third byte of random

	$uuid = sprintf(
		'%04x%08x%04x%04x%012x',
		$timeHigh,
		$timeLow,
		hexdec(bin2hex(substr($rand, 0, 2))),
		hexdec(bin2hex(substr($rand, 2, 2))),
		hexdec(bin2hex(substr($rand, 4, 6)))
	);

	return $uuid;
}


function uuid_v4()
{
	$data = random_bytes(16);
	$data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // Set version to 0100
	$data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // Set variant to 10xx

	$uuid = sprintf(
		'%08s-%04s-%04s-%04s-%12s',
		bin2hex(substr($data, 0, 4)),
		bin2hex(substr($data, 4, 2)),
		bin2hex(substr($data, 6, 2)),
		bin2hex(substr($data, 8, 2)),
		bin2hex(substr($data, 10, 6))
	);

	return $uuid;
}


define('BAHT_TEXT_NUMBERS', array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'));
define('BAHT_TEXT_UNITS', array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'));
define('BAHT_TEXT_ONE_IN_TENTH', 'เอ็ด');
define('BAHT_TEXT_TWENTY', 'ยี่');
define('BAHT_TEXT_INTEGER', 'ถ้วน');
define('BAHT_TEXT_BAHT', 'บาท');
define('BAHT_TEXT_SATANG', 'สตางค์');
define('BAHT_TEXT_POINT', 'จุด');

function baht_text($number, $include_unit = true, $display_zero = true)
{
	if (!is_numeric($number))
	{
		return null;
	}

	$log = floor(log($number, 10));
	if ($log > 5)
	{
		$millions = floor($log / 6);
		$million_value = pow(1000000, $millions);
		$normalised_million = floor($number / $million_value);
		$rest = $number - ($normalised_million * $million_value);
		$millions_text = '';
		for ($i = 0; $i < $millions; $i++)
		{
			$millions_text .= BAHT_TEXT_UNITS[6];
		}
		return baht_text($normalised_million, false) . $millions_text . baht_text($rest, true, false);
	}

	$number_str = (string)floor($number);
	$text = '';
	$unit = 0;

	if ($display_zero && $number_str == '0')
	{
		$text = BAHT_TEXT_NUMBERS[0];
	}
	else for ($i = strlen($number_str) - 1; $i > -1; $i--)
	{
		$current_number = (int)$number_str[$i];

		$unit_text = '';
		if ($unit == 0 && $i > 0)
		{
			$previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
			if ($current_number == 1 && $previous_number > 0)
			{
				$unit_text .= BAHT_TEXT_ONE_IN_TENTH;
			}
			else if ($current_number > 0)
			{
				$unit_text .= BAHT_TEXT_NUMBERS[$current_number];
			}
		}
		else if ($unit == 1 && $current_number == 2)
		{
			$unit_text .= BAHT_TEXT_TWENTY;
		}
		else if ($current_number > 0 && ($unit != 1 || $current_number != 1))
		{
			$unit_text .= BAHT_TEXT_NUMBERS[$current_number];
		}

		if ($current_number > 0)
		{
			$unit_text .= BAHT_TEXT_UNITS[$unit];
		}

		$text = $unit_text . $text;
		$unit++;
	}

	if ($include_unit)
	{
		$text .= BAHT_TEXT_BAHT;

		$satang = explode('.', number_format($number, 2, '.', ''))[1];
		$text .= $satang == 0
			? BAHT_TEXT_INTEGER
			: baht_text($satang, false) . BAHT_TEXT_SATANG;
	}
	else
	{
		$exploded = explode('.', $number);
		if (isset($exploded[1]))
		{
			$text .= BAHT_TEXT_POINT;
			$decimal = (string)$exploded[1];
			for ($i = 0; $i < strlen($decimal); $i++)
			{
				$text .= BAHT_TEXT_NUMBERS[$decimal[$i]];
			}
		}
	}

	return $text;
}


function select_tax_status($option = NULL)
{
	$sc  = '<option value="Y" ' . is_selected($option, 'Y') . '>VAT</option>';
	$sc .= '<option value="N" ' . is_selected($option, 'N') . '>Non-VAT</option>';

	echo $sc;
}

function isValidPattern(string $value, string $pattern = '/^[a-zA-Z0-9\*\-\_@]+$/'): bool
{
	// Accept only: a-z, A-Z, 0-9, *, -, _, @
	return preg_match($pattern, $value) === 1;
}
