## CarbonBlack PHP API

```php
$api = new \CBApi\Api('https://localhost', 'XXXXXXXXXXXXXXXXXXXXXXXXXX');

/** Get */
$api->doGetRequest()->info();
$api->doGetRequest()->processSearch('process_name:svchost.exe -path:c:\\windows\\');
$api->doGetRequest()->sensorInstaller('WindowsEXE');

/** Put */
$api->doPutRequest()->license(XXXXXXXXXXXXXXXXXXXXX);
$config = array('username' => 'example', 'password' => 'example', 'server' => 'localhost');
$api->doPutRequest()->platformServerConfig($config);
```