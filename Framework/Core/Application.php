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

class Application
{

    /**
     * Application main entrance
     * @return void
     */
    public function main()
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
        $helpers = array('Assets', 'Http');
        foreach ($helpers as $helper) {
            $class = 'System\\Helper\\' . $helper;
            $this->setDI(strtolower($helper), new $class);
        }
        $modules = $config->get('module');
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
            case 404:
                echo $exception->getMessage();
                break;
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
                throw new \Exception($message, $code);
                break;
            default:
                echo $message;
        }
        if (ENVIRONMENT === 'development') {
            Profiler::printTrace();
        }
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