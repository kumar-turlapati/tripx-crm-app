<?php

namespace Atawa;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Atawa\Constants;
use Atawa\ApiCaller;
use Atawa\Config\Config;

class Utilities
{

	public static function redirect($url, $type='external')
	{
    $response = new RedirectResponse($url);
    $response->send();
    exit;
	}

	public static function checkMandatoryParams($data_set=array(), $mand_params=array()) 
	{
		$diff_params = array_diff($mand_params, $data_set);
		if(count($diff_params) > 0) {
			return $diff_params;
		} else {
			return true;
		}
	}

	public static function validateDate($date = '') {
		if(! is_numeric(str_replace('-', '', $date)) ) {
			return false;
		} else {
      $date_a = explode('-', $date);
      if(checkdate($date_a[1],$date_a[0],$date_a[2])) {
        return true;
      } else {
			  return false;
      }
		}
	}

  public static function validateMonth($month = '') {
    if(!is_numeric($month) || $month<=0 || $month>12 ) {
      return false;
    } else {
      return true;
    }
  }

  public static function validateYear($year = '') {
    if(!is_numeric($year) || $year<=2015 ) {
      return false;
    } else {
      return true;
    }
  }   

	public static function getAuthToken($type='access') {
		if( isset($_COOKIE['__ata__']) ) {
			$base64_string = base64_decode($_COOKIE['__ata__']);
			$token = explode('#', $base64_string);
			if( is_array($token) && count($token)>0 ) {
				switch ($type) {
					case 'access':
						return $token[0];
						break;
					case 'refresh':
						return $token[1];
						break;				
					default:
						return false;
						break;
				}
			} else {
				Utilities::redirect('/login');				
			}
		} else {
			Utilities::redirect('/login');
		}
	}

	/**
	 * return starting index of slno
	 */
	public static function get_slno_start($record_count=0, $no_of_records=0, $page_no=1) {
	    
	    $total_records  =   $no_of_records*$page_no;
	    if($record_count==$no_of_records) {
	        $slno       =    $total_records-$no_of_records;
	    } else if($record_count < $no_of_records) {
	        $slno       =    $total_records-($no_of_records);
	    } else {
	        $slno       =    0;
	    }
	    
	    return $slno;
	}

  /**
  	* removes tags, carriage returns and new lines from string.
    * 
    * @param string $string
    *
    * @return
    *  cleaned string.
  **/
  public static function clean_string($string = '') {
  	return trim(str_replace("\r\n",'',strip_tags($string)));
  }

  public static function get_current_client_id() {
    if(isset($_SESSION['ccode'])) {
      return $_SESSION['ccode'];
    } else {
      Utilities::redirect('/login');
    }
  	// return 'GxhJXWNSC3MNALH';
  }

  public static function get_logged_in_user_id() {
    if(isset($_SESSION['uid'])) {
      return $_SESSION['uid'];
    } else {
      Utilities::redirect('/login');
    }
  }

