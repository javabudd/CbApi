<?php

/**
 * Example Get Requests
 */

include __DIR__ . '/../vendor/autoload.php';

$sslOptions = [
  'sslVersion' => 3
];
$api = new \CBApi\Api('https://127.0.0.1:6969', 'e498d97b3c32541e4ba5b537e0a7e61cfa14c089', $sslOptions);

echo $api->get()->info();
echo $api->get()->processSummary(1, 1, 10);
echo $api->get()->sensorInstaller('WindowsEXE');

