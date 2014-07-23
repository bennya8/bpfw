<?php

/**
 * File Session
 * @namespace System\Session\Adapter
 * @package system.session.adapter.file
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Session\Adapter;

use System\Session\Session;

class File extends Session
{
    public function __construct()
    {
        session_save_path(ROOT_PATH . 'Runtime/Session/');
        ini_set('session.gc_probability', 1);
        if (!session_id()) session_start();
    }

    /**
     * Fetch session data with given key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Write session data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete session data with given key
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Checks if the given key in the session data
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Free all data from session data
     * @return mixed
     */
    public function flush()
    {
        $_SESSION = null;
    }

    /**
     * Destroy session
     * @return mixed
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * Get flash data with given key
     * @param $key
     * @return mixed
     */
    public function getFlash($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set flash data with key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setFlash($key, $value)
    {
        $key = 'flash_' . $key;
        $_SESSION[$key] = $value;
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