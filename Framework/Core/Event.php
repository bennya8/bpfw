<?php

/**
 *
 */

namespace System\Core;

class Event
{
    protected $events = array(
        'app_start' => array()
    );

    public function __construct()
    {

    }

    public function attach($name, $event)
    {
        $this->events[$name] = $event;
    }

    public function detach($name)
    {
        if (isset($this->events[$name])) {
            unset($this->events[$name]);
        }
    }

    public function notify(){}
}