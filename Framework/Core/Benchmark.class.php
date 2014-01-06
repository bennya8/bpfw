<?php

/**
 * 系统性能监测类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Benchmark
{
	/**
	 * 脚本开始时间
	 * @var unknown
	 */
	private static $_timeStart = '';
	/**
	 * 脚本结束时间
	 * @var unknown
	 */
	private static $_timeEnd = '';

	/**
	 * 记录脚本开始时间
	 * @access public
	 * @return void
	 */
	public static function Start() {
		self::$_timeStart = microtime(true);
	}

	/**
	 * 记录脚本结束时间
	 * @access public
	 * @return int
	 */
	public static function End() {
		self::$_timeEnd = microtime(true);
		return round((self::$_timeEnd - self::$_timeStart), 4);
	}

	/**
	 * 获取脚本占用内存
	 * @access public
	 * @return int
	 */
	public static function UseMemory() {
		return memory_get_usage(true);
	}

	/**
	 * 获取脚本峰值内存
	 * @access public
	 * @return int
	 */
	public static function PeakMemory() {
		return memory_get_peak_usage(true);
	}
}
