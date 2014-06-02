<?php

namespace System\Core\Session;

use \System\Core\Component;

abstract class Session extends Component
{

    /**
     * session instance
     * @var object
     */
    private $_session = null;

    public function __construct()
    {
        session_set_save_handler(array(
            $this => 'open'
        ), array(
            $this => 'close'
        ), array(
            $this => 'read'
        ), array(
            $this => 'write'
        ), array(
            $this => 'destroy'
        ), array(
            $this => 'gc'
        ));
    }

    abstract public function get();

    abstract public function set();


    abstract public function open();

    abstract public function close();

    abstract public function read();


    abstract public function write();

    abstract public function destroy();

    abstract public function gc();


    /**
     * session factory method
     * @param $name
     */
    public static function factory($name)
    {
        switch (strtolower($name)) {
            case 'file':
                break;
            case 'memcached':
                break;
            case 'database':
                break;
        }
    }

}