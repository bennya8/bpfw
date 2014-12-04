<?php

/**
 * Controller
 * @namespace System\Core
 * @package system.core.controller
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

abstract class Controller extends Component
{

    /**
     * View instance
     * @access protected
     * @var object
     */
    protected $view;

    /**
     * Request instance
     * @access protected
     * @var Request
     */
    protected $request;

    /**
     * Response instance
     * @access protected
     * @var Response
     */
    protected $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->request = $this->getDI('request');
        $this->response = $this->getDI('response');
        $this->view = $this->getDI('view');
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
    }

    /**
     * Display a view with layout
     * @access public
     * @param $template
     * @param $cache_id
     * @return void
     */
    public function render($template, $cache_id = '')
    {
        $this->view->render($template, $cache_id);
    }

    /**
     * Display a view without layout
     * @access public
     * @param $template
     * @param string $cache_id
     * @return void
     */
    public function partial($template, $cache_id = '')
    {
        $this->view->partial($template, $cache_id);
    }

    /**
     * Register template variables
     * @access public
     * @param $name
     * @param string $value
     * @return void
     */
    public function assign($name, $value = '')
    {
        $this->view->setData($name, $value);
    }

    /**
     * Get base url
     * @return string
     */
    public function baseUrl()
    {
        return Uri::baseUrl();
    }

    /**
     * Get a formatted site url
     * @param string $url
     * @param string $params
     * @return array | string
     */
    public function siteUrl($url = '', $params = '')
    {
        return Uri::siteUrl($url, $params);
    }

    /**
     * Get params from $_GET
     * @access public
     * @param string $key
     * @param string $default
     * @param string $filter
     * @return mixed
     */
    public function get($key, $default = '', $filter = null)
    {
        return $this->request->getParam('get', $key, $default, $filter);
    }

    /**
     * Get a param from $_POST
     * @access public
     * @param string $key
     * @param string $default
     * @param string $filter
     * @return mixed
     */
    public function getPost($key, $default = '', $filter = null)
    {
        return $this->request->getParam('post', $key, $default, $filter);
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
        return $this->request->getParam($input, $key, $default, $filter);
    }

    /**
     * Detect a http get method request
     * @access public
     * @return bool
     */
    public function isGet()
    {
        return $this->request->isGet();
    }

    /**
     * Detect a http post method request
     * @access public
     * @return bool
     */
    public function isPost()
    {
        return $this->request->isPost();
    }

    /**
     * Detect a http put method request
     * @access public
     * @return bool
     */
    public function isPut()
    {
        return $this->request->isPut();
    }

    /**
     * Detect a http delete method request
     * @access public
     * @return bool
     */
    public function isDelete()
    {
        return $this->request->isDelete();
    }

    /**
     * Detect an ajax request
     * @access public
     * @return bool
     */
    public function isAjax()
    {
        return $this->request->isAjax();
    }

    /**
     * Get user agent
     * @access public
     * @return string
     */
    public function getUserAgent()
    {
        return $this->request->getUserAgent();
    }

    /**
     * Get user ip address
     * @access public
     * @return string
     */
    public function getUserIp()
    {
        return $this->request->getUserIp();
    }

    /**
     * @param string $url
     */
    public function redirect($url = '')
    {
        $this->response->redirect($url);
    }

    /**
     * @param string $name
     * @return array|string
     */
    public function getHeader($name = '')
    {
        return $this->response->getHeader($name);
    }


    /**
     * @param $name
     * @param string $value
     */
    public function setHeader($name, $value = '')
    {
        $this->response->setHeader($name, $value);
    }

    /**
     * @param int $statusCode
     * @param string $contentType
     */
    public function sendHeader($statusCode = 200, $contentType = 'html')
    {
        $this->response->sendHeader($statusCode, $contentType);
    }

    /**
     * @param int $status
     * @param string $message
     * @param array $data
     * @param string $return
     */
    public function toApi($code = 0, $message = '', $data = array(), $return = 'json')
    {
        $this->response->toApi($code, $message, $data, $return);
    }

    /**
     * @param $data
     */
    public function toJson($data)
    {
        $this->response->toJson($data);
    }

    /**
     * @param $data
     */
    public function toXml($data)
    {
        $this->response->toXml($data);
    }

}