<?php

namespace CBApi\Validator;

use CBApi\Query\Exception\QueryException;

/**
 * Class WatchlistParameterValidator
 *
 * @package CBApi\Validator
 */
class WatchlistParameterValidator implements ValidatorInterface
{
    /** @var array */
    protected static $requiredWatchlistParameters = [
        'type',
        'searchQuery',
        'cbUrlVer',
        'name'
    ];

    /**
     * {@inheritdoc}
     * @throws QueryException
     */
    public function validate(array $params)
    {
        if (count(array_intersect_key($params, array_flip(self::$requiredWatchlistParameters))) < count(
                self::$requiredWatchlistParameters
            )
        ) {
            throw new QueryException('Invalid watchlist parameters passed to query.');
        }
        // Ensure type is of events or modules
        if ($params['type'] !== 'events' && $params['type'] !== 'modules') {
            throw new QueryException('Type must be one of events or modules');
        }
        // Ensure that searchQuery begins with q=
        if (substr($params['searchQuery'], 0, 2) !== 'q=') {
            throw new QueryException('searchQuery must begin with q=<query>');
        }
        // Ensure that cbUrlVer begins with cb.urlver=
        if (substr($params['cbUrlVer'], 0, 10) !== 'cb.urlver=') {
            throw new QueryException('cbUrlVer must begin with cb.urlver=<version>');
        }
    }
}
