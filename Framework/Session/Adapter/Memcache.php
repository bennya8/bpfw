<?php

/**
 * Memcache Session
 * @namespace System\Session\Adapter
 * @package system.session.adapter.memcache
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Session\Adapter;


use System\Session\Session;

class Memcache extends Session
{
    /**
     * Fetch session data with given key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * Write session data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * Delete session data with given key
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Checks if the given key in the session data
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * Free all data from session data
     * @return mixed
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * Destroy session
     * @return mixed
     */
    public function destroy()
    {
        // TODO: Implement destroy() method.
    }

    /**
     * Get flash data with given key
     * @param $key
     * @return mixed
     */
    public function getFlash($key)
    {
        // TODO: Implement getFlash() method.
    }

    /**
     * Set flash data with key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setFlash($key, $value)
    {
        // TODO: Implement setFlash() method.
    }

    /**
     * Session open / connect method handler
     * @return mixed
     */
    protected function _open()
    {
        // TODO: Implement _open() method.
    }

    /**
     * Session close / disconnect method handler
     * @return mixed
     */
    protected function _close()
    {
        // TODO: Implement _close() method.
    }

    /**
     * Session fetch data method handler
     * @return mixed
     */
    protected function _read()
    {
        // TODO: Implement _read() method.
    }

    /**
     * Session write data method handler
     * @return mixed
     */
    protected function _write()
    {
        // TODO: Implement _write() method.
    }

    /**
     * Session destroy method handler
     * @return mixed
     */
    protected function _destroy()
    {
        // TODO: Implement _destroy() method.
    }

    /**
     * Session garbage collection method handler
     * @return mixed
     */
    protected function _gc()
    {
        // TODO: Implement _gc() method.
    }


}