<?php

namespace CBApi\Tests;

use CBApi\Request\Delete\DeleteRequest;

class DeleteRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $mb;

    public function setUp()
    {
        $this->mb = self::getMock(DeleteRequest::class, ['deleteRequest'], [], 'DeleteRequest', false);
        $this->mb->expects(self::once())->method('deleteRequest')->with(self::isType('string'), self::isType('array'));
    }

    public function testDeleteWatchlist()
    {
        $this->mb->deleteWatchlist(1);
    }
}
