<?php

namespace System\Core;

use \System\Core\Application;

abstract class Component
{

    public function __construct($name = __CLASS__)
    {
        echo get_class($this);
        $config = Application::create('System\Core\Config')->get('component');
        if (!empty($config) && is_array($config)) {
            foreach ($config as $propKey => $propValue) {
                if (property_exists($this, $propKey)) {
                    $this->$propKey = $propValue;
                }
            }
        }
    }

    public function __get($name)
    {
    }

    public function __set($name, $value)
    {
    }

    public function __call($class, $args)
    {
    }

    public static function __callstatic($class, $args)
    {
    }
}
