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
     * View component instance
     * @var View
     */
    protected $view;

    /**
     * Request component instance
     * @var Request
     */
    protected $request;

    /**
     * Response component instance
     * @var Response
     */
    protected $response;

    /**
     * Constructor
     * Initialize components
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();
    }

    /**
     * Display template
     * @param $template
     */
    public function render($template)
    {
        $this->view->render($template);
    }



    /**
     * Register template variables
     * @param $name
     * @param string $value
     */
    public function assign($name, $value = '')
    {
        $this->view->setData($name, $value);
    }


    public function get($key, $default = '', $filter = false)
    {
        return $this->request->get($key, $default, $filter);
    }

    public function getPost($key, $default = false, $filter = false)
    {
        return $this->request->getPost($key, $default, $filter);
    }

    public function getParam($key, $default = '', $filter = false)
    {
        return $this->request->getParam($key, $default, $filter);
    }

    public function isGet()
    {
        return $this->request->isGet();
    }

    public function isPost()
    {
        return $this->request->isPost();
    }

    public function isPut()
    {
        return $this->request->isPut();
    }

    public function isDelete()
    {
        return $this->request->isDelete();
    }

    public function isAjax()
    {
        return $this->request->isAjax();
    }

    public function getUserAgent()
    {
        return $this->request->getUserAgent();
    }

    public function getUserIp()
    {
        return $this->request->getUserIp();
    }

    public function getBaseUrl()
    {
        return $this->request->getBaseUrl();
    }

    public function redirect($url = '')
    {
        $this->response->redirect($url);
    }

    public function getHeader($name = '')
    {
        return $this->response->getHeader($name);
    }


    public function setHeader($name, $value = '')
    {
        $this->response->setHeader($name, $value);
    }

    public function sendHeader($statusCode = 200, $contentType = 'html')
    {
        $this->response->sendHeader($statusCode, $contentType);
    }

    public function toApi($status = 0, $message = '', $data = array(), $return = 'json')
    {
        $this->response->toApi($status, $message, $data, $return);
    }

    public function toJson($data)
    {
        $this->response->toJson($data);
    }

    public function toXml($data)
    {
        $this->response->toXml($data);
    }

}