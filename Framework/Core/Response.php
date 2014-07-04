<?php

namespace System\Core;

class Response extends Component
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
        'xml' => 'Content-Type: text/xml;',
        'json' => 'Content-Type: application/json',
        'txt' => 'Content-Type: text/plain',
        'html' => 'Content-Type: text/html'
    );

    public function getHeader()
    {
    }

    public function setHeader($name, $value)
    {

    }

    public function sendHeader(){
        header();
    }


    public function setStatusCode($code)
    {
        header(self::$statusCode[$code]);
    }

    public function setContentType()
    {

    }

    public function toJson()
    {

    }

    public function toXML()
    {
    }

}