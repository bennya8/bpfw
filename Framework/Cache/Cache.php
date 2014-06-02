<?php

namespace System\Cache;

use System\Core\Application,
    System\Core\Component;

abstract class Cache extends Component implements ICache
{
    /**
     * Cache Instance
     * @var object
     */
    private static $_cache = null;

    protected static function factory($class = __CLASS__)
    {
        switch (strtolower($class)) {
            case 'apc':
                return Application::create('System\Cache\Driver\Apc');
                break;
            case 'Memcache':
                return Application::create('System\Cache\Driver\Memcache');
                break;
            default:
                return Application::create('System\Cache\Driver\File');
        }
    }

    abstract public function has();

    abstract public function open();

    abstract public function close();

    abstract public function flush();

    abstract public function get();

    abstract public function set();
}