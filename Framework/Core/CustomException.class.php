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
	public function trace() {
		$trace = explode("\n", $this->getTraceAsString());
		include SYS_PATH . '/Template/systpl_page_debug.php';
 		exit();
	}

	/**
	 * 输出异常页面，记录日志，用于生成模式
	 * @access public
	 * @return void
	 */
	public function log() {
		$trace = explode("\n", $this->getTraceAsString());
		// require SYS_PATH . DS . 'Template/systpl_page_exception.html';
		// Log::Write($this->getMessage());
		exit();
	}

	protected function getErrorType($errno) {
		switch ($errno) {
			case E_WARNING:
				$message = 'System Warning Error';
				break;
			case E_NOTICE:
				$message = 'System Notice Error';
				break;
			case E_STRICT:
				$message = 'System Strict Error';
				break;
			case E_ERROR:
				$message = 'System Fatal Error';
				break;
			case E_USER_NOTICE:
				$message = 'Application Notice Error';
				break;
			case E_USER_WARNING:
				$message = 'Application Warning Error';
				break;
			case E_USER_ERROR:
				$message = 'Application Fatal Error';
				break;
			default:
				$message = 'Unknow Error';
		}
		return $message;
	}
}

?>