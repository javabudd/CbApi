<?php

namespace CBApi;

use CBApi\Rest\Get;
use CBApi\Rest\Put;
use CBApi\Connection\Request;

include __DIR__ . '/../../vendor/autoload.php';

/**
 * Class Api
 * @package Api
 */
class Api
{
    /** @var Get */
    private $get;

    /** @var Put */
    private $put;

    /** @var Request */
    private $request;

    /** @var string */
    private $api_url;

    /** @var string */
    private $api_key;

    /**
     * @param $api_url
     * @param $api_key
     */
    public function __construct($api_url, $api_key)
    {
        $this->api_url = $api_url;
        $this->api_key = $api_key;
    }

    /**
     * @return Get
     */
    public function doGetRequest()
    {
        if (null === $this->get) {
            $this->get = new Get($this->getRequestObj());
        }

        return $this->get;
    }

    /**
     * @return Put
     */
    public function doPutRequest()
    {
        if (null === $this->put) {
            $this->put = new Put($this->getRequestObj());
        }

        return $this->put;
    }

    /**
     * @return Request
     */
    private function getRequestObj()
    {
        if (null === $this->request) {
            $this->request = new Request($this->api_url, $this->api_key);
        }

        return $this->request;
    }
}