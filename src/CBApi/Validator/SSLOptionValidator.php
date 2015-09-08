<?php

namespace CBApi\Validator;

use CBApi\Connection\Exception\SSLVersionException;
use CBApi\Connection\Exception\CAInfoException;
use CBApi\Connection\Exception\CAPathException;

/**
 * Class SSLOptionValidator
 *
 * @package CBApi\Validator
 */
class SSLOptionValidator implements ValidatorInterface
{
    /**
     * @param array $params
     * @return mixed|void
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function validate(array $params)
    {
        if (array_key_exists('sslVersion', $params) && !is_int($params['sslVersion'])) {
            throw new SSLVersionException($params['sslVersion']);
        } elseif (array_key_exists('caInfo', $params) && !array_key_exists('caPath', $params)) {
            throw new CAInfoException('SSL options must include caPath if caInfo is present.');
        } elseif (array_key_exists('caPath', $params) && !array_key_exists('caInfo', $params)) {
            throw new CAPathException('SSL options must include caInfo if caPath is present.');
        }
    }
}
