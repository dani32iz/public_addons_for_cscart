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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'options_to_features') {

        $type = 'M';
        $group_name = 'Фильтр по параметрам';

        if (!empty($_REQUEST['company_id'])) {
            $company_id = $_REQUEST['company_id'];
        } else {
            $company_id = Registry::get('runtime.company_id');
        }

        if(isset($_REQUEST['product_ids']) && count($_REQUEST['product_ids']) > 0) {
            $products = $_REQUEST['product_ids'];
        } else {
            $products = db_get_fields("SELECT product_id FROM ?:product_options_inventory");
            $products = array_unique($products);    
        }

        foreach($products as $product_id) {
            fn_echo($product_id . '...');
            $params['product_id'] = $product_id;

            list($inventory, $product_options, $product_inventory) = fn_super_get_product_options_inventory($params);

            $features = array();

            if(!empty($inventory)) {
                foreach($inventory as $combination) {

                    foreach($combination['combination'] as $options_id => $variant) {
                        $name = $product_options[$options_id]['option_name'];
                        $variant_name = $product_options[$options_id]['variants'][$variant]['variant_name'];
                        $amount = $combination['amount']; 
                        $features[$name][$variant_name] += $amount;
                    }
                }

                $_features = array();
                $o_position = 0;
                if(!empty($features)) {
                    foreach($features as $key => $array) {
                        $o_position += 10;
                        $_features[$o_position]['group_name'] = $group_name;
                        $_features[$o_position]['type'] = $type;
                        $_features[$o_position]['name'] = $key;
                        $_features[$o_position]['variants'] = array();
                        foreach($array as $variant => $amount) {
                            if($amount > 0) {
                                $_features[$o_position]['variants'][] = $variant;
                            }
                        }
                    }

                    fn_super_set_product_features($product_id, $_features, DESCR_SL, $company_id);       
                }
            }
        }
    } 

    return array(CONTROLLER_STATUS_OK, "super.manage");
}

if ($mode == 'manage') {

    $selected_fields = Registry::get('view')->getTemplateVars('selected_fields');

    Registry::get('view')->assign('selected_fields', $selected_fields);

} 


