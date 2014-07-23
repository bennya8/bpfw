<?php

/**
 * View
 * @namespace System\Core
 * @package system.cache.translate
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class View extends Component
{

    private $_data = array();

    protected $uselayout = false;

    protected $layout = 'layout';

    protected $tplExt = '.php';

    public function display($template)
    {
        $this->getDI('event')->notify('view_start');
        echo $this->fetch($template);
        $this->getDI('event')->notify('view_end');
    }

    public function fetch($template)
    {
        $tpl = APP_PATH . 'Module/' . ucfirst(MODULE) . '/View/' . ucfirst(CONTROLLER) . '/' . $template . $this->tplExt;
        if (!is_file($tpl)) {
            trigger_error('template not exist', E_USER_NOTICE);
        }
        ob_start();
        extract($this->_data);
        require $tpl;
        return ob_get_clean();
    }

    public function assign($name, $value = '')
    {
        $this->_data[$name] = $value;
    }

}