<?php
require SYS_PATH . '/Core/Base.class.php';

/**
 * 系统核心类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Application extends Base
{
	
	/**
	 * 系统版本号
	 * @access public
	 * @var string
	 */
	public static $version = 'Build 1.0.0.1 DP';

	/**
	 * 系统入口
	 * @access public
	 * @return void
	 */
	public function run()
	{
		$this->init();
	}

	/**
	 * 系统初始化
	 * @access private
	 * @return void
	 */
	private function init()
	{
		defined('DEBUG') ? error_reporting(-1) : error_reporting(0);
		if (!defined('WEBROOT')) {
			$webroot = dirname($_SERVER['SCRIPT_NAME']);
			define('WEBROOT', $webroot == '/' || $webroot == '//' ? '' : $webroot);
		}
		$appCommonFunc = APP_PATH . '/Common/Common.php';
		$sysemCommonFunc = SYS_PATH . '/Common/Common.php';
		if (is_file($appCommonFunc)) require $appCommonFunc;
		if (is_file($sysemCommonFunc)) require $sysemCommonFunc;
		spl_autoload_register(array(
			'Base',
			'ClassesLoader'
		));
		set_error_handler(array(
			'CustomException',
			'ErrorHandler'
		));
		set_exception_handler(array(
			'CustomException',
			'ExceptionHandler'
		));
		Translate::Init();
		$this->checkPhpVersion();
		$this->makeSample();
		Config::Init();
		date_default_timezone_set(Config::Get('SYS_TIMEZONE'));
		if (get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
		self::Create('Router')->parseUrl();
		self::Create('Router')->route(CONTROLLER, ACTION);
	}

	/**
	 * 生成应用文件和目录
	 * @access private
	 * @throws BException 样本文件丢失
	 * @return void
	 */
	public function makeSample()
	{
		if (!is_dir(APP_PATH)) {
			$path = require SYS_PATH . '/Template/sample/sample_path.php';
			$file = require SYS_PATH . '/Template/sample/sample_file.php';
			foreach ($path as $v) {
				FileSystem::MakeDir($v);
			}
			foreach ($file as $k => $v) {
				FileSystem::CopyFile($k, $v);
			}
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
		Translate::init($name);
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
			self::TriggerError(Translate::Get('_PHP5_ABOVE_REQUIRED_'), 'error');
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
	 * 触发用户自定义错误
	 * @access public
	 * @param string $message 错误信息
	 * @param string $errorType 错误级别
	 * @return void
	 */
	public static function TriggerError($message, $type = 'notice')
	{
		$levels = array(
			'notice' => E_USER_NOTICE,
			'warning' => E_USER_WARNING,
			'error' => E_USER_ERROR
		);
		trigger_error($message, $levels[$type]);
	}
}