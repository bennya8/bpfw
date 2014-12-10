<?php

/**
 * Application
 * @namespace System\Core;
 * @package system.core.application
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Application extends Component
{

    /**
     * Application main method
     * @return Application
     */
    public static function main()
    {
        $application = DI::factory()->get('application');
        if (!$application instanceof self) {
            $application = new self();
            DI::factory()->set('application', $application);
        }
        return $application;
    }

    /**
     * Application Constructor
     */
    public function __construct()
    {
        Profiler::start();
        $this->registerMainService();
        $this->getDI('event')->notify('app_start');
        $this->registerService();
        $this->getDI('route')->dispatcher();
        $this->getDI('event')->notify('app_end');
        Profiler::end();
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
        $this->setDI('config', new Config());
        $this->setDI('event', new EventManager());
        $this->setDI('route', new Route());
        $this->setDI('request', new Request());
        $this->setDI('response', new Response());
        $this->setDI('view', new View());
    }

    /**
     * Register user components, namespaces, modules
     * @return void
     */
    protected function registerService()
    {
        $config = $this->getDI('config');
        $loader = $this->getDI('loader');
        $loader->import('Common.Constants', '.php');
        $loader->import('Common.Functions', '.php');
        $loader->registerNamespace($config->get('namespace'));
        $components = array_map('ucfirst', array_keys($config->get('component')));
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
        $modules = $config->get('module');
        foreach ($modules as $module) {
            $loader->registerNamespace($module['namespace']);
        }
        $helpers = $config->get('helper');
        foreach ($helpers as $name => $helper) {
            $this->setDI(strtolower($name), new $helper['class']);
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
            case 404:
            case 500:
                echo $exception->getMessage();
                break;
            default:
                echo 'runtime error: ' . $exception->getMessage();
        }
        if (ENVIRONMENT === 'development') {
            Profiler::printTrace();
        }
    }

    /**
     * Application error handler
     * @param $code
     * @param $message
     * @throws \Exception
     * @return void
     */
    public static function errorHandler($code = E_NOTICE, $message = '')
    {
        switch ($code) {
            case E_ERROR:
            case E_WARNING:
                throw new \Exception($message, $code);
                break;
            default:
                echo $message;
        }
        if (ENVIRONMENT === 'development') {
            Profiler::printTrace();
        }
    }

}