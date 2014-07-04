<?php

namespace System\Core;

class Application
{
    public static $version = 'alpha';

    public function main()
    {
        $this->initSystemCommon();
        $this->registerNamespace();
        // event :: app start


        $this->registerService();
        $this->registerModule();


        // event :: dispatch start



        // event :: dispatch end


        // event :: app end

//        Debug::start();
//        Debug::trace(__METHOD__);
//
//
//        $this->_initialize();
//        echo Debug::end();
    }

    public function initSystemCommon()
    {
        // according currently environment setting to show error message whether or not
        switch (strtolower(ENVIRONMENT)) {
            case 'development':
            case 'testing':
                error_reporting(-1);
                break;
            default:
                error_reporting(0);
        }
    }

    public function registerNamespace()
    {

        require SYSTEM_PATH . 'Core/Loader.php';
        $loader = new Loader();
        $loader->registerNamespace(array(
            'System\\Core' => SYSTEM_PATH . 'Core',
        ));
        $loader->register();
        $di = DI::factory();
        $di->set('loader', $loader);
        $di->set('app', $this);
    }

    public function registerService()
    {
        $di = DI::factory();
        $di->set('config', new Config());
        $di->set('translate', new Translate());
        $di->set('request', new Request());
        $di->set('response', new Response());
        $di->set('event', new Event());
        $di->set('route', new route());
    }

    public static function exception($message, $type = null)
    {
        trigger_error($message);
    }

    public static function exceptionHandler()
    {

    }

    public static function errorHandler()
    {
    }


    public function __call($class, $args)
    {
        // echo $class;
        // var_dump($args);
    }

    public static function __callstatic($class, $args)
    {
        // echo $class;
        // var_dump($args);
    }
}