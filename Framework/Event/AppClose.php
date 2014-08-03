<?php

/**
 * App close event
 * @namespace System\Event
 * @package system.event.appclose
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Event;

class AppClose extends Event
{

    /**
     * Event entrance
     * @param mixed $args
     * @return void
     */
    public function run($args)
    {
        session_write_close();
    }

}