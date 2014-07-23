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
     * Open a cache server connection
     * @access public
     * @return mixed
     */
    public function open()
    {
        if (!class_exists('\\Memcached')) {
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
     * Close a cache server connect
     * @access public
     * @return mixed
     */
    public function close()
    {
        return true;
    }


}