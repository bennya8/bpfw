<?php

/**
 * 系统自定义异常类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class CustomException extends Exception
{

	/**
	 * 输出异常页面，但不记录日志，用于开发模式
	 * @access public
	 * @return void
	 */
	public function trace()
	{
		$trace = explode("\n", $this->getTraceAsString());
		include SYS_PATH . '/Template/systpl_page_debug.php';
		exit();
	}

	/**
	 * 输出异常页面，记录日志，用于生成模式
	 * @access public
	 * @return void
	 */
	public function log()
	{
		$trace = explode("\n", $this->getTraceAsString());
		// require SYS_PATH . DS . 'Template/systpl_page_exception.html';
		// Log::Write($this->getMessage());
		exit();
	}

	public static function ErrorType($type)
	{
		$levels = array(
			E_WARNING => 'System Warning Error',
			E_NOTICE => 'System Notice Error',
			E_STRICT => 'System Strict Error',
			E_ERROR => 'System Fatal Error',
			E_USER_NOTICE => 'Application Notice Error',
			E_USER_WARNING => 'Application Warning Error',
			E_USER_ERROR => 'Application Fatal Error'
		);
		return isset($levels[$type]) ? $levels[$type] : 'Unknow Error';
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
		throw new CustomException($message, $code);
	}

	/**
	 * 自定义异常句柄
	 * @access private
	 * @param int $code
	 * @param string $message
	 * @throws BException 捕获未知异常
	 * @return void
	 */
	public static function ExceptionHandler($e)
	{
		defined('DEBUG') && (DEBUG) ? $e->trace() : $e->log();
	}
}