<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

fn_register_hooks(
    'calculate_cart_taxes_pre',
    'checkout_select_default_payment_method',
    'get_order_info'
);

