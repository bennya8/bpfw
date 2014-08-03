<?php

/**
 * Translate
 * @namespace System\Core
 * @package system.cache.translate
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
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
        $sysDict = SYSTEM_PATH . '/i18n/' . $this->default . '/system.php';
        if (is_file($sysDict)) {
            $this->_dictionary = array_merge(require $sysDict, $this->_dictionary);
        }
        $appPath = scandir(APP_PATH . 'i18n/' . $this->default);
        foreach ($appPath as $file) {
            if ($file != '.' && $file != '..') {
                $appDict = APP_PATH . 'i18n/' . $this->default . '/' . $file;
                if (is_file($appDict)) {
                    $this->_dictionary = array_merge(require $appDict, $this->_dictionary);
                }
            }
        }
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