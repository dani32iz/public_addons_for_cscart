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

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_first_addon_gather_additional_product_data_post(&$product, $auth, $params) {

    $addon_info = Registry::get('addons.first_addon');

    $usergroup_ids = explode(',', $addon_info['wholesale_usergroups']);

    if (!array_intersect($usergroup_ids, $auth['usergroup_ids'])) {

        $fields = 'MIN(IF(prices.percentage_discount = 0, prices.price, prices.price - (prices.price * prices.percentage_discount)/100)) as price';

        $condition = db_quote(' prices.product_id = ?i AND prices.usergroup_id IN (?n)', $product['product_id'], $usergroup_ids);
        
        $opt_price = db_get_field("SELECT ?p FROM ?:product_prices as prices WHERE ?p",$fields, $condition);

        if (!empty($opt_price) && $opt_price < $product['price']) {
            $product['opt_price'] = $opt_price;
        }
    }

}