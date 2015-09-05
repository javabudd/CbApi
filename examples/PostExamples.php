<?php

/**
 * Example Post Requests
 */

include __DIR__ . '/../vendor/autoload.php';

$api = new \CBApi\Api('https://localhost', 'e498d97b3c32541e4ba5b537e0a7e61cfa14c089');

echo $api->post()->addWatchList(
    [
        'basicQueryValidation' => true,
        'type'                 => 'events',
        'searchQuery'          => 'q=test1=1&test2=2',
        'cbUrlVer'             => 'cb.urlver=1',
        'name'                 => 'test',
        'readOnly'             => false
    ]
);
echo $api->post()->applyLicense('Z2cX0JiX5kJ6Z4HUSPDOUUc5xy1pPvPW');
