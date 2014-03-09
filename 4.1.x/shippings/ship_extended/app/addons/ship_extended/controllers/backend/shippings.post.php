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

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Registry;

fn_trusted_vars (
    'shipping_full_descr'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'update') {
        
        if ((!empty($_REQUEST['shipping_id']) && fn_check_company_id('shippings', 'shipping_id', $_REQUEST['shipping_id'])) || empty($_REQUEST['shipping_id'])) {
            
            $lang_code = DESCR_SL;
            $shipping_id = $_REQUEST['shipping_id'];

            $shipping_full_descr = array(
            	'full_description' => $_REQUEST['shipping_full_descr'],
            );

            if (!empty($shipping_id)) {
	            db_query("UPDATE ?:shipping_descriptions SET ?u WHERE shipping_id = ?i AND lang_code = ?s", $shipping_full_descr, $shipping_id, $lang_code);
	        } 
        }
    }
}


if ($mode == 'update') {

	if (!empty($_REQUEST['shipping_id'])) {
		 $shipping_full_descr = db_get_field("SELECT full_description FROM ?:shipping_descriptions WHERE shipping_id = ?i AND lang_code =?s", $_REQUEST['shipping_id'], DESCR_SL );
		 Registry::get('view')->assign('shipping_full_descr', $shipping_full_descr);
	}
}