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
    protected $request;

    /**
     * @param RestConnection $request
     */
    public function __construct(RestConnection $request)
    {
        $this->request = $request;
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
     * @param $groupId
     * @return array
     */
    protected function getSensorMapping($groupId)
    {
        return Sensors::getSensorMapping($groupId);
    }
}
