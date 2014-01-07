<?php
require SYS_PATH . '/Core/View/Smarty/Smarty.class.php';

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
	 * 构造方法，初始化配置
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->muteExpectedErrors();
		$config = Config::Get('Smarty');
		$this->left_delimiter = $config['SMARTY_LEFT_DELIMITER'];
		$this->right_delimiter = $config['SMARTY_RIGHT_DELIMITER'];
		$this->force_compile = $config['SMARTY_FORCE_COMPILE'];
		$this->compile_check = $config['SMARTY_COMPILE_CHECK'];
		$this->caching = $config['SMARTY_CACHING'];
		$this->cache_lifetime = $config['SMARTY_CACHE_TIME'];
		$this->setCompileDir($config['SMARTY_COMPILE_DIR']);
		$this->setTemplateDir($config['SMARTY_TEMPLATE_DIR']);
		$this->setCacheDir($config['SMARTY_CACHE_DIR']);
	}
}

?>