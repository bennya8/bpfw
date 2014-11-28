<?php

/**
 * Profiler
 * @namespace System\Core
 * @package system.core.profiler
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Profiler
{

    /**
     * App start time
     * @access private
     * @var int
     */
    private static $_timeStart;

    /**
     * App end time
     * @access private
     * @var int
     */
    private static $_timeEnd;

    /**
     * Debug trace stack
     * @access private
     * @var array
     */
    private static $_trace = array();

    /**
     * Mark a app start time
     * @access public
     * @return void
     */
    public static function start()
    {
        self::$_timeStart = microtime(true);
    }

    /**
     * Mark a app end time
     * @access public
     * @return void
     */
    public static function end()
    {
        self::$_timeEnd = microtime(true);
    }

    /**
     * Mark a function invoke trace
     * @access public
     * @param $message
     * @param string $type
     * @return void
     */
    public static function trace($message, $type = 'Trace')
    {
        if (is_string($message)) {
            self::$_trace[] = round((microtime(true) - self::$_timeStart), 5) . ' Mem: ' . memory_get_usage(true) . ' ' . $type . ': ' . $message;
        }
    }

    /**
     * Print all backtrace
     * @access public
     * @return void
     */
    public static function printTrace()
    {
        self::end();
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $html = '<table style="position:fixed;bottom:0;left: 0;width: 100%;z-index: 9999;border-spacing: 1px;">';
        $html .= '<tr><td style="background:#ddd;">Script time: ' . round((self::$_timeEnd - self::$_timeStart), 4) .
            '&nbsp;&nbsp;Memory peak: ' . round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB</td></tr>';

        foreach ($backtrace as $trace) {
            $securePath = '';
            if (isset($trace['file']) && isset($trace['line'])) {
                $securePath .= 'File: ' . str_replace(dirname(APP_PATH), '', $trace['file']) . ' Line: ' . $trace['line'];
            }
            $html .= "<tr><td style='background:#ddd;'>Class: {$trace['class']}{$trace['type']}{$trace['function']} ##### {$securePath}</td></tr>";
        }
        $html .= '</table>';
        echo $html;
    }

}
