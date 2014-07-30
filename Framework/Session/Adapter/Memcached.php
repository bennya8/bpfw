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

class Memcached extends Session
{

    /**
     * Session open / connect method handler
     * @return mixed
     */
    protected function _open(){
        new \Memcache();


    }

    /**
     * Session close / disconnect method handler
     * @return mixed
     */
    protected function _close(){}

    /**
     * Session fetch data method handler
     * @param $data
     * @return mixed
     */
    protected function _read($data){}

    /**
     * Session write data method handler
     * @param $data
     * @return void
     */
    protected function _write($data){}

    /**
     * Session destroy method handler
     * @param $data
     * @return void
     */
    protected function _destroy($data){}

    /**
     * Session garbage collection method handler
     * @param $expire
     * @return void
     */
    protected function _gc($expire){}

}