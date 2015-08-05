<?php

namespace CBApi;

use CBApi\Connection\Request;
use CBApi\Rest\Get;
use CBApi\Rest\Put;

include __DIR__ . '/../../vendor/autoload.php';

/**
 * Class Api
 * @package Api
 */
class Api
{
    /** @var Get */
    protected $get;

    /** @var Put */
    protected $put;

    /**
     * @param $url
     * @param $api_key
     * @param $ssl
     */
    public function __construct($url, $api_key, $ssl = false)
    {
        $request   = new Request($url, $api_key, $ssl);
        $this->get = new Get($request);
        $this->put = new Put($request);
    }

    /**
     * @return Get
     */
    public function get()
    {
        return $this->get;
    }

    /**
     * @return Put
     */
    public function put()
    {
        return $this->put;
    }
}