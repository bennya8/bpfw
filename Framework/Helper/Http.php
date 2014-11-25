<?php

/**
 * Http helper
 * @namespace System\Helper
 * @package system.helper.http
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Http
{

    /**
     * Header container
     * @access private
     * @var array
     */
    private $_header = array();

    /**
     * Query params container
     * @access private
     * @var array
     */
    private $_params = array();

    /**
     * User agent
     * @access private
     * @var string
     */
    private $_userAgent = '';

    /**
     * Reference url
     * @access private
     * @var string
     */
    private $_reference = '';

    /**
     * Set http reference url
     * @access public
     * @param string $url
     * @return void
     */
    public function setReference($url)
    {
        if (is_string($url) && !empty($ua)) {
            $this->_reference = $url;
        }
    }

    /**
     * Set http user agent
     * @access public
     * @param string $ua
     * @return void
     */
    public function setUserAgent($ua)
    {
        if (is_string($ua) && !empty($ua)) {
            $this->_userAgent = $ua;
        }
    }

    /**
     * Set query header
     * @access public
     * @param string|array $name
     * @param string $value
     * @return void
     */
    public function setHeader($name, $value = '')
    {
        if (is_string($name)) {
            $this->_header[$this->getHeaderFormatKey($name)] = $value;
        } else if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->_header[$this->getHeaderFormatKey($key)] = $value;
            }
        }
    }

    public function getHeaderFormatKey($key)
    {
        $key = ucwords(str_replace('_', ' ', strtolower($key)));
        $key = str_replace(' ', '-', $key);
        return $key;
    }

    /**
     * Set query params
     * @access public
     * @param string|array $name
     * @param string $value
     * @return void
     */
    public function setParams($name, $value = '')
    {
        if (is_string($name)) {
            $this->_params[$name] = $value;
        } else if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->_params[$key] = $value;
            }
        }
    }

    /**
     * Send a get request
     * @access public
     * @param string $url
     * @param array $params [optional]
     * @return bool | string
     */
    public function get($url, $params = array())
    {
        $this->setParams($params);
        return $this->_request('get', $url);
    }

    /**
     * Send a post request
     * @access public
     * @param string $url
     * @param array $params [optional]
     * @return bool | string
     */
    public function post($url, $params = array())
    {
        $this->setParams($params);
        return $this->_request('post', $url);
    }

    /**
     * Send a put request
     * @access public
     * @param string $url
     * @param array $params [optional]
     * @return bool | string
     */
    public function put($url, $params = array())
    {
        $this->setParams($params);
        return $this->_request('put', $url);
    }

    /**
     * Send a delete request
     * @access public
     * @param string $url
     * @param array $params [optional]
     * @return bool | string
     */
    public function delete($url, $params = array())
    {
        $this->setParams($params);
        return $this->_request('delete', $url);
    }

    /**
     * Handle a restful request
     * @access public
     * @param string $method
     * @param string $url
     * @return bool | string
     */
    private function _request($method, $url)
    {
        if (empty($url)) {
            return false;
        }
        $method = in_array($method, array('get', 'post', 'put', 'delete')) ? $method : 'get';
        $ch = curl_init();

        if (!empty($this->_header)) {
            $header = array();
            foreach ($this->_header as $k => $v) {
                $header[] = trim(trim($k, ' '), ':') . ': ' . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        if (!empty($this->_userAgent)) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->_userAgent);
        }

        if (!empty($this->_refrence)) {
            curl_setopt($ch, CURLOPT_REFERER, $this->_refrence);
        }

        if ($method == 'get' && !empty($this->_params)) {
            $url = $url . '?' . http_build_query($this->_params);
        } elseif ($method == 'post') {
            if (!empty($this->_params)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_params);
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        } elseif ($method == 'put') {
            if (!empty($this->_params)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_params);
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        } elseif ($method == 'delete') {
            if (!empty($this->_params)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_params);
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}
