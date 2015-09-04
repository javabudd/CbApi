<?php

namespace CBApi\Connection;

use CBApi\Connection\Exception\ConnectionErrorException;

/**
 * Class RestConnection
 *
 * @package CBApi\Connection
 */
class RestConnection
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $apiKey;

    /**
     * @param $url
     * @param $api_key
     */
    public function __construct($url, $api_key)
    {
        $this->url    = $url;
        $this->apiKey = $api_key;
    }

    /**
     * @param $action
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function getRequest($action)
    {
        $channel = $this->getChannel($action);
        $this->setBaseOptions($channel);

        return $this->curlExec($channel);
    }

    /**
     * @param $action
     * @param array $data
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function postRequest($action, array $data)
    {
        $channel = $this->getChannel($action);
        $this->setBaseOptions($channel)->setPostOptions($channel, json_encode($data));

        return $this->curlExec($channel);
    }

    /**
     * @param $action
     * @return resource
     */
    private function getChannel($action)
    {
        return curl_init($this->url . $action);
    }

    /**
     * @param $channel
     * @return mixed
     * @throws ConnectionErrorException
     */
    private function curlExec($channel)
    {
        $response = curl_exec($channel);
        if (!$response) {
            throw new ConnectionErrorException(curl_errno($channel), curl_error($channel));
        }
        curl_close($channel);

        return $response;
    }

    /**
     * @param $channel
     * @return $this
     */
    private function setBaseOptions($channel)
    {
        curl_setopt($channel, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Accept: application/json', 'X-Auth-Token: ' . $this->apiKey)
        );
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);

        return $this;
    }

    /**
     * @param $channel
     * @param $data
     * @return $this
     */
    private function setPostOptions($channel, $data)
    {
        curl_setopt($channel, CURLOPT_POST, true);
        curl_setopt($channel, CURLOPT_POSTFIELDS, $data);

        return $this;
    }
}
