## CarbonBlack PHP API
[![Build Status](https://travis-ci.org/javabudd/CbApi.svg?branch=master)](https://travis-ci.org/javabudd/CbApi)

```php
$api = new \CBApi\Api('https://localhost', 'XXXXXXXXXXXXXXXXXXXXXXXXXX');

/** Get */
$api->get()->info();
$api->get()->processSearch('process_name:svchost.exe -path:c:\\windows\\');
$api->get()->sensorInstaller('WindowsEXE');
$api->get()->processSummary(1, 1, 10);

/** Put */
$api->put()->license(XXXXXXXXXXXXXXXXXXXXX);
$api->put()->platformServerConfig(
    [
        'username' => 'example',
        'password' => 'example',
        'server'   => 'localhost'
    ]
);
$api->put()->addWatchList(
    [
        'basicQueryValidation' => true,
        'type'                 => 'events',
        'searchQuery'          => 'q=test1=1&test2=2',
        'cbUrlVer'             => 'cb.urlver=1',
        'name'                 => 'test',
        'readOnly'             => false
    ]
);
```
