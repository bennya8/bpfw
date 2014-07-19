<?php

namespace System\Core;

class Application
{
    public static $version = 'alpha';

    private $_di = array();

    public function main()
    {
        $this->registerMainService();
        $this->getDI('event')->notify('app_start');
        $this->registerService();
        $this->getDI('event')->notify('dispatcher_start');
        $this->getDI('route')->dispatcher();
        $this->getDI('event')->notify('dispatcher_end');
        $this->getDI('event')->notify('app_end');
    }

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
//        set_exception_handler(array('System\\Core\\Application', 'exceptionHandler'));
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

    protected function registerService()
    {
        $loader = $this->getDI('loader');
        $loader->registerNamespace($this->getDI('config')->get('namespace'));
        $components = array_map('ucfirst', array_keys($this->getDI('config')->get('component')));
        $services = array('Logger', 'Profiler', 'Cookie', 'Translate', 'Security');
        $factoryServices = array('Cache', 'Database', 'Session');
        foreach ($components as $component) {
            if (in_array($component, $services)) {
                $class = 'System\\Core\\' . $component;
                $this->setDI($component, new $class);
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

    protected function getDI($name)
    {
        if (isset($this->_di[$name])) {
            return $this->_di[$name];
        } else {
            return DI::factory()->get($name);
        }
    }

    protected function setDI($name, $mixed, $shared = true)
    {
        if (!$shared) {
            $this->_di[$name] = $mixed;
        } else {
            DI::factory()->set($name, $mixed);
        }
    }

    public static function exceptionHandler($exception)
    {
        echo $exception->getMessage();

        switch ($exception->getCode()) {
            case E_ERROR:
            case E_STRICT:
            case E_DEPRECATED:
            case E_WARNING:
            case E_PARSE:
            case E_NOTICE:
        }
    }

    public static function errorHandler($code, $message)
    {
        throw new \Exception($message, $code);
    }

    public function __get($name)
    {
        return $this->getDI($name);
    }

    public function __set($name, $value)
    {
        $this->setDI($name, $value);
    }
}