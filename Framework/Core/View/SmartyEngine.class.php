<?php
require SYS_PATH . DS . 'Core/View/Smarty/Smarty.class.php';

/**
 * Smarty引擎实现类
 * @package Root.Framework.Core.View
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class SmartyEngine extends Smarty
{
	/**
	 * Smarty配置
	 * @access private
	 * @var array
	 */
	private $_smartyConfig = array();

	/**
	 * 构造方法，初始化配置
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->muteExpectedErrors();
		$this->_smartyConfig = Config::Conf('VIEW_CONFIG');
		$this->left_delimiter = $this->_smartyConfig['SMARTY_LEFT_DELIMITER'];
		$this->right_delimiter = $this->_smartyConfig['SMARTY_RIGHT_DELIMITER'];
		$this->force_compile = $this->_smartyConfig['SMARTY_FORCE_COMPILE'];
		$this->compile_check = $this->_smartyConfig['SMARTY_COMPILE_CHECK'];
		$this->caching = $this->_smartyConfig['SMARTY_CACHING'];
		$this->cache_lifetime = $this->_smartyConfig['SMARTY_CACHE_TIME'];
		$this->setCompileDir($this->_smartyConfig['SMARTY_COMPILE_DIR']);
		$this->setTemplateDir($this->_smartyConfig['SMARTY_TEMPLATE_DIR']);
		$this->setCacheDir($this->_smartyConfig['SMARTY_CACHE_DIR']);
	}
}

?>