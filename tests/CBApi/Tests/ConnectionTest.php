<?php

namespace CBApi\Tests;

use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Request\GetRequest;
use CBApi\Connection\RestConnection;

/**
 * Class ConnectionTest
 *
 * @package CBApi\Tests
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetRequest */
    protected $getRequest;

    public function setUp()
    {
        $this->getRequest = new GetRequest(new RestConnection('http://localhosterino', 'asdfasdfasdf'));
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
