<?php

/**
 * Event
 * @namespace System\Event
 * @package system.event.event
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Event;

abstract class Event
{

    /**
     * Event entrance
     * @param mixed $args
     * @return void
     */
    abstract public function run($args);

}