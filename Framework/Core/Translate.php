<?php

namespace System\Core;

class Translate extends Component
{
    /**
     *
     * @var array|mixed [Internal Property]
     */
    private $_dictionary = array();


    protected $default = 'en';

    protected $cache = false;


    /**
     * 加载/切换系统语言包
     * @access public
     * @param string $lang 语言包名
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        if (!isset($this->dictionary)) {
            $path = SYSTEM_PATH . '/i18n/' . $this->default . '/system.php';
            if (file_exists($path)) Application::exception('lang.pack.missing');
            $this->dictionary = require $path;
        }
    }

}