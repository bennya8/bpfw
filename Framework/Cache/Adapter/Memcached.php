<?php

/**
 * Memcached Adapter
 * @namespace System\Cache\Adapter
 * @package system.cache.adapter.memcached
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Cache\Adapter;

use System\Cache\Cache;

class Memcached extends Cache
{

    /**
     * Memcached instance
     * @access private
     * @var object
     */
    private $_db;

    /**
     * Memcached servers config
     * @var array
     */
    protected $memcachedServers = array();

    /**
     * Fetch cache data with given key
     * @access public
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->_db->get($key);
    }


    /**
     * Write cache data with given key and value
     * @access public
     * @param $key
     * @param $value
     * @param int $expire
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        return $this->_db->set($key, $value, $expire);
    }

    /**
     * Delete cache data with given key
     * @access public
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        return $this->_db->delete($key);
    }

    /**
     * Checks if the given key in the cache data
     * @access public
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return (boolean)$this->_db->get($key);
    }

    /**
     * Increase
     */
    public function increment($key, $offset = 1, $initial_value = 0, $expiry = 0)
    {


    }

    public function decrement($key, $offset = 1, $initial_value = 0, $expiry = 0)
    {
        // TODO: Implement decrement() method.
    }


    /**
     * Free all data from cache data
     * @access public
     * @return mixed
     */
    public function flush()
    {
        return $this->_db->flush();
    }

    /**
     * Open a cache server connection
     * @access public
     * @throws \Exception
     * @return bool
     */
    public function open()
    {
        if (!class_exists('\\Memcached')) {
            throw new \Exception('memcached module not install');
        }
        $this->_db = new \Memcached();
        $this->_db->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
        $this->_db->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, TRUE);
        $this->_db->addServers($this->memcachedServers);
        return true;
    }

    /**
     * Close a cache server connection
     * @access public
     * @return bool
     */
    public function close()
    {
        $this->_db->resetServerList();
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
            throw new \Exception('invoke no exists method', E_ERROR);
        }
    }
}