<?php

namespace CBApi\Rest;

/**
 * Class Put
 * @package CBApi\Rest
 */
class Put extends RestAbstract
{
    /**
     * Apply new license to server
     *
     * @param $license
     * @return mixed
     */
    public function license($license)
    {
        return $this->request->postRequest('/api/v1/license', array('license' => $license));
    }

    /**
     * Sets the Bit9 Platform Server configuration
     * This includes the server address, username, and password
     * Must authenticate as a global administrator to have the rights to set this config
     * config is expected to be an array with the following keys:
     * username : username for authentication
     * password : password for authentication
     * server   : server address
     *
     * @param $config
     * @return mixed
     */
    public function platformServerConfig($config)
    {
        return $this->request->postRequest('/api/v1/settings/global/platformserver', $config);
    }
}