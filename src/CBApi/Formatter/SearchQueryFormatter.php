<?php

namespace CBApi\Formatter;

use InvalidArgumentException;

/**
 * Class SearchQueryFormatter
 *
 * @package CBApi\Formatter
 */
class SearchQueryFormatter implements FormatterInterface
{
    /**
     * @param array $params
     * @return array
     * @throws InvalidArgumentException
     */
    public function format(array $params)
    {
        if (!array_key_exists('start', $params) && !array_key_exists('rows', $params)
            && !array_key_exists('sort', $params) && !array_key_exists('facet', $params)
        ) {
            throw new InvalidArgumentException('Argument $params must include start, rows, sort, and facet keys');
        }
        $search = [
            'start'     => $params['start'],
            'rows'      => $params['rows'],
            'sort'      => $params['sort'],
            'facet'     => array($params['facet'], $params['facet']),
            'cb.urlver' => 1
        ];

        if (array_key_exists('query', $params) && $params['query'] !== '') {
            $search['q'] = $params['query'];
        }

        return $search;
    }
}
