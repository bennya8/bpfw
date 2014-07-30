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

    /**
     * Cache database instance
     * @access private
     * @var object
     */
    private $_db;

    /**
     * Fetch cache data with given key
     * @access public
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * Write cache data with given key and value
     * @access public
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
     * @access public
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Checks if the given key in the cache data
     * @access public
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * Free all data from cache data
     * @access public
     * @return mixed
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * Increment numeric item's value
     * @param $key
     * @param int $offset
     * @param int $initialValue
     * @param int $expiry
     * @return mixed
     */
    public function increment($key, $offset = 1, $initialValue = 0, $expiry = 0)
    {
        // TODO: Implement increment() method.
    }

    /**
     * Decrement numeric item's value
     * @param $key
     * @param int $offset
     * @param int $initialValue
     * @param int $expiry
     * @return mixed
     */
    public function decrement($key, $offset = 1, $initialValue = 0, $expiry = 0)
    {
        // TODO: Implement decrement() method.
    }


    /**
     * Open a cache server connection
     * @access public
     * @throws \Exception
     * @return mixed
     */
    public function open()
    {
        if (!class_exists('\\Redis')) {
            throw new \Exception('redis module not install');
        }
        $this->_db = new \Redis();



        $this->_db->connect('localhost');
    }

    /**
     * Close a cache server connection
     * @access public
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