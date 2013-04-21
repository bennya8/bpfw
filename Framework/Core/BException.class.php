<?php

/**
 * 系统自定义异常类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class BException extends Exception
{

	/**
	 * 输出异常页面，但不记录日志，用于开发模式
	 * @access public
	 * @return void
	 */
	public function printMsg()
	{
		$trace = explode("\n", $this->getTraceAsString());
		require SYS_PATH . DS . 'Template/systpl_page_debug.html';
		exit();
	}

	/**
	 * 输出异常页面，记录日志，用于生成模式
	 * @access public
	 * @return void
	 */
	public function saveMsg()
	{
		$trace = explode("\n", $this->getTraceAsString());
		require SYS_PATH . DS . 'Template/systpl_page_exception.html';
		Log::Write($this->getMessage());
		exit();
	}
}

?>