  public static function validateName($name='') {
  	if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
  		return false;
  	} else {
  		return true;
  	}
  }

  public static function validateEmail($email='') {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    } else {
    	return true;
    }
  }

  public static function validateUrl($url='') {
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
      return false;
    } else {
    	return true;
    }
  }   

  public static function validateMobileNo($mobile_no='') {
  	if( strlen(trim(str_replace("\r\n",'',$mobile_no)))<10 ) {
  		return false;
  	} elseif(!is_numeric($mobile_no)) {
  		return false;
  	}
  	return true;
  }

  /**
    * set flash message to be used on other page.
    *
    * @param str $message
   */
  public static function set_flash_message($message = '', $error=0) {
      if(isset($_SESSION['__FLASH'])) {
          unset($_SESSION['__FLASH']);
      }
      $_SESSION['__FLASH']['message'] = $message;
      $_SESSION['__FLASH']['error']   = $error;
  }

  /**
   * get flash message to be used on other page.
   *
   * @param str $message
   */
  public static function get_flash_message() {
      if(isset($_SESSION['__FLASH'])) {
          $message = $_SESSION['__FLASH']['message'];
          $status  = $_SESSION['__FLASH']['error'];
          unset($_SESSION['__FLASH']);
          return array('message'=>$message, 'error'=>$status);
      } else {
          return '';
      }
  }

  /**
   * print flash message to be used on other page.
   *
   * @param str $message
   */
  public static function print_flash_message($return=true) {

      $flash                  =   Utilities::get_flash_message();
      if(is_array($flash) && count($flash)>0) {
        $flash_message_error  =   $flash['error'];
        $flash_message        =   $flash['message'];
      } else {
        $flash_message        =   '';
      }

      if($flash_message != '' && $flash_message_error) {
        $message =  "<div class='alert alert-danger' role='alert'>
        							<strong>$flash_message</strong>
                    </div>";
      } elseif($flash_message != '') {
        $message =  "<div class='alert alert-success' role='alert'>
        								<strong>$flash_message</strong>
                     </div>";
      } else {
      	$message = '';
      }

      if($return) {
        return $message;
      } else {
        echo $message;
      }
  }

  public static function get_calender_months($index='') {
    $months   =   array(
      1      =>   '1 (January)',
      2      =>   '2 (February)',
      3      =>   '3 (March)',
      4      =>   '4 (April)',
      5      =>   '5 (May)',
      6      =>   '6 (June)',
      7      =>   '7 (July)',
      8      =>   '8 (August)',
      9      =>   '9 (September)',
      10     =>   '10 (October)',
      11     =>   '11 (November)',
      12     =>   '12 (December)',
    );
    if($index != '') {
      return $months[$index];
    } else {
      return $months;
    }
  }

  public static function get_calender_month_names($index='') {
    $months   =   array(
      1      =>   'January',
      2      =>   'February',
      3      =>   'March',
      4      =>   'April',
      5      =>   'May',
      6      =>   'June',
      7      =>   'July',
      8      =>   'August',
      9      =>   'September',
      10     =>   'October',
      11     =>   'November',
      12     =>   'December',
    );
    if($index != '') {
      return $months[$index];
    } else {
      return $months;
    }
  }

  public static function get_calender_month_names_short($index='') {
    $months   =   array(
      1      =>   'Jan',
      2      =>   'Feb',
      3      =>   'Mar',
      4      =>   'April',
      5      =>   'May',
      6      =>   'June',
      7      =>   'July',
      8      =>   'August',
      9      =>   'Sept.',
      10     =>   'Oct',
      11     =>   'Nov',
      12     =>   'Dec',
    );
    if($index != '') {
      return $months[$index];
    } else {
      return $months;
    }
  }  

  public static function print_json_response($response=array(),$encode=true) {
    header('Content-Type: application/json');
    if($encode) {
      echo json_encode($response);
    } else {
      echo $response;
    }
    exit();
  }

  public static function get_api_environment() {
    $business_category = Utilities::get_business_category();
    $environment = $_SERVER['apiEnvironment'];
    $api_urls = Config::get_api_urls();
    return $api_urls[$business_category][$environment];
  }

  public static function get_host_environment_key($environment='') {
    if(isset($_SERVER['apiEnvironment']) && $_SERVER['apiEnvironment']==='dev') {
      return 'dev';
    } elseif(isset($_SERVER['apiEnvironment']) && $_SERVER['apiEnvironment']==='prod_godaddy') {
      return 'atawa.net';
    } elseif(isset($_SERVER['apiEnvironment']) && $_SERVER['apiEnvironment']==='admin') {
      return 'admin';
    } elseif(isset($_SERVER['apiEnvironment']) && $_SERVER['apiEnvironment']==='staging') {
      return 'staging';
    } else {
      return 'local';
    }
  }  

  public static function get_client_details() {
    $client_code = Utilities::get_current_client_id();
    // call api.
    $api_caller = new ApiCaller();
    $response = $api_caller->sendRequest('get','clients/details/'.$client_code);
    $status = $response['status'];
    if($status === 'success') {
      return $response['response']['clientDetails'];
    } elseif($status === 'failed') {
      return false;
    }
  }

  public static function check_access_token() 
  {
      $cookie_validation = true;
      $current_time = time();

      # check cookie exists.
      if(!isset($_COOKIE['__ata__']) || $_COOKIE['__ata__']=='') {
          $cookie_validation = false;
      } else {
        # check cookie is properly formatted and valid.
        $cookie_string_a = explode("##",base64_decode(strip_tags($_COOKIE['__ata__'])));
        if(!is_array($cookie_string_a) || count($cookie_string_a)<4) {
          $cookie_validation = false;
        }

        # check if expiry time sets.
        if(is_numeric($cookie_string_a[2])) {
            $expiry_time = $cookie_string_a[2];
            if($expiry_time<time()) {
                $cookie_validation = false;
            }
        } else {
            $cookie_validation = false;
        }
      }

      # redirect user to login if anything went wrong.
      if($cookie_validation) {
          $_SESSION['token_valid'] = true;
          $_SESSION['cname'] = $cookie_string_a[3];
          $_SESSION['ccode'] = $cookie_string_a[4];
          $_SESSION['uid'] = $cookie_string_a[5];
          $_SESSION['uname'] = $cookie_string_a[6];
          $_SESSION['utype'] = $cookie_string_a[7];
          $_SESSION['bc'] = $cookie_string_a[8];
          return true;
      } else {
          unset($_SESSION['token_valid']);
          unset($_SESSION['cname']);
          Utilities::redirect('/login');
      }
  }

  public static function process_key_value_pairs($list=array(),$index_key='',$value_key='') {
    $ary = array();
    foreach($list as $list_details) {
      $ary[$list_details[$index_key]] = $list_details[$value_key];
    }
    return $ary;
  }

  public static function get_user_types($user_type='') {
    $user_types = array(
      4 => 'Admin user',
      5 => 'Sales user',
      6 => 'Stores user',
      7 => 'Purchase user',
    );
    if(is_numeric($user_type) && isset($user_types[$user_type])) {
      return $user_types[$user_type];
    } elseif($user_type==='') {
      return $user_types;
    } else {
      return 'Unknown';
    }
  }

  public static function get_user_status($status='') {
    $status_a = array(
      1 => 'Active',
      2 => 'Blocked',
      0 => 'Inactive',
    );
    if(is_numeric($status) && isset($status_a[$status])) {
      return $status_a[$status];
    } elseif($status==='') {
      return $status_a;
    } else {
      return 0;
    }
  }

  public static function get_captcha_keys($host='', $needle='') {
    $captcha_keys = Config::get_captcha_keys();
    if(isset($captcha_keys[$host])) {
      return $needle==='public'?$captcha_keys[$host][0]:$captcha_keys[$host][1];
    } else {
      return false;
    }
  }

  public static function acls($role_id='', $path='') {
    $path_a = explode('/', $path);
    if(is_array($path_a) && count($path_a)>3) {
      $path = '/'.$path_a[1].'/'.$path_a[2];
    }
    $denied_permissions = [
      3 => [
      ],
      4 => [
        '/categories/list', '/suppliers/remove', '/opbal/list', '/opbal/add',
        '/opbal/update', '/inventory/stock-adjustment', '/inventory/stock-adjustments-list',
        '/inventory/trash-expired-items', '/fin/supp-opbal', '/fin/supp-opbal',
        '/fin/supp-opbal', '/fin/bank', '/fin/bank', '/fin/bank',
        '/users/list', '/users/update', '/users/create', '/admin-options/enter-bill-no',
        '/admin-options/edit-business-info', '/admin-options/edit-sales-bill', 
        '/admin-options/edit-po', '/admin-options/update-batch-qtys', '/admin-options/delete-sale-bill',
        '/taxes/add', '/taxes/update', '/taxes/list', '/sales-summary-by-month', '/stock-report',
        '/stock-report-new', '/adj-entries',
        '/adj-entries', '/io-analysis', '/inventory-profitability', '/mom-comparison',
        '/admin-options/edit-business-info',
      ],
      5 => [
        '/categories/list', '/suppliers/remove', '/opbal/list', '/opbal/add',
        '/opbal/update', '/inventory/stock-adjustment', '/inventory/stock-adjustments-list',
        '/inventory/trash-expired-items', '/fin/supp-opbal', '/fin/supp-opbal',
        '/fin/supp-opbal', '/fin/bank', '/fin/bank', '/fin/bank',
        '/users/list', '/users/update', '/users/create', '/admin-options/enter-bill-no',
        '/admin-options/edit-business-info', '/admin-options/edit-sales-bill', 
        '/admin-options/edit-po', '/admin-options/update-batch-qtys', '/admin-options/delete-sale-bill',
        '/taxes/add', '/taxes/update', '/taxes/list', '/sales-summary-by-month', '/stock-report',
        '/stock-report-new', '/adj-entries',
        '/adj-entries', '/io-analysis', '/inventory-profitability', '/mom-comparison',
        '/admin-options/edit-business-info',        
      ],
      6 => [
      ],
      7 => [
      ],
    ];

    # validate permission
    if(array_key_exists($role_id, $denied_permissions)) {
      $is_denied = array_search($path, $denied_permissions[$role_id]);
      if($is_denied!==false) {
        Utilities::redirect('/error-404');
      } else {
        return true;
      }
    }

    return false;
  }

  public static function get_business_category() {
    if(isset($_SESSION['bc']) && (int)$_SESSION['bc']>0 ) {
      return $_SESSION['bc'];
    } else {
      return 0;
    }
  }

  public static function validate_date($date='') {
    $date_ts = strtotime($date);
    $date_m = date("n", $date_ts);
    $date_d = date("j", $date_ts);
    $date_y = date("Y", $date_ts);
    return checkdate($date_m, $date_d, $date_y);
  }

  /**
   * generates 10 characters unique string.
  **/
  public static function generate_unique_string($length) {
      $token = "";
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
      $codeAlphabet.= "0123456789";
      $max = strlen($codeAlphabet) - 1;
      for ($i=0; $i < $length; $i++) {
          $token .= $codeAlphabet[Utilities::crypto_rand_secure(0, $max)];
      }
      return $token;
  }    

  public static function crypto_rand_secure($min, $max) {
      $range = $max - $min;
      if ($range < 1) return $min; // not so random...
      $log = ceil(log($range, 2));
      $bytes = (int) ($log / 8) + 1; // length in bytes
      $bits = (int) $log + 1; // length in bits
      $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
      do {
              $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
              $rnd = $rnd & $filter; // discard irrelevant bits
      } while ($rnd >= $range);
      return $min + $rnd;
  }  
}