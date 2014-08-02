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
        if (ENVIRONMENT === 'development') {
            self::printTrace();
        }
    }

    public static function trace($message, $type = 'Trace')
    {
        if (is_string($message)) {
            self::$_trace[] = round((microtime(true) - self::$_timeStart), 5) . ' Mem: ' . memory_get_peak_usage(true) . ' ' . $type . ': ' . $message;
        }
    }

    public static function printTrace()
    {
        $html = '<table style="position:fixed;bottom:0;left: 0;width: 100%;z-index: 9999;border-spacing: 1px;">';
        $html .= '<tr><td style="background:#ddd;">Script time: ' . round((self::$_timeEnd - self::$_timeStart), 4) .
            '&nbsp;&nbsp;Memory peak: ' . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB</td></tr>';
        for ($i = count(self::$_trace) - 1; $i >= 0; $i--) {
            $html .= '<tr><td style="background:#eee;">' . self::$_trace[$i] . '</td></tr>';
        }
        $html .= '</table>';
        echo $html;
    }
}
