<?php

/**
 * Memcached Session
 * @namespace System\Session\Adapter
 * @package system.session.adapter.memcached
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Session\Adapter;

use System\Session\Session;

class Memcached extends Session
{

    /**
     * Memcached database instance
     * @access private
     * @var object
     */
    private $_db;

    /**
     * Session open / connect method handler
     * @access protected
     * @return boolean
     */
    protected function _open()
    {
        $this->_db = new \System\Cache\Adapter\Memcached();
        return (boolean)$this->_db;
    }

    /**
     * Session close / disconnect method handler
     * @access protected
     * @return boolean
     */
    protected function _close()
    {
        return true;
    }

    /**
     * Session fetch data method handler
     * @access protected
     * @param array $data
     * @return array
     */
    protected function _read($data)
    {
        $record = $this->_db->get($this->prefix . $data[0]);
        return !empty($record) ? unserialize($record) : array();
    }

    /**
     * Session write data method handler
     * @access protected
     * @param array $data
     * @return void
     */
    protected function _write($data)
    {
        $this->_db->set($this->prefix . $data[0], serialize($data[1]), $this->expire);
    }

    /**
     * Session destroy method handler
     * @access protected
     * @param string $data
     * @return void
     */
    protected function _destroy($data)
    {
        $this->_db->delete($this->prefix . $data);
    }

    /**
     * Session garbage collection method handler
     * @access protected
     * @param int $expire
     * @return boolean
     */
    protected function _gc($expire)
    {
        return true;
    }

}