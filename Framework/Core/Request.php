<?php

/**
 * Request
 * @namespace System\Core
 * @package system.core.request
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Request
{
    protected $filter;

    public function __construct()
    {
        $this->filter = new Filter();
    }

    public function filter($value, $filter = 'string')
    {
        if (is_string($filter)) {
            $functions = explode(',', $filter);
            foreach ($functions as $function) {
                if (method_exists($this->filter, strtolower($function))) {
                    $value = call_user_func(array($this->filter, $function), $value);
                } else if (function_exists($function)) {
                    $value = call_user_func($function, $value);
                }
            }
        }
        return $value;
    }

    public function get($key, $default = '', $filter = false)
    {
        if ($filter) {
            return $_GET[$key] = $this->filter($_GET[$key], $filter, $default);
        } else {
            return $_GET[$key] = !empty($_GET[$key]) ? $_GET[$key] : $default;
        }
    }

    public function getPost($key, $default = false, $filter = false)
    {
        if (empty($_POST[$key]) && !isset($_POST[$key])) {
            return $_POST[$key] = $default;
        } else {
            return $_POST[$key] = $this->filter($_POST[$key], $filter);
        }
    }

    public function getParam($key, $default = '', $filter = false)
    {
        if ($filter) {
            return $_REQUEST[$key] = $this->filter($_REQUEST[$key], $filter);
        } else {
            return $_REQUEST[$key] = !empty($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
        }
    }

    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isPut()
    {
        return $_SERVER['REQUEST_METHOD'] === 'PUT';
    }

    public function isDelete()
    {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function getUserIp()
    {
        $ip = '';
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $ip;
    }

}