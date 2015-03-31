<?php

$schema['export_fields']['Birthday'] = array(
    'db_field' => 'birthday',
    'process_get' => array('fn_timestamp_to_date', '#this'),
    'convert_put' => array('fn_date_to_timestamp', '#this'),
);

return $schema;
