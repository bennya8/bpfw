<?php

namespace System\Event;

class FrameworkStart extends Event
{
    /**
     * App start event
     * @param $args
     * @return mixed
     */
    public function run($args)
    {
        ob_start();
        if (!session_id()) session_start();
    }
}