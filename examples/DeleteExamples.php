<?php

/**
 * Example Delete Requests
 */

include __DIR__ . '/../vendor/autoload.php';

$api = new \CBApi\Api('https://localhost', 'e498d97b3c32541e4ba5b537e0a7e61cfa14c089');

echo $api->delete()->deleteWatchlist(1);

