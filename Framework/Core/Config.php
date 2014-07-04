<?php

namespace System\Core;

class Config
{
    private $_config = array();

    public function __construct()
    {
        $config = APP_PATH . '/Config/Config.php';
        if (is_file($config)) {
            $this->_config = require $config;
        }
    }


    public function get($name)
    {
        return isset($this->_config[$name]) ? $this->_config[$name] : array();
    }

    public function set($name, $value)
    {
        return $this->_config[$name] = $value;
    }
}