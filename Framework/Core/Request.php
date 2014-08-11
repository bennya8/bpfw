<?php

/**
 * Request
 * @namespace System\Core
 * @package system.core.request
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Request
{

    /**
     * Filter instance
     * @var object
     */
    protected $filter;

    /**
     * Request params container
     * @var array
     */
    private $_params = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filter = new Filter();
    }

    /**
     * Get all input params
     * @access public
     * @param string $input get,post,put,delete,cookie,request
     * @param string $key
     * @param string $default
     * @param string $filter
     * @return mixed
     */
    public function getParam($input, $key, $default = '', $filter = null)
    {
        if (strtolower($input) == 'put' || strtolower($input) == 'delete') {
            parse_str(file_get_contents('php://input'), $this->_params);
            $_REQUEST = $this->_params + $_REQUEST;
        } elseif (strtolower($input) == 'post') {
            $this->_params =& $_POST;
        } elseif (strtolower($input) == 'get') {
            $this->_params =& $_GET;
        } elseif (strtolower($input) == 'cookie') {
            $this->_params =& $_COOKIE;
        } elseif (strtolower($input) == 'request') {
            $this->_params =& $_REQUEST;
        }
        if (!isset($this->_params[$key])) {
            return $this->_params[$key] = $default;
        } else if (!$filter) {
            return $this->_params[$key];
        } else {
            return $this->_params[$key] = $this->filter($this->_params[$key], $filter);
        }
    }

    /**
     * Detect a http get method request
     * @access public
     * @return bool
     */
    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Detect a http post method request
     * @access public
     * @return bool
     */
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Detect a http put method request
     * @access public
     * @return bool
     */
    public function isPut()
    {
        return $_SERVER['REQUEST_METHOD'] === 'PUT';
    }

    /**
     * Detect a http delete method request
     * @access public
     * @return bool
     */
    public function isDelete()
    {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    /**
     * Detect an ajax request
     * @access public
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Get user agent
     * @access public
     * @return string
     */
    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Get user ip address
     * @access public
     * @return string
     */
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

    /**
     * Inputs filter
     * @access protected
     * @param mixed $value
     * @param string $filter
     * @return mixed
     */
    protected function filter($value, $filter = 'string')
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

}