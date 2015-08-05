## CarbonBlack PHP API

```php
$api = new \CBApi\Api('https://localhost', 'XXXXXXXXXXXXXXXXXXXXXXXXXX');

/** Get */
$api->get()->info();
$api->get()->processSearch('process_name:svchost.exe -path:c:\\windows\\');

/** Put */
$api->put()->license(XXXXXXXXXXXXXXXXXXXXX);
$api->put()->platformServerConfig(array('username' => 'example', 'password' => 'example', 'server' => 'localhost'));
```