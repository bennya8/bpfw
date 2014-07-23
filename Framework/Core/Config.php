<?php

/**
 * Configuration
 * @namespace System\Core;
 * @package system.core.config
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Config
{

    /**
     * Config container
     * @var array
     */
    private $_config = array();

    /**
     * Constructor
     * Load app config file
     */
    public function __construct()
    {
        $config = APP_PATH . '/Config/Config.php';
        if (!is_file($config)) {
            throw new \Exception('config not found', E_USER_NOTICE);
        }
        $this->_config = require $config;
    }

    /**
     * Get exists config value with given key
     * @param $key
     * @return string
     */
    public function get($key)
    {
        return isset($this->_config[$key]) ? $this->_config[$key] : null;
    }

    /**
     * Set config with given key and value
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        return $this->_config[$key] = $value;
    }
}