<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_ship_extended_calculate_cart_taxes_pre($cart, $cart_products, &$product_groups, $calculate_taxes, $auth)
{
    foreach($product_groups as $g_key => $group) { 
        if (!empty($group['shippings'])) {
            foreach($group['shippings'] as $s_key => $shipping) {
                $descr = db_get_row("SELECT full_description, free_text  FROM ?:shipping_descriptions WHERE shipping_id = ?i AND lang_code =?s", $shipping['shipping_id'], DESCR_SL );
                $product_groups[$g_key]['shippings'][$s_key]['full_description'] = $descr['full_description'];
                $product_groups[$g_key]['shippings'][$s_key]['free_text'] = $descr['free_text'];
            }
        }
    }
}


function fn_ship_extended_checkout_select_default_payment_method(&$cart, &$payment_methods, $completed_steps)
{

	if(isset($cart['chosen_shipping']) && is_array($cart['chosen_shipping']) && count($cart['chosen_shipping']) == 1) {
		$chosen_shipping = reset($cart['chosen_shipping']);

		$disable_payments = db_get_field("SELECT disable_payments FROM ?:shippings WHERE shipping_id = ?i", $chosen_shipping);

		if ($disable_payments != 0) {
	        $disable_payments = explode(',',$disable_payments);

	        $new_payment_groups = array();
			foreach($payment_methods as $tab => $group) {
				foreach($group as $payment_id => $payment) {
					$search = array_search($payment['payment_id'], $disable_payments);
					if($search === false) {
						$new_payment_methods[$tab][$payment_id] = $payment;
					}
				}
			}

			if(!empty($new_payment_methods)) {
				$payment_methods = $new_payment_methods;
			} else {
				$cart['payment_id'] = 0;
			}
		}
	}

}

