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

$elonleads = fn_get_session_data('elonleads');

if (empty($elonleads) || isset($_REQUEST['utm-source'])) {

    if (isset($_REQUEST['utm-source']) && !empty($_REQUEST['click_id'])) {

        fn_set_session_data('elonleads', $_REQUEST['click_id']);

        Registry::get('view')->assign('elonleads', $_REQUEST['click_id']);
        Registry::get('view')->assign('elonleads_promo', true);

    }

} else {

    Registry::get('view')->assign('elonleads', $elonleads);
}
