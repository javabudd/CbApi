<?php

namespace CBApi\Formatter;

/**
 * Interface FormatterInterface
 *
 * @package CBApi\Formatter
 */
interface FormatterInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function format(array $params);
}

