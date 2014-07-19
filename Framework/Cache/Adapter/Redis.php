<?php

/**
 * Redis Adapter
 * @namespace System\Cache\Adapter
 * @package system.cache.adapter.redis
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Cache\Adapter;

use System\Cache\Cache;

class Redis extends Cache
{

    private $_db;

    /**
     * Fetch cache data with given key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * Write cache data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * Delete cache data with given key
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Checks if the given key in the cache data
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * Free all data from cache data
     * @return mixed
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * Open a cache server connection
     * @return mixed
     */
    public function open()
    {
        if(!class_exists('\\Redis')){
            throw new \Exception('redis module not install');
        }
        $this->_db = new \Redis();
        $this->_db->connect('localhost');
    }

    /**
     * Close a cache server connect
     * @return mixed
     */
    public function close()
    {
        return true;
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
        if (method_exists($this->_db, $method)) {
            $reflectMethod = new \ReflectionMethod($this->_db, $method);
            return $reflectMethod->invokeArgs($this->_db, $args);
        } else {
            throw new \Exception('invoke no exists method');
        }
    }

}