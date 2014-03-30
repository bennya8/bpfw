<?php
require SYS_PATH . DS . 'Core/View/TemplateLite/class.template.php';

/**
 * Template Lite引擎实现类
 * @package Root.Framework.Core.View
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class TpliteEngine extends Template_Lite
{
	/**
	 * Tplite配置
	 * @access private
	 * @var array
	 */
	private $_tpliteConfig = array();

	/**
	 * 构造方法，初始化配置
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_smartyConfig = Config::Conf('VIEW_tpliteConfig');
		$this->_tpliteConfig['TMPLITE_LEFT_DELIMITER'];
		$this->_tpliteConfig['TMPLITE_RIGHT_DELIMITER'];
		$this->_tpliteConfig['TMPLITE_TEMPLATE_DIR'];
		$this->_tpliteConfig['TMPLITE_COMPILE_DIR'];
		$this->_tpliteConfig['TMPLITE_FORCE_COMPILE'];
		$this->_tpliteConfig['TMPLITE_COMPILE_CHECK'];
		$this->_tpliteConfig['TMPLITE_CACHE'];
		$this->_tpliteConfig['TMPLITE_CACHE_DIR'];
		$this->_tpliteConfig['TMPLITE_CACHE_TIME'];
	}
}

?>