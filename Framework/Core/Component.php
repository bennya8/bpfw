<?php

/**
 * Component
 * @namespace System\Core
 * @package system.core.component
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

abstract class Component
{

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
        if (isset($config[$className])) {
            if (!empty($config[$className]) && is_array($config[$className])) {
                foreach ($config[$className] as $propKey => $propValue) {
                    if (property_exists($this, $propKey)) {
                        $this->$propKey = $propValue;
                    }
                }
            }
        }
    }

    /**
     * Get object from di container
     * @access public
     * @param string $name
     * @return mixed
     */
    protected function getDI($name)
    {
        return DI::factory()->get($name);
    }

    /**
     * Set object to di container
     * @access protected
     * @param string $name
     * @param mixed $mixed
     * @param void
     */
    protected function setDI($name, $mixed)
    {
        DI::factory()->set($name, $mixed);
    }

    /**
     * Get exists property with given key
     * @access public
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        } else {
            return $this->getDI($key);
        }
    }

    /**
     * Set property with given key and value
     * @access public
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        } else {
            $this->setDI($key, $value);
        }
    }

    /**
     * Unset property with given key
     * @access public
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->$key);
    }

    /**
     * Invoke method
     * @access public
     * @param string $method
     * @param array $args
     * @throws \Exception
     * @return mixed
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
     * @access public
     * @param string $method
     * @param array $args
     * @throws \Exception
     * @return mixed
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
