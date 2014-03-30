<?php

/**
 * Interface IBehavior
 */

namespace Wiicode\Behavior;

interface IBehavior
{

    public function attach();

    public function detach();

    public function notify();
}

interface BehaviorObserver
{
}