<?php

namespace CBApi\Validator;

/**
 * Interface ValidatorInterface
 *
 * @package CBApi\Validator
 */
interface ValidatorInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function validate(array $params);
}
