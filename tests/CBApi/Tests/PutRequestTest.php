<?php

namespace CBApi\Tests;

use CBApi\Rest\V1\Request\Put\PutRequest;

/**
 * Class PutRequestTest
 *
 * @package CBApi\Tests
 */
class PutRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $mb;

    public function setUp()
    {
        $this->mb = self::getMock(PutRequest::class, ['putRequest'], [], 'PutRequest', false);
        $this->mb->expects(self::once())->method('putRequest')->with(self::isType('string'), self::isType('array'));
    }

    public function testModifyWatchlist()
    {
        $this->mb->modifyWatchlist('1', 'newWatchlist');
    }
}
