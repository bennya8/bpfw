<?php

/**
 * Dependency injection
 * @namespace System\Core
 * @package system.core.di
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class DI
{

    /**
     * Instances container
     * @var array
     */
    protected static $_shared = array();

    /**
     * Self instance
     * @var object
     */
    protected static $_handle = null;

    /**
     * DI factory method
     * @return object
     */
    public static function factory()
    {
        if (!isset(self::$_handle) && !self::$_handle instanceof self) {
            self::$_handle = new self;
        }
        return self::$_handle;
    }

    /**
     * Get something from container
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return isset(self::$_shared[$name]) ? self::$_shared[$name] : false;
    }

    /**
     * Set something to container
     * @param $name
     * @param $mixed
     * @return mixed
     */
    public function set($name, $mixed)
    {
        if (!isset(self::$_shared[$name])) {
            self::$_shared[$name] = $mixed;
        }
        return self::$_shared[$name];
    }

    /**
     * Check whether given name object exists
     * @param $name
     * @return object / bool
     */
    public function has($name)
    {
        return isset(self::$_shared[$name]);
    }

}