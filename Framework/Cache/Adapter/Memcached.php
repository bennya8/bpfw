<?php

/**
 * Memcached Adapter
 * @namespace System\Cache\Adapter
 * @package system.cache.adapter.memcached
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Cache\Adapter;

use System\Cache\Cache;
use System\Core\DI;

class Memcached extends Cache
{
    private $_db;

    public function __construct()
    {
        if (!class_exists('\Memcached')) {
            throw new \Exception('memcached module not install');
        }
        $this->_db = new \Memcached();

        $this->_db->set('abc', 123);

//        var_dump($this->_db->getResultCode());
//        var_dump($this->_db->getResultMessage());
//
//        var_dump($this->_db);


//        var_dump($this->_db->get('abc'));

    }

    /**
     * Fetch cache data with given key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {

    }

    /**
     * Write cache data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {


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
        // TODO: Implement open() method.
    }

    /**
     * Close a cache server connect
     * @return mixed
     */
    public function close()
    {
        // TODO: Implement close() method.
    }


}