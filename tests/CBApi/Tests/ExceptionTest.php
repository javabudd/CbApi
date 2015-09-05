<?php

namespace CBApi\Tests;

use CBApi\Connection\RestConnection;
use CBApi\Request\GetRequest;
use CBApi\Sensors\Exception\InvalidSensorException;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Sensors\Sensors;

/**
 * Class ExceptionTest
 *
 * @package CBApi\Tests
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetRequest */
    private $getRequest;

    public function setUp()
    {
        $this->getRequest = new GetRequest(new RestConnection('http://localhosterino', 'asdfasdfasdf'));
    }
    /**
     * @throws InvalidSensorException
     */
    public function testSensorNotFoundException()
    {
        self::setExpectedException(InvalidSensorException::class);
        Sensors::getSensor('WindowsWOW', 1);
    }

    /**
     * @throws ConnectionErrorException
     */
    public function testConnectionErrorException()
    {
        self::setExpectedException(ConnectionErrorException::class);
        $this->getRequest->info();
    }
}
