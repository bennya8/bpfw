<?php

namespace System\i18n;

use \System\Core\Application,
    \System\Core\Component;

class Translate extends Component
{
    protected $language = 'en';



    /**
     * 加载/切换系统语言包
     * @access public
     * @param string $lang 语言包名
     * @return void
     */
    public static function init($lang = 'en')
    {
        if (!isset(self::$_language['system'])) {
            self::$_language['system'] = require SYSTEM_PATH . '/i18n/' . $lang . '/system.php';
            if (empty(self::$_language['system'])) Application::exception('语言包丢失');
        }

        var_dump(self::$_language);
    }

    public static function get()
    {
    }

    public static function set()
    {
    }
}