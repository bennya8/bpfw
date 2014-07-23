<?php

/**
 * Component
 * @namespace System\Core;
 * @package system.core.component
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

abstract class Component
{

    /**
     * Dependency inject container
     * @var array
     */
    private $_di = array();

    /**
     * Constructor
     */
    public function __construct($className = '')
    {
        if (empty($className)) {
            $className = explode('\\', get_class($this));
            $className = strtolower(array_pop($className));
        }
        $config = $this->getDI('config')->get('component');
        $config = $config[$className];
        if (!empty($config) && is_array($config)) {
            foreach ($config as $propKey => $propValue) {
                if (property_exists($this, $propKey)) {
                    $this->$propKey = $propValue;
                }
            }
        }
    }

    /**
     * Get object from di container
     * @param $name
     * @return bool
     */
    protected function getDI($name)
    {
        if (isset($this->_di[$name])) {
            return $this->_di[$name];
        } else {
            return DI::factory()->get($name);
        }
    }

    /**
     * Set object to di container
     * @param $name
     * @param $mixed
     * @param bool $shared
     */
    protected function setDI($name, $mixed, $shared = true)
    {
        if ($shared) {
            DI::factory()->set($name, $mixed);
        } else {
            $this->_di[$name] = $mixed;
        }
    }

    /**
     * Get exists property with given key
     * @param $key
     * @return null
     */
    public function __get($key)
    {
        return property_exists($this, $key) ? $this->$key : null;
    }

    /**
     * Set property with given key and value
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    /**
     * Unset property with given key
     * @param $key
     */
    public function __unset($key)
    {
        unset($this->$key);
    }

    /**
     * Invoke method
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return $this->$method($args);
        } else {
            throw new \Exception('invoke no exists method', E_WARNING);
        }
    }

    /**
     * Invoke static method
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public static function __callstatic($method, $args)
    {
        $class = get_called_class();
        if (method_exists($class, $method)) {
            return $class::$method($args);
        } else {
            throw new \Exception('invoke no exists static method', E_WARNING);
        }
    }
}
