<?php

/**
 * Profiler
 * @namespace System\Core
 * @package system.core.profiler
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Profiler
{

    private static $_timeStart = '';
    private static $_timeEnd = '';

    private static $_trace = array();

    public static function start()
    {
        self::$_timeStart = microtime(true);
    }

    public static function end()
    {
        self::$_timeEnd = microtime(true);
        self::printTrace();
    }


    public static function trace($message)
    {
        if (is_string($message)) {
            self::$_trace[] = round((microtime(true) - self::$_timeStart), 5) . ' Memory Used:' . memory_get_peak_usage(true) . ' ' . $message;
        }
    }

    public static function printTrace()
    {

        $html = '<table width="99%" style="position:absolute;bottom:0;">';
        $html .= '<tr><td>Script time: ' . round((self::$_timeEnd - self::$_timeStart), 4) .
            '&nbsp;&nbsp;Memory peak: ' . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB</td></tr>';
        for ($i = count(self::$_trace) - 1; $i >= 0; $i--) {
            $html .= '<tr><td style="background:#eee;">' . self::$_trace[$i] . '</td></tr>';
        }
        $html .= '</table>';
        echo $html;
    }
}
