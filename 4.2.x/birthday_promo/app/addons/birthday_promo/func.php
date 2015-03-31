<?php

function fn_birthday_promo_condition($auth)
{

    $result = false;

    if (!empty($auth['user_id'])) {

        $birthday = db_get_field('SELECT birthday FROM ?:users WHERE user_id = ?i', $auth['user_id']);

        if (!empty($birthday)) {

            $_month = date('m', TIME);
            $_day = date('d', TIME);

            $month = date('m', $birthday);
            $day = date('d', $birthday);

            if ($_month == $month && $_day == $day) {
                $result = true;
            }
        }

    }

    return $result; 

}