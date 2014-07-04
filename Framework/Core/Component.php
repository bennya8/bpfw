<?php

namespace System\Core;

abstract class Component
{
    public function __construct($name = __CLASS__)
    {
        $config = $this->getDI('config')->get('component');
        if (!empty($config) && is_array($config)) {
            foreach ($config as $propKey => $propValue) {
                if (property_exists($this, $propKey)) {
                    $this->$propKey = $propValue;
                }
            }
        }
    }

    protected function getDI($name)
    {
        return DI::factory()->get($name);
    }


    protected function setDI($name, $mixed)
    {
        return DI::factory()->set($name, $mixed);
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
