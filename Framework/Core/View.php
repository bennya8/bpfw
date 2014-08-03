<?php

/**
 * View middleware
 * @namespace System\Core
 * @package system.cache.view
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class View extends Component
{

    /**
     * Template variables
     * @var array
     */
    private $_data = array();

    /**
     * Template engine
     * @var string
     */
    protected $engine = 'native';

    /**
     * Default theme
     * @var string
     */
    protected $theme = 'Default';

    /**
     * Default layout
     * @var string
     */
    protected $layout = 'layout';

    /**
     * Template file extension
     * @var string
     */
    protected $templateExt = '.php';

    /**
     * Template left delimiter tag
     * @var string
     */
    protected $leftDelimiter = '<{';

    /**
     * Template right delimiter tag
     * @var string
     */
    protected $rightDelimiter = '}>';

    /**
     * Force compile template
     * @var bool
     */
    protected $forceCompile = true;

    /**
     * Compile template dir
     * @var string
     */
    protected $templateDir = 'Runtime/Template/Compile';

    /**
     * Enable html cache
     * @var bool
     */
    protected $enableCache = true;

    /**
     * Html cache dir
     * @var string
     */
    protected $cacheDir = 'Runtime/Template/Html';

    /**
     * Html cache expire
     * @var int
     */
    protected $cacheExpire = 3600;

    public function __construct()
    {
        parent::__construct('view');
    }

    /**
     * Get template data
     * @access public
     * @param string $key
     * @return mixed
     */
    public function getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : false;
    }

    /**
     * Set template data
     * @access public
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setData($key, $value = '')
    {
        $this->_data[$key] = $value;
    }

    /**
     * Render a view
     * @access public
     * @param string $template
     * @param string $cache_id [optional]
     * @return void
     */
    public function render($template, $cache_id = null)
    {
        $this->getDI('event')->notify('view_start');
        $layout = $this->getTemplatePath('Layouts/layout', $this->theme);
        echo str_replace($layout, '__CONTENT__', $this->fetch($template, $this->theme, $cache_id));
        $this->getDI('event')->notify('view_end');
    }

    /**
     * Render a partial view without using layout
     * @param string $template
     * @param string $cache_id [optional]
     * @return void
     */
    public function partial($template, $cache_id = null)
    {
        $this->getDI('event')->notify('view_start');
        echo $this->fetch($template, $this->theme, $cache_id);
        $this->getDI('event')->notify('view_end');
    }

    /**
     * Get template file full path
     * @access protected
     * @param string $template
     * @param string $theme
     * @throws \Exception
     * @return string
     */
    protected function getTemplatePath($template, $theme)
    {
        $template = explode('/', $template);
        switch (count($template)) {
            case 1:
                $tpl = APP_PATH . '/' . ucfirst(MODULE) . '/View/' . $theme . '/' . ucfirst(CONTROLLER) . '/' .
                    $template[0] . $this->templateExt;
                break;
            case 2:
                $tpl = APP_PATH . '/' . ucfirst(MODULE) . '/View/' . $theme . '/' . ucfirst($template[0]) . '/' .
                    $template[1] . $this->templateExt;
                break;
            case 3:
                $tpl = APP_PATH . '/' . ucfirst($template[0]) . '/View/' . $theme . '/' . ucfirst($template[1]) . '/' .
                    $template[2] . $this->templateExt;
                break;
            default:
                $tpl = APP_PATH . '/' . ucfirst(MODULE) . '/View/' . $theme . '/' . ucfirst(CONTROLLER) . '/' .
                    $template[0] . $this->templateExt;
        }
        if (!is_file($tpl)) {
            throw new \Exception('template not exist', E_ERROR);
        }
        return $tpl;
    }

    /**
     * Get complied content from template engine
     * @access protected
     * @param string $template
     * @param string $theme
     * @param string $cache_id [optional]
     * @return string
     */
    protected function fetch($template, $theme, $cache_id = null)
    {
        $file = $this->getTemplatePath($template, $theme);
        if ($this->engine == 'tplite') {
            return $this->_fetchTpliteTemplate($file, $this->_data, $cache_id);
        } else if ($this->engine == 'smarty') {
            return $this->_fetchSmartyTemplate($file, $this->_data, $cache_id);
        } else {
            ob_start();
            extract($this->_data);
            require $file;
            return ob_get_clean();
        }
    }

    /**
     * Fetch complied template from smarty3 engine
     * @access private
     * @param string $template
     * @param mixed $data
     * @param string $cache_id
     * @return string
     */
    private function _fetchSmartyTemplate($template, $data, $cache_id = null)
    {
        $this->getDI('loader')->import('@Vendor/Smarty/Smarty', '.class.php');
        $smarty = new \Smarty();
        $smarty->left_delimiter = $this->leftDelimiter;
        $smarty->right_delimiter = $this->rightDelimiter;
        $smarty->setCompileDir(APP_PATH . $this->templateDir);
        $smarty->setCacheDir(APP_PATH . $this->cacheDir);
        $smarty->caching = $this->enableCache;
        $smarty->cache_lifetime = $this->cacheExpire;
        $smarty->force_compile = $this->forceCompile;
        $smarty->muteExpectedErrors();
        $smarty->assign($data);
        return $smarty->fetch($template, $cache_id);
    }

    /**
     * Fetch complied template from tplite engine
     * @access private
     * @param string $template
     * @param mixed $data
     * @param string $cache_id
     * @return string
     */
    private function _fetchTpliteTemplate($template, $data, $cache_id = null)
    {
        $this->getDI('loader')->import('@Vendor/TemplateLite/class.template');
        $tplite = new \Template_Lite();
        $tplite->left_delimiter = $this->leftDelimiter;
        $tplite->right_delimiter = $this->rightDelimiter;
        $tplite->compile_dir = APP_PATH . $this->templateDir;
        $tplite->cache_dir = APP_PATH . $this->templateDir;
        $tplite->cache = $this->enableCache;
        $tplite->cache_lifetime = $this->cacheExpire;
        $tplite->force_compile = $this->forceCompile;
        $tplite->assign($data);
        return $tplite->fetch($template, $cache_id);
    }

}