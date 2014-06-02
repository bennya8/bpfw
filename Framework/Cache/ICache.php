<?php

namespace System\Cache;


interface ICache
{

    public function get();

    public function set();

    public function flush();

    public function has();

    public function open();

    public function close();
}