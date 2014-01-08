<?php

/**
 * 系统日志类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Log extends Component
{

	/**
	 * 写入一条日志，自动换行
	 * @access public
	 * @param string $msg 日志消息
	 * @param int $size 日志文件大小，字节为单位，默认2048000 = 2M
	 * @return boolean true 写入日志成功 / false 写入日志失败
	 */
	public static function Write($msg, $size = 2048000)
	{
		$current = APP_PATH . DS . '/Temp/Log/current.log';
		$next = APP_PATH . DS . '/Temp/Log' . date('ymd_his') . '.log';
		if (!is_dir(dirname($current))) mkdir(dirname($current), 0777, true);
		if (!is_file($current)) touch($current);
		if (filesize($current) >= $size) {
			rename($current, $next);
			touch($current);
		}
		$format = date('[Y/m/d-H:i:s] ') . $msg . PHP_EOL;
		if (file_put_contents($current, $format, FILE_APPEND | LOCK_EX)) {
			return true;
		}
		return false;
	}
}