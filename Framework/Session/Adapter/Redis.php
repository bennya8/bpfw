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

class Redis extends Session
{

    /**
     * Session open / connect method handler
     * @access protected
     * @return boolean
     */
    protected function _open()
    {
        // TODO: Implement _open() method.
    }

    /**
     * Session close / disconnect method handler
     * @access protected
     * @return boolean
     */
    protected function _close()
    {
        // TODO: Implement _close() method.
    }

    /**
     * Session fetch data method handler
     * @access protected
     * @param array $data
     * @return array
     */
    protected function _read($data)
    {
        // TODO: Implement _read() method.
    }

    /**
     * Session write data method handler
     * @access protected
     * @param array $data
     * @return void
     */
    protected function _write($data)
    {
        // TODO: Implement _write() method.
    }

    /**
     * Session destroy method handler
     * @access protected
     * @param string $data
     * @return void
     */
    protected function _destroy($data)
    {
        // TODO: Implement _destroy() method.
    }

    /**
     * Session garbage collection method handler
     * @access protected
     * @param int $expire
     * @return void
     */
    protected function _gc($expire)
    {
        // TODO: Implement _gc() method.
    }

}