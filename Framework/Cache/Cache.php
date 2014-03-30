<?php

namespace Wiicode\Cache;

use Wiicode\Core\Application,
    Wiicode\Core\Component;

abstract class Cache extends Component implements ICache
{
    private $_cache = null;

    protected static function factory($class = __CLASS__)
    {
        return Application::create($class);
    }

    abstract public function has()
    {
    }

    abstract public function open()
    {
    }

    abstract public function close()
    {
    }

    abstract public function flush()
    {
    }

    abstract public function get()
    {
    }

    abstract public function set()
    {
    }
}