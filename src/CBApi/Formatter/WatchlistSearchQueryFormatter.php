<?php

namespace CBApi\Formatter;

use CBApi\Query\Exception\QueryException;
use InvalidArgumentException;

/**
 * Class WatchlistSearchQueryFormatter
 *
 * @package CBApi\Formatter
 */
class WatchlistSearchQueryFormatter implements FormatterInterface
{
    /**
     *
     * {@inheritdoc}
     * @throws QueryException
     * @throws InvalidArgumentException
     */
    public function format(array $params)
    {
        if (!array_key_exists('cbUrlVer', $params) && !array_key_exists('searchQuery', $params)) {
            throw new InvalidArgumentException(
                'Argument $params must include cbUrlVer and searchQuery keys'
            );
        }
        if (substr($params['cbUrlVer'], -1) !== '&') {
            $params['cbUrlVer'] .= '&';
        }
        $searchQuery = $params['searchQuery'];
        $subQuery    = substr($searchQuery, 2);
        array_map(
            function ($value) use ($searchQuery) {
                if (false === strpos($value, '=')) {
                    throw new QueryException(
                        sprintf('Invalid searchQuery arguments passed: %s', $searchQuery)
                    );
                }
            },
            explode('&', $subQuery)
        );

        if (substr($subQuery, -1) === '&') {
            $searchQuery = rtrim($subQuery, '&');
        }

        return urlencode($params['cbUrlVer'] . $searchQuery);
    }
}
