<?php

namespace System\Core;

class Loader
{
    /**
     * Namespace mapping
     * @var array
     */
    private static $_namespaces = array();

    /**
     * Classes mapping
     * class namespaces => class path
     * @var array
     */
    private static $_classes = array();

    /**
     * self instance
     */
    private static $_instance = null;


    public static function factory()
    {

    }

    public function register()
    {
        spl_autoload_register(array($this, 'autoLoad'));
    }

    public function unRegister()
    {
        spl_autoload_unregister(array($this, 'autoLoad'));
    }

    /**
     * Classes autoload handler
     * @access protected
     * @param string $class 类名
     */
    protected function autoLoad($class)
    {
        if ($path = $this->getClass($class)) {
            require $path;
        } else if (strpos($class, '\\') !== false && $this->registerClass($class)) {
            require $this->getClass($class);
        }
    }

    public function getClass($class)
    {
        if (!empty($class)) {
            return isset(self::$_classes[$class]) ? self::$_classes[$class] : null;
        } else {
            return self::$_classes;
        }
    }

    public function registerClass($class, $suffix = '.php')
    {
        if (is_string($class)) {
            $spit = strrpos($class, '\\');
            $namespace = substr($class, 0, $spit);
            $name = substr($class, $spit + 1);
            if ($path = $this->getNamespace($namespace)) {
                $file = $path . '/' . $name . $suffix;
                if (file_exists($file)) {
                    return self::$_classes[$class] = $file;
                }
            }
        }
        return false;
    }

    public function getNamespace($namespace = '')
    {
        if (!empty($namespace)) {
            return array_key_exists($namespace, self::$_namespaces) ? self::$_namespaces[$namespace] : null;
        } else {
            return self::$_namespaces;
        }
    }

    public function registerNamespace($namespace)
    {
        self::$_namespaces = array_merge(self::$_namespaces, $namespace);
    }

}