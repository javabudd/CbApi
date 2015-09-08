<?php

namespace CBApi\Tests;

use CBApi\Rest\V1\Request\Post\PostRequest;

/**
 * Class PostRequestTest
 *
 * @package CBApi\Tests
 */
class PostRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $mb;

    public function setUp()
    {
        $this->mb = self::getMock(PostRequest::class, ['postRequest'], [], 'PostRequest', false);
    }

    public function testApplyLicense()
    {
        $this->mb->expects(self::once())->method('postRequest')->with(self::isType('string'), self::isType('array'));
        $this->mb->applyLicense('1234ASDF1234ASDF');
    }

    public function testSetPlatformServerConfig()
    {
        $this->mb->expects(self::once())->method('postRequest')->with(self::isType('string'), self::isType('array'));
        $this->mb->setPlatformServerConfig(['username' => 'test', 'password' => 'test', 'server' => 'test']);
    }

    public function testProcessSearch()
    {
        $this->mb->expects(self::once())->method('postRequest')->with(self::isType('string'), self::isType('array'));
        $this->mb->processSearch('test', 1, 15, 'last_update asc', false);
    }

    public function testBinarySearch()
    {
        $this->mb->expects(self::once())->method('postRequest')->with(self::isType('string'), self::isType('array'));
        $this->mb->binarySearch('testy', 10, 20, 'last_update desc', true);
    }
    public function testAddWatchlist()
    {
        $this->mb->expects(self::once())->method('postRequest')->with(self::isType('string'), self::isType('array'));
        $this->mb->addWatchlist(
            [
                'basicQueryValidation' => true,
                'type'                 => 'events',
                'searchQuery'          => 'q=test1=1&test2=2',
                'cbUrlVer'             => 'cb.urlver=1',
                'name'                 => 'test',
                'readOnly'             => false
            ]
        );
    }

    /**
     * @expectedException \CBApi\Query\Exception\QueryException
     */
    public function testInvalidWatchlistSensorQuery()
    {
        $this->mb->addWatchlist(
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

    /**
     * @expectedException \CBApi\Query\Exception\QueryException
     */
    public function testInvalidWatchlistCbUrlVer()
    {
        $this->mb->addWatchList(
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

    /**
     * @expectedException \CBApi\Query\Exception\QueryException
     */
    public function testInvalidWatchlistType()
    {
        $this->mb->addWatchList(
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

    /**
     * @expectedException \CBApi\Query\Exception\QueryException
     */
    public function testMissingWatchlistParameters()
    {
        $this->mb->addWatchlist(
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
