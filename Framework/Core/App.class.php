<?php
require SYS_PATH . DS . 'Core/Base.class.php';

/**
 * 系统核心类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version Release: @package_version@
 */
class App extends Base
{
	
	/**
	 * 系统版本号
	 * @access public
	 * @var string
	 */
	public $version = 'Build 1.0.0 r407';

	/**
	 * 系统入口
	 * @access public
	 * @return void
	 */
	public function run()
	{
		try {
			$this->init();
		} catch (BException $e) {
			if (SYS_DEBUG) {
				$e->printMsg();
			} else {
				$e->saveMsg();
			}
		}
	}

	/**
	 * 系统初始化
	 * @access private
	 * @return void
	 */
	private function init()
	{
		$appCommonFunc = APP_PATH . DS . 'Common/Common.php';
		$sysemCommonFunc = SYS_PATH . DS . 'Common/Common.php';
		if (is_file($appCommonFunc)) require $appCommonFunc;
		if (is_file($sysemCommonFunc)) require $sysemCommonFunc;
		spl_autoload_register(array(
			'Base',
			'classesLoader'
		));
		set_error_handler(array(
			'App',
			'ErrorHandler'
		));
		Config::Create('Config')->loadLanguage();
		$this->checkPhpVersion();
		$this->checkAppPath();
		Config::Create('Config')->loadConfig();
		$sysConfig = Config::Conf('SYS_CONFIG');
		Config::Create('Config')->loadLanguage($sysConfig['SYS_LANG']);
		date_default_timezone_set($sysConfig['SYS_TIMEZONE']);
		if (get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
		defined('SYS_ENV') || define('SYS_ENV', strtoupper($sysConfig['SYS_ENV']));
		switch (SYS_ENV) {
			case 'DEVELOPMENT':
				error_reporting(-1);
				defined('SYS_DEBUG') || define('SYS_DEBUG', true);
				break;
			default: // PRODUCTION
				error_reporting(0);
				defined('SYS_DEBUG') || define('SYS_DEBUG', false);
		}
		if (!defined('WEBROOT')) {
			$webroot = dirname($_SERVER['SCRIPT_NAME']);
			define('WEBROOT', ($webroot == '/' || $webroot == '\\') ? '' : $webroot);
		}
		if (!session_id()) session_start();
		Router::Create('Router')->parseUrl();
		defined('CONTROLLER') || define('CONTROLLER', $GLOBALS['CONTROLLER']);
		defined('ACTION') || define('ACTION', $GLOBALS['ACTION']);
		Router::Create('Router')->route(CONTROLLER, ACTION);
	}

	/**
	 * 生成应用文件和目录
	 * @access private
	 * @throws BException 样本文件丢失
	 * @return void
	 */
	public function checkAppPath()
	{
		$path = require SYS_PATH . DS . 'Template/systpl_path.php';
		$file = require SYS_PATH . DS . 'Template/systpl_file.php';
		if (!is_dir(APP_PATH)) {
			FileSystem::MakeDir($path);
			FileSystem::CopyFile($file);
		}
	}

	/**
	 * 设定系统语言
	 * @access public
	 * @param string $name 语言包名
	 * @throws BException 语言包文件不存在
	 * @return void
	 */
	public function setLanguage($name)
	{
		App::Create('Config')->setLanguage($name);
	}

	/**
	 * 检查当前PHP版本
	 * @access public
	 * @throws BException PHP版本低于5.0
	 * @return void
	 */
	public function checkPhpVersion()
	{
		if (version_compare(PHP_VERSION, '5', '<')) {
			throw new BException(Config::Lang('_PHP5_ABOVE_REQUIRED_'));
		}
	}

	/**
	 * 引入Extend文件夹内的第三方类库
	 * @access public
	 * @param string $class 类名
	 * @throws BException 要载入的第三方类不存在
	 * @return void
	 * @example 调用：App::Import('@Cls_Image');
	 *          应用Extend目录：/Root/YourApp/Extend/Cls_Image.php
	 * @example 调用：App::Import('Util/Paging.class');
	 *          系统Extend目录：/Root/Framework/Extend/Util/Paging.class.php
	 */
	public static function Import($class)
	{
		parent::Import($class);
	}

	/**
	 * 创建实例，传入基类实例集并从中返回，(单例模式)
	 * @access public
	 * @param string $class 类名
	 * @param array $args 构造参数
	 * @return object 类的实例
	 */
	public static function Create($class = __CLASS__, $args = NULL)
	{
		return parent::Create($class, $args);
	}

	/**
	 * 自定义错误句柄
	 * @access private
	 * @param int $code
	 * @param string $message
	 * @throws BException 捕获未知异常
	 * @return void
	 */
	public static function ErrorHandler($code, $message)
	{
		throw new BException(Config::Lang('_UNKNOW_ERROR_') . ' => ' . securePath($message));
	}
}

?>