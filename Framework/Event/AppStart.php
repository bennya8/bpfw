<?php

/**
 * App start event
 * @namespace System\Event
 * @package system.event.appstart
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Event;

class AppStart extends Event
{

    /**
     * Event entrance
     * @param $args
     * @return mixed
     */
    public function run($args)
    {
        ob_start();
        if (!session_id()) session_start();
    }
}