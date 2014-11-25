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

    /**
     * Header maps
     * @var array
     */
    protected $header = array();

    /**
     * Http response status code
     * @var array
     */
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

    /**
     * Http response content type
     * @var array
     */
    protected $contentType = array(
        'binary' => 'Content-Type: application/octet-stream',
        'xml' => 'Content-Type: text/xml',
        'json' => 'Content-Type: application/json',
        'txt' => 'Content-Type: text/plain',
        'html' => 'Content-Type: text/html'
    );

    /**
     * Get request header list or single value with given key
     * @param string $name
     * @return array|string
     */
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

    /**
     * Set a response header message
     * @param $name
     * @param string $value
     */
    public function setHeader($name, $value = '')
    {
        $name = ucwords(str_replace('_', ' ', strtolower($name)));
        $name = str_replace(' ', '-', $name);
        $this->header[$name] = $value;
    }

    /**
     * Send a bunch of headers
     * @param int $statusCode
     * @param string $contentType
     */
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

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     * @param string $return
     */
    public function toApi($code = 0, $message = '', $data = array(), $return = 'json')
    {
        $data = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        switch ($return) {
            case 'json':
                $this->sendHeader(200, 'json');
                $this->toJson($data);
                break;
            case 'jsonp':
                $this->sendHeader(200, 'jsonp');
                $this->toJsonp($data);
                break;
            case 'xml':
                $this->sendHeader(200, 'xml');
                $dom = new \DomDocument('1.0', 'utf-8');
                $response = $dom->createElement('response');
                $dom->appendChild($response);
                $elemCode = $dom->createElement('code', $data['code']);
                $response->appendchild($elemCode);
                $elemCode = $dom->createElement('message', $data['message']);
                $response->appendchild($elemCode);
                $results = $dom->createElement('data');
                $this->xml_encode($data['data'], $results, $dom);
                $response->appendchild($results);
                exit($dom->saveXML());
                break;
        }
    }

    /**
     * Encode data with application/json document format
     * @param $data
     * @return string
     */
    public function toJson($data)
    {
        return json_encode($data);
    }

    /**
     * Encode data with application/jsonp document format
     * @param $data mixed
     * @return string
     */
    public function toJsonp($data)
    {
        $callback = isset($_GET['jsonp']) ? $_GET['jsonp'] : 'jsonp';
        return $callback . '(' . json_encode($data) . ')';
    }

    /**
     * Encode data with html/xml document format
     * @param $data mixed
     * @param $rootElement string
     * @return string
     */
    public function toXml($data, $rootElement = 'response')
    {
        $dom = new \DomDocument('1.0', 'utf-8');
        $root = $dom->createElement($rootElement);
        $this->xml_encode($data, $root, $dom);
        $dom->appendChild($root);
        return $dom->saveXML();
    }

    /**
     * Recursive encode xml
     * @param $data mixed
     * @param $results \Object
     * @param $dom \DomDocument
     */
    protected function xml_encode($data, $results, $dom)
    {
        foreach ($data as $key => $obj) {
            $key = is_numeric($key) ? 'item' : $key;
            if (is_object($obj) || is_array($obj)) {
                $item = $dom->createElement($key);
                foreach ($obj as $attrKey => $attrVal) {
                    $attrKey = is_numeric($attrKey) ? 'item' : $attrKey;
                    if (is_array($attrVal) || is_object($attrVal)) {
                        $this->xml_encode($attrVal, $item, $dom);
                    } else {
                        $node = $dom->createElement($attrKey, htmlspecialchars(strval($attrVal)));
                        $item->appendChild($node);
                    }
                }
                $results->appendChild($item);
            } else {
                $item = $dom->createElement($key, htmlspecialchars(strval($obj)));
                $results->appendChild($item);
            }
        }
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