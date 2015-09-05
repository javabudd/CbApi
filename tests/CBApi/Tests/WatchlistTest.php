<?php

namespace CBApi\Tests;

use CBApi\Request\GetRequest;
use CBApi\Connection\RestConnection;

/**
 * Class WatchlistTest
 *
 * @package CBApi\Tests
 */
class WatchlistTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetRequest */
    protected $getRequest;

    public function setUp()
    {
        $this->getRequest = new GetRequest(new RestConnection('http://localhosterino', 'asdfasdfasdf'));
    }

    public function testInvalidSearchQuery()
    {
        self::setExpectedException(\InvalidArgumentException::class);
        // Test invalid search query
        $this->getRequest->verifyWatchlistParameters(
            [
                'basicQueryValidation' => true,
                'type'                 => 'events',
                'searchQuery'          => 'test1=1&test2=2',
                'cbUrlVer'             => 'cb.urlver=1',
                'name'                 => 'test',
                'readOnly'             => false
            ]
        );
    }

    public function testInvalidCbUrlVer()
    {
        self::setExpectedException(\InvalidArgumentException::class);
        $this->getRequest->verifyWatchlistParameters(
            [
                'basicQueryValidation' => true,
                'type'                 => 'events',
                'searchQuery'          => 'q=test1=1&test2=2',
                'cbUrlVer'             => 'cb.urlve=1',
                'name'                 => 'test',
                'readOnly'             => false
            ]
        );
    }

    public function testInvalidType()
    {
        self::setExpectedException(\InvalidArgumentException::class);
        $this->getRequest->verifyWatchlistParameters(
            [
                'basicQueryValidation' => true,
                'type'                 => 'asdf',
                'searchQuery'          => 'q=test1=1&test2=2',
                'cbUrlVer'             => 'cb.urlver=1',
                'name'                 => 'test',
                'readOnly'             => false
            ]
        );
    }

    public function testMissingParameters()
    {
        self::setExpectedException(\InvalidArgumentException::class);
        $this->getRequest->verifyWatchlistParameters(
            [
                'basicQueryValidation' => true,
                'type'                 => 'events',
                'searchQuery'          => 'q=test1=1&test2=2',
                'name'                 => 'test',
                'readOnly'             => false
            ]
        );
    }
}
