<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_ship_extended_calculate_cart_taxes_pre($cart, $cart_products, &$product_groups, $calculate_taxes, $auth)
{
    foreach($product_groups as $g_key => $group) { 
        if (!empty($group['shippings'])) {
            foreach($group['shippings'] as $s_key => $shipping) {
                $full_descr = db_get_field("SELECT full_description FROM ?:shipping_descriptions WHERE shipping_id = ?i AND lang_code =?s", $shipping['shipping_id'], DESCR_SL );
                $product_groups[$g_key]['shippings'][$s_key]['full_description'] = $full_descr;
            }
        }
    }
}


