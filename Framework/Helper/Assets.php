<?php

/**
 * Assets helper
 * @namespace System\Core;
 * @package system.helper.assets
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Assets
{

    /**
     * Website base url
     * @access public
     * @var string
     */
    public $baseUrl = '';

    /**
     * Asset path
     * @access public
     * @var string
     */
    public $basePath = 'assets';

    /**
     * Script tags
     * @access private
     * @var array
     */
    private $_scriptType = array(
        'js' => 'text/javascript',
        'html' => 'text/html',
        'tpl' => 'text/template'
    );

    /**
     * Print js script tag
     * @access public
     * @param string $name
     * @param string $type
     * @param string $version
     * @return string
     */
    public function js($name, $type = '', $version = '')
    {
        if (!empty($version)) $version = '?v=' . $version;
        $type = in_array($type, $this->_scriptType) ? $this->_scriptType[$type] : 'text/javascript';
        $src = $this->baseUrl() . $this->basePath . '/' . $name . $version;
        return '<script type="' . $type . '" src="' . $src . '"></script>';
    }

    /**
     * Print css style tag
     * @access public
     * @param string $name
     * @param string $version
     * @return string
     */
    public function css($name, $version = '')
    {
        if (!empty($version)) $version = '?v=' . $version;
        $src = $this->baseUrl() . $this->basePath . '/' . $name . $version;
        return '<link type="text/css" rel="stylesheet" href="' . $src . '" />';
    }

    /**
     * Print img tag
     * @access public
     * @param string $name
     * @param array $attributes
     * @return string
     */
    public function img($name, $attributes = array())
    {
        $attr = '';
        if (!empty($attributes) && is_array($attributes)) {
            foreach ($attributes as $attribute) {
                list($k, $v) = explode('', $attribute);
                $attr .= $k . '="' . $v . '" ';
            }
        }
        $src = $this->baseUrl() . $this->basePath . '/' . $name;
        return '<img src="' . $src . '" ' . $attr . ' />';
    }

    /**
     * Print img url
     * @access public
     * @param string $name
     * @return string
     */
    public function imgUrl($name)
    {
        return $this->baseUrl() . $this->basePath . '/' . $name;
    }

    /**
     * Generate base url
     * @return string
     */
    public function baseUrl()
    {
        if (!empty($this->baseUrl)) {
            return $this->baseUrl;
        } else {
            $protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) == 'https://' ? 'https://' : 'http://';
            return $this->baseUrl = $protocol . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        }
    }

    /**
     * Generate site url
     * @param string $url
     * @param string $params
     * @return array|string
     */
    public function siteUrl($url = '', $params = '')
    {
        return \System\Core\Uri::siteUrl($url, $params);
    }

}