<?php

namespace System\Core;

use \System\Core\SystemException;

class Application
{
    /**
     * Instantiated classes container
     * @var array
     */
    private static $_instances = array();

    /**
     * Namespaces mapping
     * class namespaces => class path
     * @var array
     */
    private static $_classMaps = array(
        '#Debug' => '/Core/Debug.php',
        '#Request' => '/Core/Request.php',
        '#Response' => '/Core/Response.php',
        '#Route' => '/Core/Route.php',
        '#Component' => '/Core/Component.php',
        '#Translate' => '/i18n/Translate.php'
    );

    /**
     * Aliases mapping
     * class alias => class namespace
     * @var array
     */
    private static $_aliasMaps = array();

    public function __construct()
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
        // register lazyload method
        spl_autoload_register([
            'System\Core\Application',
            'classLoader'
        ]);
        Debug::start();
        Debug::trace(__METHOD__);



        $this->_initialize();
        echo Debug::end();
        return;
    }

    private function _initialize()
    {
        $translate = Application::create('System\i18n\Translate');
        var_dump($translate);

exit;

        $config = Application::create('System\Core\Config')->get('system');
        foreach ($config as $key => $value) {
            $this->setDI($key, $value);
        }

        $this->setDI('request', self::create('\System\Core\Request'));
        $this->setDI('response', self::create('\System\Core\Response'));
        $this->setDI('response', self::create('\System\Core\Response'));


        Debug::trace(__METHOD__);

    }

    public function _initCommon()
    {
        Debug::trace(__METHOD__);
        $constants = APP_PATH . '/common/Constatns.php';
        $functions = APP_PATH . '/common/Functions.php';
        if (is_file($constants)) require $constants;
        if (is_file($functions)) require $functions;
    }

    private function _initRoute()
    {
        Debug::trace(__METHOD__);
        Route::parseURL();
        Route::forward();
    }

    /**
     * Create a class instance and push to classes container (singleton)
     * @param string $class
     * @param string $args
     * @return object
     */
    public static function create($class = __CLASS__, $args = '')
    {
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class($args);
        }
        return self::$_instances[$class];
    }


    /**
     * Classes autoload handler
     * @access protected
     * @param string $class 类名
     */
    protected static function classLoader($class)
    {
        if (isset(self::$_classMaps[$class])) {
            require SYSTEM_PATH . self::$_classMaps[$class];
        } else if (strpos($class, '\\') !== false) {
            require self::getClassAlias(str_replace('\\', '.', $class));
        } else {
            return;
        }
    }

    protected static function getClassAlias($alias, $fileSuffix = '.php')
    {
        if (isset(self::$_aliasMaps[$alias])) {
            return self::$_aliasMaps[$alias];
        } else if (stripos($alias, '.') !== false) {
            $spit = stripos($alias, '.');
            switch (substr($alias, 0, $spit)) {
                case 'System':
                    $aliasPrefix = SYSTEM_PATH;
                    break;
                case 'Vendor':
                    $aliasPrefix = SYSTEM_PATH . '/Vendor';
                    break;
            }
            $aliasPath = SYSTEM_PATH . str_replace('.', '/', substr($alias, $spit)) . $fileSuffix;
            if (is_file($aliasPath)) {
                return self::setClassAlias($alias, $aliasPath);
            }
        }
        self::exception('找不到该别名' . ' => ' . $alias);
        return $alias;
    }

    protected static function setClassAlias($alias, $aliasPath)
    {
        return self::$_aliasMaps[$alias] = $aliasPath;
    }


    protected function getDI($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }


    protected function setDI($name, $value)
    {
        return $this->$name = $value;
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

?>