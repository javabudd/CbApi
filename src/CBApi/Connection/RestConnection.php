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
    private $url;

    /** @var string */
    private $apiKey;

    /**
     * @param $url
     * @param $apiKey
     */
    public function __construct($url, $apiKey)
    {
        $this->url    = $url;
        $this->apiKey = $apiKey;
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
     * @param       $action
     * @param array $data
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function putRequest($action, array $data)
    {
        $channel = $this->getChannel($action);
        $this->setBaseOptions($channel)->setPutOptions($channel, json_encode($data));

        return $this->curlExec($channel);
    }

    /**
     * @param       $action
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
     * @param       $action
     * @param array $data
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function deleteRequest($action, array $data)
    {
        $channel = $this->getChannel($action);
        $this->setBaseOptions($channel)->setDeleteOptions($channel, json_encode($data));

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
        curl_setopt(
            $channel,
            CURLOPT_HTTPHEADER,
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
    private function setPutOptions($channel, $data)
    {
        curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setPostFields($channel, $data);

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
        $this->setPostFields($channel, $data);

        return $this;
    }

    /**
     * @param $channel
     * @param $data
     * @return $this
     */
    private function setDeleteOptions($channel, $data)
    {
        curl_setopt($channel, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->setPostFields($channel, $data);

        return $this;
    }

    /**
     * @param $channel
     * @param $data
     */
    private function setPostFields($channel, $data)
    {
        curl_setopt($channel, CURLOPT_POSTFIELDS, $data);
    }
}
