<?php

/**
 * Uri
 * @namespace System\Core
 * @package system.core.uri
 * @author Benny <benny_a8@live.com>
 * @copyright 2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Uri
{

    /**
     * Get base url
     * @return string
     */
    public static function baseUrl()
    {
        $protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) == 'https://' ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    }

    /**
     * Get a formatted site url
     * @param string $url
     * @param string $params
     * @return array | string
     */
    public static function siteUrl($url = '', $params = '')
    {
        $mode = DI::factory()->get('config')->get('component');
        $mode = $mode['route'];
        $baseUrl = self::baseUrl();
        if (is_array($params)) {
            $params = http_build_query($params);
        }
        if ($mode['mode'] == 'pathinfo') {
            $url = explode('/', $url);
            $params = empty($params) ? '' : '?' . $params;
            switch (count($url)) {
                case 1:
                    $url[0] = empty($url[0]) ? ACTION : $url[0];
                    $url = $baseUrl . MODULE . '/' . CONTROLLER . '/' . $url[0] . $params;
                    break;
                case 2:
                    $url = $baseUrl . MODULE . '/' . $url[1] . '/' . $url[0] . $params;
                    break;
                case 3:
                    $url = $baseUrl . $url[2] . '/' . $url[1] . '/' . $url[0] . $params;
                    break;
            }
        } elseif ($mode['mode'] == 'queryinfo') {
            $url = explode('/', $url);
            $params = empty($params) ? '' : '&' . $params;
            switch (count($url)) {
                case 1:
                    $url[0] = empty($url[0]) ? ACTION : $url[0];
                    $url = $baseUrl . '?m=' . MODULE . '&c=' . CONTROLLER . '&a=' . $url[0] . $params;
                    break;
                case 2:
                    $url = $baseUrl . '?m=' . MODULE . '&c=' . $url[1] . '&a=' . $url[0] . $params;
                    break;
                case 3:
                    $url = $baseUrl . '?m=' . $url[2] . '&c=' . $url[1] . '&a=' . $url[0] . $params;
                    break;
            }
        } else {
            $url = $baseUrl . $url;
        }
        return $url;
    }

}