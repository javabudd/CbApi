<?php

namespace CBApi\Rest\V1\Validator;

/**
 * Interface ValidatorInterface
 *
 * @package CBApi\Rest\V1\Validator
 */
interface ValidatorInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function validate(array $params);
}
