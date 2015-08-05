<?php

namespace CBApi\Rest;

use CBApi\Connection\Request;

/**
 * Class RestAbstract
 * @package CBApi\Rest
 */
abstract class RestAbstract
{
    /** @var Request */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}