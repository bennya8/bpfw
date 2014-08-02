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
     * Redis instance
     * @access private
     * @var object
     */
    private $_db;

    /**
     * Redis servers config
     * @var array
     */
    protected $redisServers = array();

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
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->_db->set($key, $value);
    }

    /**
     * Delete cache data with given key
     * @access public
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        return $this->_db->del($key);
    }

    /**
     * Checks if the given key in the cache data
     * @access public
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return $this->_db->exists($key);
    }

    /**
     * Free all data from cache data
     * @access public
     * @param string $host
     * @return mixed
     */
    public function flush($host = '')
    {
        return in_array($host, $this->_db->_hosts()) ? $this->_db->_instance($host)->flush() : false;
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
        return $this->_db->exists($key) ? $this->_db->incrBy($key, $offset) : $this->_db->incrBy($key, $initialValue);
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
        return $this->_db->exists($key) ? $this->_db->decrBy($key, $offset) : $this->_db->decrBy($key, $initialValue);
    }

    /**
     * Open a cache server connection
     * @access public
     * @throws \Exception
     * @return bool
     */
    public function open()
    {
        if (!class_exists('\\Redis')) {
            throw new \Exception('redis module not install', E_ERROR);
        }
        if (empty($this->redisServers)) {
            throw new \Exception('redis servers not set', E_ERROR);
        }
        $servers = array();
        foreach ($this->redisServers as $server) {
            $servers[] = implode(':', $server);
        }
        $this->_db = new \RedisArray($servers);
        return true;
    }

    /**
     * Close a cache server connection
     * @access public
     * @return bool
     */
    public function close()
    {
        $servers = $this->_db->_hosts();
        foreach ($servers as $server) {
            $this->_db->_instance($server)->close();
        }
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
        if (method_exists('\\Redis', $method)) {
            return $this->_db->__call($method, $args);
        } else {
            throw new \Exception('invoke no exists method', E_ERROR);
        }
    }
}