<?php

/**
 * Loader
 * @namespace System\Core
 * @package system.core.loader
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

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
     * Register application autoload function
     * @retun void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'autoLoad'));
    }

    /**
     * Unregister application autoload function
     * @retun void
     */
    public function unRegister()
    {
        spl_autoload_unregister(array($this, 'autoLoad'));
    }

    /**
     * Classes autoload handler
     * @param string $class
     * @throws \Exception
     * @return void
     */
    protected function autoLoad($class)
    {
        if ($path = $this->getClass($class)) {
            require $path;
        } else if (strpos($class, '\\') !== false && $this->registerClass($class)) {
            require $this->getClass($class);
        }
    }

    /**
     * Fetching an class instance or an entire maps
     * @param $class
     * @return object
     */
    public function getClass($class)
    {
        if (!empty($class)) {
            return isset(self::$_classes[$class]) ? self::$_classes[$class] : null;
        } else {
            return self::$_classes;
        }
    }

    /**
     * Initialize a class instance and put it into class maps
     * @param $class
     * @param string $suffix
     * @return bool|string
     */
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

    /**
     * Fetching a register namespace or an entire maps
     * @param string $namespace
     * @return string / array
     */
    public function getNamespace($namespace = '')
    {
        if (!empty($namespace)) {
            return array_key_exists($namespace, self::$_namespaces) ? self::$_namespaces[$namespace] : null;
        } else {
            return self::$_namespaces;
        }
    }

    /**
     * Register namespaces for use autoload mechanism
     * @param array $namespace
     * @return void
     */
    public function registerNamespace($namespace)
    {
        if (!empty($namespace) && is_array($namespace)) {
            self::$_namespaces = array_merge(self::$_namespaces, $namespace);
        }
    }

    /**
     * Import a file, same effect as include a file directly
     * @param string $classAlias
     * @param string $suffix
     * @return void
     */
    public function import($classAlias, $suffix = '.php')
    {
        if (substr($classAlias, 0, 1) === '@') {
            $classAlias = SYSTEM_PATH . substr($classAlias, 1) . $suffix;
        } else {
            $classAlias = APP_PATH . $classAlias . $suffix;
        }
        if (is_file($classAlias)) {
            include $classAlias;
        }
    }

}