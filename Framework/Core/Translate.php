<?php

/**
 * Translate
 * @namespace System\Core
 * @package system.cache.translate
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Translate extends Component
{
    /**
     * Language dictionary
     * @var array
     */
    private $_dictionary = array();

    /**
     * Default language pack
     * @var string
     */
    protected $default = 'en';

    /**
     * Constructor
     * Load language pack
     */
    public function __construct()
    {
        parent::__construct('translate');
        $path = SYSTEM_PATH . '/i18n/' . $this->default . '/system.php';
        if (!is_file($path)) {
            throw new \Exception('lang pack not found', E_WARNING);
        }
        $this->_dictionary = require $path;
    }

    /**
     * Get exists dict value with given key
     * @param $key
     * @return string
     */
    public function __get($key)
    {
        return isset($this->_dictionary[$key]) ? $this->_dictionary[$key] : $key;
    }

    /**
     * Set dict with given key and value
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->_dictionary[$key] = $value;
    }
}