<?php

namespace CBApi\Rest\V1\Formatter;

/**
 * Interface FormatterInterface
 *
 * @package CBApi\Rest\V1\Formatter
 */
interface FormatterInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function format(array $params);
}

