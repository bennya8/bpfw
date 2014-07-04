<?php

/**
 * Cookie Helper
 * @namespace Wiicode\Core
 * @package wiicode.core.cookie
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Cookie
{
    /**
     * cookie prefix
     * @var string
     */
    protected $prefix = '';

    /**
     * cookie expire time (second)
     * @var int
     */
    protected $expire = 3600;

    /**1
     * cookie path
     * @var string
     */
    protected $path = '/';

    /**
     * cookie domain
     * @var null
     */
    protected $domain = null;

    /**
     * get cookie
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return isset($_COOKIE[$this->prefix . $name]) ? $_COOKIE[$this->prefix . $name] : '';
    }

    /**
     * set cookie
     * @param $name
     * @param $value
     * @return mixed
     */
    public function set($name, $value)
    {
        return $_COOKIE[$this->prefix . $name] = $value;
    }

    /**
     * renew cookie
     * @param $name
     * @param int $expire
     */
    public function renew($name, $expire = 3600)
    {
        if (isset($_COOKIE[$name])) {
            setcookie($this->prefix . $name, $_COOKIE[$name], time() + $expire, $this->path, $this->domain);
        }
    }

    /**
     * remove cookie
     * @param $name key of cookie
     */
    public function remove($name)
    {
        if (isset($_COOKIE[$name])) {
            setcookie($this->prefix . $name, '', time() - 1);
        }
    }
}