<?php

namespace CBApi\Connection\Exception;

/**
 * Class SSLVersionException
 *
 * @package CBApi\Connection\Exception
 */
class SSLVersionException extends \Exception
{
    /**
     * @param string $sslVersion
     */
    public function __construct($sslVersion)
    {
        parent::__construct(sprintf('Invalid SSL version, given %s', $sslVersion));
    }
}
