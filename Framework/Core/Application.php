<?php

/**
 * Application
 * @namespace System\Core;
 * @package system.core.application
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Application
{

    /**
     * Application main entrance
     * @return void
     */
    public function main()
    {
        $this->registerMainService();
        Profiler::trace('app_start');
        $this->getDI('event')->notify('app_start');
        $this->registerService();
        $this->getDI('event')->notify('dispatcher_start');
        $this->getDI('route')->dispatcher();
        $this->getDI('event')->notify('dispatcher_end');
        $this->getDI('event')->notify('app_end');
        Profiler::trace('app_end');
    }

    /**
     * Register core components
     * @return void
     */
    protected function registerMainService()
    {
        switch (strtolower(ENVIRONMENT)) {
            case 'development':
            case 'testing':
                error_reporting(-1);
                break;
            default:
                error_reporting(0);
        }
        set_exception_handler(array('System\\Core\\Application', 'exceptionHandler'));
        set_error_handler(array('System\\Core\\Application', 'errorHandler'));
        require SYSTEM_PATH . 'Core/Loader.php';
        $loader = new Loader();
        $loader->register();
        $loader->registerNamespace(array(
            'System\\Cache' => SYSTEM_PATH . 'Cache',
            'System\\Cache\\Adapter' => SYSTEM_PATH . 'Cache/Adapter',
            'System\\Core' => SYSTEM_PATH . 'Core',
            'System\\Event' => SYSTEM_PATH . 'Event',
            'System\\Extend' => SYSTEM_PATH . 'Extend',
            'System\\Database' => SYSTEM_PATH . 'Database',
            'System\\Database\\Adapter' => SYSTEM_PATH . 'Database/Adapter',
            'System\\Database\\Adapter\\MySQL' => SYSTEM_PATH . 'Database/Adapter/MySQL',
            'System\\Database\\Adapter\\MySQLi' => SYSTEM_PATH . 'Database/Adapter/MySQLi',
            'System\\Database\\Adapter\\PDO' => SYSTEM_PATH . 'Database/Adapter/PDO',
            'System\\Helper' => SYSTEM_PATH . 'Helper',
            'System\\Session' => SYSTEM_PATH . 'Session',
            'System\\Session\\Adapter' => SYSTEM_PATH . 'Session/Adapter',
        ));
        $this->setDI('loader', $loader);
        $this->setDI('config', new Config());
        $this->setDI('event', new EventManager());
        $this->setDI('route', new Route());
    }

    /**
     * Register user components, namespaces, modules
     * @return void
     */
    protected function registerService()
    {
        $loader = $this->getDI('loader');
        $loader->import('Common.Constants','.php');
        $loader->import('Common.Functions','.php');
        $loader->registerNamespace($this->getDI('config')->get('namespace'));
        $components = array_map('ucfirst', array_keys($this->getDI('config')->get('component')));
        $services = array('Logger', 'Profiler', 'Cookie', 'Translate', 'Security');
        $factoryServices = array('Cache', 'Database', 'Session');
        foreach ($components as $component) {
            if (in_array($component, $services)) {
                $class = 'System\\Core\\' . $component;
                $this->setDI(strtolower($component), new $class);
            } elseif (in_array($component, $factoryServices)) {
                $class = 'System\\' . $component . '\\' . $component;
                $this->setDI(strtolower($component), $class::factory());
            }
        }
        $modules = $this->getDI('config')->get('module');
        foreach ($modules as $module) {
            $loader->registerNamespace($module['namespace']);
        }
    }

    /**
     * Application exception handler
     * @access protected
     * @param $exception \Exception
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        switch ($exception->getCode()) {
            case E_ERROR:
            case E_STRICT:
            case E_DEPRECATED:
            case E_WARNING:
            case E_PARSE:
            case E_NOTICE:
                echo 'server error: '.$exception->getMessage();

            break;
            case 404:
                echo 'page not found';
                break;
        }
    }

    /**
     * Application error handler
     * @param $code
     * @param $message
     * @throws \Exception
     * @return void
     */
    public static function errorHandler($code = '', $message = '')
    {
        throw new \Exception($message, $code);
    }

    /**
     * Get instance from di container
     * @param $name
     * @return mixed
     */
    protected function getDI($name)
    {
        return DI::factory()->get($name);
    }

    /**
     * Set instance to di container
     * @param $name
     * @param $mixed
     * @return mixed
     */
    protected function setDI($name, $mixed)
    {
        return DI::factory()->set($name, $mixed);
    }

    /**
     * Magic get method
     * Get instance from di container
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getDI($name);
    }

    /**
     * Magic set method
     * Set instance to di container
     * @param $name
     * @param $mixed
     * @return mixed
     */
    public function __set($name, $mixed)
    {
        return $this->setDI($name, $mixed);
    }

}