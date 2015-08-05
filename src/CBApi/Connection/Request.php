<?php

namespace CBApi\Connection;

/**
 * Class Request
 * @package CBApi\Connection
 */
class Request
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $api_key;

    /** @var bool */
    protected $ssl;

    /**
     * @param $url
     * @param $api_key
     * @param bool|false $ssl
     */
    public function __construct($url, $api_key, $ssl = false)
    {
        $this->url     = $url;
        $this->api_key = $api_key;
        $this->ssl     = $ssl;
    }

    /**
     * @param $action
     * @return mixed
     */
    public function getRequest($action)
    {
        $channel  = $this->createChannel($action);
        $this->setBaseOptions($channel);
        $response = curl_exec($channel);
        curl_close($channel);

        return $response;
    }

    /**
     * @param $action
     * @param array $data
     * @return mixed
     */
    public function postRequest($action, array $data)
    {
        $channel = $this->createChannel($action);
        $this->setBaseOptions($channel)->setPostOptions($channel, json_encode($data));
        $response = curl_exec($channel);
        curl_close($channel);

        return $response;
    }

    /**
     * @param $action
     * @return resource
     */
    private function createChannel($action)
    {
        return curl_init($this->url . $action);
    }

    /**
     * @param $channel
     * @return $this
     */
    private function setBaseOptions($channel)
    {
        curl_setopt($channel, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Accept: application/json', 'X-Auth-Token: ' . $this->api_key)
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