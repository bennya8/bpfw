<?php

/**
 * Response
 * @namespace System\Core
 * @package system.core.response
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Response
{
    protected $header = array();

    protected $statusCode = array(
        200 => 'HTTP/1.1 200 OK',
        301 => 'HTTP/1.1 301 Moved Permanently',
        401 => 'HTTP/1.1 401 Unauthorized',
        403 => 'HTTP/1.1 403 Forbidden',
        404 => 'HTTP/1.1 404 Not Found',
        500 => 'HTTP/1.1 500 Internal Server Error',
        508 => 'HTTP/1.1 508 Loop Detected',
        510 => 'HTTP/1.1 510 Not Extended',
        600 => 'HTTP/1.1 600 Unparseable Response Headers'
    );

    protected $contentType = array(
        'binary' => 'Content-Type: application/octet-stream',
        'xml' => 'Content-Type: text/xml',
        'json' => 'Content-Type: application/json',
        'txt' => 'Content-Type: text/plain',
        'html' => 'Content-Type: text/html'
    );

    public function getHeader($name = '')
    {
        $header = array();
        foreach ($_SERVER as $key => $value) {
            if (strncmp($key, 'HTTP_', 5) === 0) {
                $header[substr($key, 5)] = $value;
            }
        }
        foreach ($header as $key => $value) {
            $key = ucwords(str_replace('_', ' ', strtolower($key)));
            $key = str_replace(' ', '-', $key);
            $this->header[$key] = $value;
        }
        if (empty($name)) {
            return $this->header;
        } else {
            return isset($this->header[$name]) ? $this->header[$name] : '';
        }
    }

    public function setHeader($name, $value = '')
    {
        $name = ucwords(str_replace('_', ' ', strtolower($name)));
        $name = str_replace(' ', '-', $name);
        $this->header[$name] = $value;
    }

    public function sendHeader($statusCode = 200, $contentType = 'html')
    {
        header($this->statusCode[$statusCode]);
        header($this->contentType[$contentType]);
        foreach ($this->header as $name => $value) {
            $name = ucwords(str_replace('_', ' ', strtolower($name)));
            $name = str_replace(' ', '-', $name);
            header($name . ': ' . $value);
        }
    }

    public function toApi($status = 0, $message = '', $data = array(), $return = 'json')
    {
        $data = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        switch ($return) {
            case 'json':
                $this->toJson($data);
                break;
            case 'jsonp':
                $this->toJsonp($data);
                break;
            case 'xml':
                $this->toXml($data);
                break;
        }
    }

    public function toJson($data)
    {
        exit(json_encode($data));
    }

    public function toJsonp($data)
    {
        $callback = isset($_GET['jsonp']) ? $_GET['jsonp'] : 'jsonp';
        exit($callback . '(' . json_encode($data) . ')');
    }

    public function toXml($data)
    {
        //@todo
        exit();
    }

    /**
     * Redirect url
     * @param string $url
     * @param string $params
     */
    public function redirect($url = '', $params = '')
    {
        $url = strtolower($url);
        if (strpos($url, 'https://') !== false || strpos($url, 'http://') !== false) {
            $this->setHeader('Location', $url);
        } else {
            $this->setHeader('Location', Uri::siteUrl($url, $params));
        }
        $this->sendHeader(301);
    }
}