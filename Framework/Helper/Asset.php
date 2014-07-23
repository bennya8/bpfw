<?php

namespace System\Helper;

class Asset
{
    protected $baseUrl = '/';
    protected $basePath = 'Public/Assets';

    private $_scriptType = array(
        'js' => 'text/javascript',
        'html' => 'text/html',
        'tpl' => 'text/template'
    );

    protected $cdn = '';

    public function getScript($name, $type = '', $version = '')
    {
        if (!empty($version)) $version = '?v=' . $version;
        $type = in_array($type, $this->_scriptType) ? $this->_scriptType[$type] : 'text/javascript';
        $src = $this->baseUrl . $this->basePath . $name . $version;
        echo '<script type="' . $type . '" src="' . $src . '"></script>';
    }

    public function getStyle($name, $version = '')
    {
        if (!empty($version)) $version = '?v=' . $version;
        $src = $this->baseUrl . $this->basePath . $name . $version;
        echo '<link type="text/css" rel="stylesheet" src="' . $src . '" />';
    }

    public function getImage($name, $attributes = array())
    {
        $attr = '';
        if (!empty($attributes) && is_array($attributes)) {
            foreach ($attributes as $attribute) {
                list($k, $v) = explode('', $attribute);
                $attr .= $k . '="' . $v . '" ';
            }
        }
        $src = $this->baseUrl . $this->basePath . $name;
        echo '<img src="' . $src . '" ' . $attr . ' />';
    }

    public function getImageUrl($name)
    {
        echo $this->baseUrl . $this->basePath . $name;
    }

}