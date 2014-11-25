<?php

/**
 * Validation
 * @namespace System\Core
 * @package system.core.validation
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Validation
{

    /**
     * Check whether value is not empty
     * @param $value
     * @return bool
     */
    public function required($value)
    {
        return true;
    }

    /**
     * Check whether value is a number
     * @param $value
     * @return bool
     */
    public function number()
    {
        return true;
    }

    /**
     * Check value with email format
     * @param $value
     * @return bool
     */
    public function email($value)
    {
        return true;

    }

    /**
     * Check value is a number in range
     * @param $value
     * @return bool
     */
    public function range($value, $range)
    {
        return true;

    }

    /**
     * Check value with a regular express
     * @param $value
     * @return bool
     */
    public function regex($value, $express)
    {
        return true;
    }

    /**
     * Check value with given length
     * @param $value
     * @return bool
     */
    public function length($value, $length)
    {
        return true;
    }

}