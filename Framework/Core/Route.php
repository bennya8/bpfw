<?php

/**
 * Route
 * @namespace System\Core
 * @package system.core.route
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Route extends Component
{

    /**
     * Url mode, support queryinfo / pathinfo / rewrite
     * @var string
     */
    protected $mode = 'pathinfo';

    /**
     * Rewrite rules, only available while using rewrite mode
     * @var array
     */
    protected $rules = array();

    /**
     * Query info get module param
     * @var string
     */
    protected $moduleParam = 'm';

    /**
     * Query info get controller param
     * @var string
     */
    protected $controllerParam = 'c';

    /**
     * Query info get action param
     * @var string
     */
    protected $actionParam = 'a';

    /**
     * Default module
     * @var string
     */
    protected $defaultModule = 'site';

    /**
     * Default controller
     * @var string
     */
    protected $defaultController = 'index';

    /**
     * Default action
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * Dispatch handle
     * @var array
     */
    protected $dispatch = array(
        'module' => '',
        'controller' => '',
        'action' => ''
    );

    /**
     * Make a dispatcher
     * @access public
     * @throws \Exception
     * @return void
     */
    public function dispatcher()
    {
        $this->getDI('event')->notify('dispatcher_start');

        $this->parseUrl();

        define('MODULE', $this->dispatch['module']);
        define('CONTROLLER', $this->dispatch['controller']);
        define('ACTION', $this->dispatch['action']);

        $modules = $this->getDI('config')->get('module');
        if (!isset($modules[MODULE]) && !isset($modules[MODULE]['path'])) {
            throw new \Exception('module not exists', 404);
        }

        $controller = $modules[MODULE]['path'] . '\\Controller\\' . ucfirst(strtolower(CONTROLLER));
        if (!class_exists($controller)) {
            throw new \Exception('controller not exists', 404);
        }

        $reflect = new \ReflectionClass($controller);
        if (!$reflect->hasMethod(ACTION)) {
            throw new \Exception('action not exists', 404);
        }

        $reflectMethod = $reflect->getMethod(ACTION);
        if (!$reflectMethod->isPublic()) {
            throw new \Exception('action permission denied', 404);
        }

        $reflectMethod->invoke(new $controller());

        $this->getDI('event')->notify('dispatcher_end');
    }

    /**
     * Parse url
     * @access protected
     * @return void
     */
    protected function parseUrl()
    {
        if ($this->mode == 'pathinfo') {
            $url = explode('/', trim(str_replace('\\', '/', $_SERVER['PATH_INFO']), '/'));
            $this->dispatch['module'] = !empty($url) ? array_shift($url) : $this->defaultModule;
            $this->dispatch['controller'] = !empty($url) ? array_shift($url) : $this->defaultController;
            $this->dispatch['action'] = !empty($url) ? array_shift($url) : $this->defaultAction;
            if (!empty($url)) {
                $key = $value = array();
                foreach ($url as $k => $v) {
                    if ($k % 2 == 0) {
                        $key[] = $v;
                    } else {
                        $value[] = $v;
                    }
                }
                $value = array_pad($value, count($key), '');
                $_GET = array_merge($_GET, array_combine($key, $value));
            }
        } elseif ($this->mode == 'rewrite') {
            $url = str_replace('\\', '/', $_SERVER['PATH_INFO']);
            foreach ($this->rules as $regex => $route) {
                $regex = str_replace('/', '\/', preg_replace('(\(:\w*\))', '(\w*)', $regex));
                if (preg_match("/^" . $regex . "$/", $url, $match)) {
                    if (isset($route[0])) {
                        $dispatch = explode('/', $route[0]);
                        $this->dispatch['module'] = !empty($dispatch) ? array_shift($dispatch) : $this->defaultModule;
                        $this->dispatch['controller'] = !empty($dispatch) ? array_shift($dispatch) : $this->defaultController;
                        $this->dispatch['action'] = !empty($dispatch) ? array_shift($dispatch) : $this->defaultAction;
                    }
                    if (isset($route[1]) && is_string($route[1])) {
                        preg_match_all("/\(:(\w*)\)/", $route[1], $matchParams);
                        if (isset($matchParams[1]) && is_array($matchParams[1])) {
                            array_shift($match);
                            $match = array_pad($match, count($matchParams[1]), '');
                            $_GET = array_merge(array_combine($matchParams[1], $match), $_GET);
                        }
                    }
                    break;
                }
            }
        } else {
            $this->dispatch['module'] = isset($_GET['m']) && !empty($_GET['m']) ? $_GET['m'] : $this->defaultModule;
            $this->dispatch['controller'] = isset($_GET['c']) && !empty($_GET['c']) ? $_GET['c'] : $this->defaultController;
            $this->dispatch['action'] = isset($_GET['a']) && !empty($_GET['a']) ? $_GET['a'] : $this->defaultAction;
        }
    }

}