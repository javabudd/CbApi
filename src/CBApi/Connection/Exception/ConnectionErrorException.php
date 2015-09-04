<?php

namespace CBApi\Connection\Exception;

/**
 * Class ConnectionErrorException
 *
 * @package CBApi\Connection\Exception
 */
class ConnectionErrorException extends \Exception
{
    /**
     * @param string $error
     * @param int    $errorNo
     */
    public function __construct($errorNo, $error)
    {
        parent::__construct(sprintf('Connection error #%s: %s', $errorNo, $error));
    }
}
