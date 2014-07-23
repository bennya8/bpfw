<?php

/**
 * Cookie
 * @namespace System\Core
 * @package system.core.cookie
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Cookie extends Component
{

    /**
     * Cookie encrypt setting
     * @var bool
     */
    protected $encrypt = true;

    /**
     * Cookie encrypt key
     * @var string
     */
    protected $encryptKey = 'kl2j34';

    /**
     * Cookie prefix
     * @var string
     */
    protected $prefix = '';

    /**
     * Cookie expire time (second)
     * @var int
     */
    protected $expire = 3600;

    /**
     * Cookie path
     * @var string
     */
    protected $path = '/';

    /**
     * Cookie domain
     * @var string
     */
    protected $domain = '';

    /**
     * Get cookie
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return isset($_COOKIE[$this->prefix . $name]) ? $_COOKIE[$this->prefix . $name] : '';
    }

    /**
     * Set cookie
     * @param $name
     * @param $value
     * @param int $expire
     * @return mixed
     */
    public function set($name, $value, $expire = 3600)
    {
        setcookie($this->prefix . $name, $value, time() + $expire, $this->path, $this->domain);
    }

    /**
     * Remove cookie
     * @param $name key of cookie
     */
    public function remove($name)
    {
        if (isset($_COOKIE[$name])) {
            setcookie($this->prefix . $name, '', time() - 1);
        }
    }

}