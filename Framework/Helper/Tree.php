<?php

/**
 * Assets helper
 * @namespace System\Helper
 * @package system.helper.tree
 * @reference phpcms_v9
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Tree
{

    /**
     * Format icons
     * @var array
     */
    public $icon = array('│', '├', '└');

    /**
     * @var string
     */
    public $nbsp = "&nbsp;";

    protected $data;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function hasChild($id)
    {
        return (bool)$this->getChild($id);
    }

    public function getChild($id)
    {
        $list = array();
        foreach ($this->data as $v) {
            if ($v['pid'] == $id) {
                $list[] = $v;
            }
        }
        return $list;
    }

    public function getParent($id){

    }

    public function getTree($id, $space = '')
    {
        $list = array();
        $childs = $this->getChild($id);
        if (!($n = count($childs))) {
            return array();
        }
        $m = 1;
        for ($i = 0; $i < $n; $i++) {
            $pre = $pad = "";
            if ($n == $m) {
                $pre = $this->icon[2];
            } else {
                $pre = $this->icon[1];
                $pad = $space ? $this->icon[0] : '';
            }
            $childs[$i]['format'] = ($space ? $space . $pre : '') . $childs[$i]['name'];
            $list[] = $childs[$i];
            $list = array_merge($list, $this->getTree($childs[$i]['id'], $space . $pad . '&nbsp;&nbsp;'));
            $m++;
        }
        return $list;
    }

}