<?php

namespace CBApi;

use CBApi\Rest\V1\Request\Get\GetRequest;
use CBApi\Rest\V1\Request\Post\PostRequest;
use CBApi\Rest\V1\Request\Put\PutRequest;
use CBApi\Rest\V1\Request\Delete\DeleteRequest;
use CBApi\Connection\RestConnection;

include __DIR__ . '/../../vendor/autoload.php';

/**
 * Class Api
 *
 * @package CBApi
 */
class Api
{
    /** @var GetRequest */
    private $getRequest;

    /** @var PutRequest */
    private $putRequest;

    /** @var PostRequest */
    protected $postRequest;

    /** @var DeleteRequest */
    protected $deleteRequest;

    /** @var RestConnection */
    private $restConnection;

    /** @var string */
    private $apiUrl;

    /** @var string */
    private $apiKey;

    /**
     * @param $apiUrl
     * @param $apiKey
     */
    public function __construct($apiUrl, $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * @return GetRequest
     */
    public function get()
    {
        if (null === $this->getRequest) {
            $this->getRequest = new GetRequest($this->getRestConnection());
        }

        return $this->getRequest;
    }

    /**
     * @return PutRequest
     */
    public function put()
    {
        if (null === $this->putRequest) {
            $this->putRequest = new PutRequest($this->getRestConnection());
        }

        return $this->putRequest;
    }

    /**
     * @return PostRequest
     */
    public function post()
    {
        if (null === $this->postRequest) {
            $this->postRequest = new PostRequest($this->getRestConnection());
        }

        return $this->postRequest;
    }

    /**
     * @return DeleteRequest
     */
    public function delete()
    {
        if (null === $this->deleteRequest) {
            $this->deleteRequest = new DeleteRequest($this->getRestConnection());
        }

        return $this->deleteRequest;
    }

    /**
     * @return RestConnection
     */
    private function getRestConnection()
    {
        if (null === $this->restConnection) {
            $this->restConnection = new RestConnection($this->apiUrl, $this->apiKey);
        }

        return $this->restConnection;
    }
}
