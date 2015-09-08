<?php

namespace CBApi\Rest\V1\Request;

use CBApi\Connection\RestConnection;
use CBApi\Sensors\Sensors;
use CBApi\Sensors\Exception\InvalidSensorException;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Connection\Exception\CAInfoException;
use CBApi\Connection\Exception\CAPathException;
use CBApi\Connection\Exception\SSLVersionException;

/**
 * Class RestRequest
 *
 * @package CBApi\Rest\V1\Request
 */
class RestRequest
{
    /** @var RestConnection */
    protected $restConnection;

    /**
     * @param RestConnection $restConnection
     */
    public function __construct(RestConnection $restConnection)
    {
        $this->restConnection = $restConnection;
    }

    /**
     * @param $action
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    protected function getRequest($action)
    {
        return $this->restConnection->getRequest($action);
    }

    /**
     * @param $action
     * @param $data
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    protected function deleteRequest($action, $data)
    {
        return $this->restConnection->deleteRequest($action, $data);
    }

    /**
     * @param $action
     * @param $data
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    protected function putRequest($action, $data)
    {
        return $this->restConnection->putRequest($action, $data);
    }

    /**
     * @param $action
     * @param $data
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    protected function postRequest($action, $data)
    {
        return $this->restConnection->postRequest($action, $data);
    }

    /**
     * @param $name
     * @param $groupId
     * @return array
     * @throws InvalidSensorException
     */
    protected function getSensor($name, $groupId)
    {
        return Sensors::getSensor($name, $groupId);
    }
}
