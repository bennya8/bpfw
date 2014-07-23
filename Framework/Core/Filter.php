<?php

/**
 * Filter
 * @namespace System\Core;
 * @package system.core.filter
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Filter
{

    /**
     * filter string value
     * @param $value
     * @return bool
     */
    public function string($value)
    {
        return strval($value);
    }

    /**
     * filter number value, int and float
     * @param $value
     * @return bool
     */
    public function number($value)
    {
        return preg_replace('/\D^./s', '', $value) + 0;
    }

    /**
     * filter boolean value
     * @param $value
     * @return bool
     */
    public function boolean($value)
    {
        return (boolean)$value;
    }

    /**
     * Recursive strips xss code
     * @param mixed $value
     * @return mixed
     */
    public function xss($value)
    {
        if (is_string($value)) {
            $value = trim($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $value = str_replace(array('"', "\\", "'", "/", "..", "../", "./", "//"), '', $value);
            $no = '/%0[0-8bcef]/';
            $value = preg_replace($no, '', $value);
            $no = '/%1[0-9a-f]/';
            $value = preg_replace($no, '', $value);
            $no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
            $value = preg_replace($no, '', $value);
            return $value;
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->xss($v);
            }
        }
        return $value;
    }

    /**
     * Recursive escape a given value
     * @param mixed $value
     * @return mixed
     */
    public function escape($value)
    {
        if (is_string($value)) return addslashes($value);
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->escape($v);
            }
        }
        return $value;
    }

    /**
     * Recursive unescape a given value
     * @param mixed $value
     * @return mixed
     */
    public function unescape($value)
    {
        if (is_string($value)) return stripslashes($value);
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->unescape($v);
            }
        }
        return $value;
    }

    /**
     * Recursive htmlescape a given value
     * @param mixed $value
     * @return mixed
     */
    public function htmlescape($value)
    {
        if (is_string($value)) return htmlentities($value);
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->htmlescape($v);
            }
        }
        return $value;
    }

    /**
     * Recursive htmlunescape a given value
     * @param mixed $value
     * @return mixed
     */
    public function htmlunescape($value)
    {
        if (is_string($value)) return html_entity_decode($value);
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->htmlunescape($v);
            }
        }
        return $value;
    }

}