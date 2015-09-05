<?php

namespace CBApi\Request\Rest;

use CBApi\Connection\RestConnection;
use CBApi\Sensors\Sensors;

/**
 * Class RestRequest
 *
 * @package CBApi\Request\Rest
 */
class RestRequest
{
    /** @var RestConnection */
    protected $restConnection;

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
    protected function getBaseSearch($query, $start, $rows, $sort, $facet)
    {
        $search = array(
            'start'     => $start,
            'rows'      => $rows,
            'sort'      => $sort,
            'facet'     => array($facet, $facet),
            'cb.urlver' => 1
        );

        if ($query !== '') {
            $search['q'] = $query;
        }

        return $search;
    }

    /**
     * @param $name
     * @param $groupId
     * @return array
     * @throws \CBApi\Sensors\Exception\InvalidSensorException
     */
    protected function getSensor($name, $groupId)
    {
        return Sensors::getSensor($name, $groupId);
    }
}
