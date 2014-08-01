<?php

namespace System\Event;

use System\Core\Profiler;

class FrameworkClose extends Event
{
    /**
     * App end event
     * @param $args
     * @return mixed
     */
    public function run($args)
    {
        session_write_close();
    }
}