## CarbonBlack PHP API
[![Build Status](https://travis-ci.org/javabudd/CbApi.svg?branch=master)](https://travis-ci.org/javabudd/CbApi)

###Requires
* PHP >= 5.5

```php
$api = new \CBApi\Api('https://localhost', 'XXXXXXXXXXXXXXXXXXXXXXXXXX');

/** Get */
$api->get()->processSearch('process_name:svchost.exe -path:c:\\windows\\');

/** Put */
$api->put()->modifyWatchlist(1, 'newWatchlist');

/** Post */
$api->post()->addWatchList(
    [
        'basicQueryValidation' => true,
        'type'                 => 'events',
        'searchQuery'          => 'q=test1=1&test2=2',
        'cbUrlVer'             => 'cb.urlver=1',
        'name'                 => 'test',
        'readOnly'             => false
    ]
);

/** Delete */
$api->delete()->deleteWatchlist(1);
```
