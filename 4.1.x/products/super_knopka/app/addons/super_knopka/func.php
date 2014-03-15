<?php

use Tygh\Registry;


function fn_super_set_product_features($product_id, $features, $lang_code, $company_id)
{

    $variants = array();

    if (!fn_is_empty($features)) {

        foreach ($features as $key => $feature) {

            if (!empty($feature['group_name'])) {
                $group_id = fn_super_check_feature_group($feature['group_name'], $company_id, $lang_code);
            } else {
                $group_id = 0;
            }

            $condition = db_quote("WHERE description = ?s AND lang_code = ?s AND feature_type = ?s", $feature['name'], $lang_code, $feature['type']);
            $condition .= db_quote(" AND parent_id = ?i", $group_id);

            $feature_id = db_get_field(
                'SELECT ?:product_features.feature_id FROM ?:product_features_descriptions ' .
                    'LEFT JOIN ?:product_features ON ?:product_features.feature_id = ?:product_features_descriptions.feature_id ' . $condition
            );

            if (empty($feature_id)) {

                if($company_id == 0) {
                    $company_id = db_get_field("SELECT company_id FROM ?:products WHERE product_id = ?i" , $product_id);
                }

                $feature_data = array(
                    'description' => $feature['name'],
                    'company_id' => $company_id,
                    'feature_type' => $feature['type'],
                    'parent_id' => $group_id
                );

                $feature_id = fn_update_product_feature($feature_data, 0, $lang_code);
            }

            if (fn_allowed_for('ULTIMATE')) {
                fn_super_update_share_feature($feature_id, $company_id);
            }

            if(!empty($feature['variants'])) {
                $variants = fn_super_product_feature_variants($feature, $feature_id, $variants, $lang_code);
            } else {
                $variants[$feature_id] = '';
            }

        }

        fn_update_product_features_value($product_id, $variants, array(), $lang_code);
    }

    return true;
}

function fn_super_product_feature_variants($feature, $feature_id, $variants, $lang_code)
{
    $feature_type = $feature['type'];

    if (strpos('MSNE', $feature_type) !== false) { // variant IDs

        $vars = array();
        foreach ($feature['variants'] as $variant) {
            $vars[] = $variant;
        }

        $existent_variants = db_get_hash_single_array(
            'SELECT pfvd.variant_id, variant FROM ?:product_feature_variant_descriptions AS pfvd ' .
            'LEFT JOIN ?:product_feature_variants AS pfv ON pfv.variant_id = pfvd.variant_id ' .
            'WHERE feature_id = ?i AND variant IN (?a) AND lang_code = ?s',
            array('variant_id', 'variant'), $feature_id, $vars, $lang_code
        );

        foreach ($feature['variants'] as $variant_data) {
            if (!in_array($variant_data, $existent_variants)) {
                $variant_id = fn_add_feature_variant($feature_id, array('variant' => $variant_data));
                $existent_variants[$variant_id] = $variant_data;
            }
        }

        if ($feature_type == 'M') {

            foreach ($feature['variants'] as $variant_data) {
                if (in_array($variant_data, $existent_variants)) {
                    $variant_id = array_search($variant_data, $existent_variants);
                    $variants[$feature_id][$variant_id] = $variant_id;
                }

            }
        } else {
            $variant_data = reset($feature['variants']);

            if (in_array($variant_data, $existent_variants)) {
                $variant_id = array_search($variant_data, $existent_variants);
                $variants[$feature_id] = $variant_id;
            }
        }

    } else {
        $variant_data = reset($feature['variants']);
        $variants[$feature_id] = $variant_data;
    }

    return $variants;
}


function fn_super_check_feature_group($group, $company_id, $lang_code)
{
    $group_id = db_get_field("SELECT feature_id FROM ?:product_features_descriptions WHERE description = ?s AND lang_code = ?s LIMIT 1", $group, $lang_code);

    if (empty($group_id)) {

        $group_data = array(
            'feature_id' => 0,
            'description' => $group,
            'lang_code' => $lang_code,
            'feature_type' => 'G',
            'company_id' => $company_id,
            'status' => 'A'
        );

        $group_id = fn_update_product_feature($group_data, 0, $lang_code);
    }

    if (fn_allowed_for('ULTIMATE')) {
        fn_super_update_share_feature($group_id, $company_id);
    }

    return $group_id;
}

function fn_super_update_share_feature($feature_id, $company_id)
{
    static $feature = array();

    if (!isset($feature[$company_id . '_' .$feature_id]) && !fn_check_shared_company_id('product_features', $feature_id, $company_id)) {
        fn_ult_update_share_object($feature_id, 'product_features', $company_id);
        $feature[$company_id . '_' .$feature_id] = true;
    }
}

function fn_super_get_product_options_inventory($params, $items_per_page = 0, $lang_code = DESCR_SL)
{
    $default_params = array (
        'page' => 1,
        'product_id' => 0,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    $inventory = db_get_array("SELECT * FROM ?:product_options_inventory WHERE product_id = ?i ORDER BY position ", $params['product_id']);

    foreach ($inventory as $k => $v) {
        $inventory[$k]['combination'] = fn_get_product_options_by_combination($v['combination']);
    }

    $product_options = fn_get_product_options($params['product_id'], $lang_code, true, true);
    $product_inventory = db_get_field("SELECT tracking FROM ?:products WHERE product_id = ?i", $params['product_id']);

    return array($inventory, $product_options, $product_inventory);
}
