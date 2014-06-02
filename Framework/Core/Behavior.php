<?php


/**
 *
 */

namespace Wiicode\Behavior;

abstract class Behavior
{

    public function attach();

    public function detach();

    public function notify();
}