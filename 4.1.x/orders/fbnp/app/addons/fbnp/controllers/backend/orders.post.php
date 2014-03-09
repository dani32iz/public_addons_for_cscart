<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

use Tygh\Http;
use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'details') {

    $order_info = Registry::get('view')->getTemplateVars('order_info');
    $login = Registry::get('addons.fbnp.login');
    $password = Registry::get('addons.fbnp.password');

    if(!empty($login) && !empty($password)) {
		$url = 'http://www.fbnp.ru/bd?';
		$url .= 'l=' . Registry::get('addons.fbnp.login');
		$url .= '&p=' . Registry::get('addons.fbnp.password');
		$url .= '&f=' . $order_info['s_lastname'] ;
		$url .= '&i=' . $order_info['s_firstname'] ;
		$url .= '&o=' ;
		$url .= '&t=' . $order_info['s_phone'] ;
		$url .= '&c=' . $order_info['s_city'];

		$fbnp_result = fn_get_contents($url);
		$fbnp_result = mb_convert_encoding ($fbnp_result ,"UTF-8", "Windows-1251");

		if ($fbnp_result != 'не найден' && $fbnp_result != 'ошибка логина и пароля') {
			$pos = strripos($fbnp_result , '<'); 
			$pos = $pos + 1 ;
			if($pos > 0) {
				$col = substr($fbnp_result, 0, $pos);
				$col = str_replace(array('<','>'), '',$col);
				if( $col > 0 ) {
					$result = array();
					$result['col'] = $col;
					$_result = explode('#', substr($fbnp_result, $pos + 1));
					foreach($_result as $key => $value) {
						$result['bug'][$key] = str_replace( '&' , ' ', $value);
					}

					$fbnp_result = $result;

				} else {
					$fbnp_result = 'ошибка';
				}
				
			} else {
				$fbnp_result = 'ошибка';
			}

		}

		Registry::get('view')->assign('fbnp_result', $fbnp_result);
    }

}

