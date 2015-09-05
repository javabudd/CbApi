<?php

namespace CBApi\Request\Rest;

use CBApi\Connection\RestConnection;
use CBApi\Sensors\Sensors;
use InvalidArgumentException;
use CBApi\Sensors\Exception\InvalidSensorException;

/**
 * Class RestRequest
 *
 * @package CBApi\Request\Rest
 */
class RestRequest
{
    /** @var RestConnection */
    protected $restConnection;

    /** @var array */
    protected static $requiredWatchlistParameters = [
        'type',
        'searchQuery',
        'cbUrlVer',
        'name'
    ];

    /**
     * @param RestConnection $restConnection
     */
    public function __construct(RestConnection $restConnection)
    {
        $this->restConnection = $restConnection;
    }

    /**
     * @param $query
     * @param $start
     * @param $rows
     * @param $sort
     * @param $facet
     * @return array
     */
    protected function getBaseSearchQuery($query, $start, $rows, $sort, $facet)
    {
        $search = [
            'start'     => $start,
            'rows'      => $rows,
            'sort'      => $sort,
            'facet'     => array($facet, $facet),
            'cb.urlver' => 1
        ];

        if ($query !== '') {
            $search['q'] = $query;
        }

        return $search;
    }

    /**
     * @param $name
     * @param $groupId
     * @return array
     * @throws InvalidSensorException
     */
    protected function getSensor($name, $groupId)
    {
        return Sensors::getSensor($name, $groupId);
    }

    /**
     * @param $params
     * @return $this
     * @throws InvalidArgumentException
     */
    public function verifyWatchlistParameters($params)
    {
        if (count(array_intersect_key($params, array_flip(self::$requiredWatchlistParameters))) < count(
                self::$requiredWatchlistParameters
            )
        ) {
            throw new InvalidArgumentException('Invalid watchlist parameters passed to query.');
        }
        // Ensure type is of events or modules
        if ($params['type'] !== 'events' && $params['type'] !== 'modules') {
            throw new InvalidArgumentException('Type must be one of events or modules');
        }
        // Ensure that searchQuery begins with q=
        if (substr($params['searchQuery'], 0, 2) !== 'q=') {
            throw new InvalidArgumentException('searchQuery must begin with q=<query>');
        }
        // Ensure that cbUrlVer begins with cb.urlver=
        if (substr($params['cbUrlVer'], 0, 10) !== 'cb.urlver=') {
            throw new InvalidArgumentException('cbUrlVer must begin with cb.urlver=<version>');
        }
    }

    /**
     * @param $cbUrlVer
     * @param $searchQuery
     * @return string
     * @throws InvalidArgumentException
     */
    public function formatWatchlistSearchQuery($cbUrlVer, $searchQuery)
    {
        if (substr($cbUrlVer, -1) !== '&') {
            $cbUrlVer .= '&';
        }

        $subQuery = substr($searchQuery, 2);
        array_map(
            function ($value) use ($searchQuery) {
                if (false === strpos($value, '=')) {
                    throw new \InvalidArgumentException(
                        sprintf('Invalid searchQuery arguments passed: %s', $searchQuery)
                    );
                }
            },
            explode('&', $subQuery)
        );

        if (substr($subQuery, -1) === '&') {
            $searchQuery = rtrim($subQuery, '&');
        }

        return urlencode($cbUrlVer . $searchQuery);
    }
}
