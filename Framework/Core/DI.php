<?php

namespace System\Core;

class DI
{
    protected static $_shared = array();

    protected static $_handle = null;

    public static function factory()
    {
        if (!isset(self::$_handle) && !self::$_handle instanceof self) {
            self::$_handle = new self;
        }
        return self::$_handle;
    }

    public function get($name)
    {
        return isset(self::$_shared[$name]) ? self::$_shared[$name] : false;
    }

    public function set($name, $mixed)
    {
        if (!isset(self::$_shared[$name])) {
            self::$_shared[$name] = $mixed;
        }
        return self::$_shared[$name];
    }

    public function has($name)
    {
        return isset(self::$_shared[$name]);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $object)
    {
        return $this->set($name, $object);
    }


}