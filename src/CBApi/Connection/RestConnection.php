<?php

namespace CBApi\Connection;

use CBApi\Connection\Exception\CAInfoException;
use CBApi\Connection\Exception\CAPathException;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Connection\Exception\SSLVersionException;
use CBApi\Validator\SSLOptionValidator;

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

    /** @var array */
    private $sslOptions;

    /** @var resource */
    private $channel;

    /**
     * @param $url
     * @param $apiKey
     * @param $sslOptions
     */
    public function __construct($url, $apiKey, $sslOptions)
    {
        $this->url        = $url;
        $this->apiKey     = $apiKey;
        $this->sslOptions = $sslOptions;
    }

    /**
     * @param $action
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function getRequest($action)
    {
        $this->setChannel($action);
        $this->setBaseOptions();

        return $this->curlExec();
    }

    /**
     * @param       $action
     * @param array $data
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function putRequest($action, array $data)
    {
        $this->setChannel($action);
        $this->setBaseOptions()->setPutOptions(json_encode($data));

        return $this->curlExec();
    }

    /**
     * @param       $action
     * @param array $data
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function postRequest($action, array $data)
    {
        $this->setChannel($action);
        $this->setBaseOptions()->setPostOptions(json_encode($data));

        return $this->curlExec();
    }

    /**
     * @param       $action
     * @param array $data
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function deleteRequest($action, array $data)
    {
        $this->setChannel($action);
        $this->setBaseOptions()->setDeleteOptions(json_encode($data));

        return $this->curlExec();
    }

    /**
     * @param $action
     * @return $this
     */
    private function setChannel($action)
    {
        $this->channel = curl_init($this->url . $action);

        return $this;
    }

    /**
     * @return mixed
     * @throws ConnectionErrorException
     */
    private function curlExec()
    {
        $response = curl_exec($this->channel);
        if (!$response) {
            throw new ConnectionErrorException(curl_errno($this->channel), curl_error($this->channel));
        }
        curl_close($this->channel);

        return $response;
    }

    /**
     * @return $this
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    private function setBaseOptions()
    {
        curl_setopt(
            $this->channel,
            CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Accept: application/json', 'X-Auth-Token: ' . $this->apiKey)
        );

        curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->channel, CURLOPT_CONNECTTIMEOUT ,15);
        curl_setopt($this->channel, CURLOPT_TIMEOUT, 60);
        $this->setSSLOptions();

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    private function setPutOptions($data)
    {
        curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setPostFields($data);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    private function setPostOptions($data)
    {
        curl_setopt($this->channel, CURLOPT_POST, true);
        $this->setPostFields($data);

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    private function setDeleteOptions($data)
    {
        curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->setPostFields($data);

        return $this;
    }

    /**
     * @param $data
     */
    private function setPostFields($data)
    {
        curl_setopt($this->channel, CURLOPT_POSTFIELDS, $data);
    }

    /**
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    private function setSSLOptions()
    {
        $verifyPeer = false;
        if (count($this->sslOptions) > 0) {
            $sslOptionValidator = new SSLOptionValidator();
            $sslOptionValidator->validate($this->sslOptions);
            if (array_key_exists('caInfo', $this->sslOptions) && array_key_exists('caPath', $this->sslOptions)) {
                if (file_exists($this->sslOptions['caInfo'])) {
                    if (is_dir($this->sslOptions['caPath'])) {
                        $verifyPeer = true;
                        curl_setopt($this->channel, CURLOPT_CAINFO, $this->sslOptions['caInfo']);
                        curl_setopt($this->channel, CURLOPT_CAPATH, $this->sslOptions['caPath']);
                    } else{
                        throw new CAPathException(
                            sprintf('CA path %s does not exist.', $this->sslOptions['caPath'])
                        );
                    }
                } else {
                    throw new CAInfoException(
                        sprintf('CA certificate %s does not exist.', $this->sslOptions['caInfo'])
                    );
                }
            }
            curl_setopt(
                $this->channel,
                CURLOPT_SSLVERSION,
                array_key_exists('sslVersion', $this->sslOptions) ? $this->sslOptions['sslVersion'] : 0
            );
        }
        curl_setopt($this->channel, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->channel, CURLOPT_SSL_VERIFYPEER, $verifyPeer);
    }
}
