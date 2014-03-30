<?php

namespace Wiicode\Core;

/**
 * 系统文件操作类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class FileSystem
{
	/**
	 * 错误消息列表
	 * @access public
	 * @var array
	 */
	public static $errorMessage = array();

	/**
	 * 批量创建目录
	 * @access public
	 * @param string / array $dir 目录路径
	 * @param int $mode 目录权限
	 * @param boolean $recursive 使用递归创建
	 * @return boolean true 创建目录成功 / false 创建目录失败，可查看错误消息列表
	 */
	public static function MakeDir($dir, $mode = 0777, $recursive = true)
	{
		if (is_string($dir)) {
			if (is_dir($dir)) return false;
			if (!mkdir($dir, $mode, $recursive)) {
				throw new BException(Config::Lang('_DIR_CANNOT_WRITE_') . ' => ' . securePath($dir));
			}
			return true;
		} else if (is_array($dir)) {
			foreach ($dir as $v) {
				if (is_dir($v)) continue;
				if (!mkdir($v, $mode, $recursive)) {
					throw new BException(
							Config::Lang('_DIR_CANNOT_WRITE_') . ' => ' . securePath($dir));
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * 批量移动文件
	 * @access public
	 * @param array $file 要移动文件的数组，格式：$k => 原始位置 $v => 目的位置
	 * @param boolean $cover 是否覆盖重名文件
	 * @return boolean true 移动文件成功 / false 移动文件失败，可查看错误消息列表
	 */
	public static function MoveFile($file, $cover = false)
	{
		if (is_array($file)) {
			if (count($file) == 0) return false;
			foreach ($file as $k => $v) {
				if (is_file($k)) {
					if (!is_dir(dirname($v))) {
						if (!mkdir(dirname($v), 0777, true)) {
							self::$errorMessage[Config::Lang('_MAKE_DIR_FAILED_')] = securePath($v);
						}
					}
					if (is_file($v) && $cover) {
						unlink($v);
					}
					if (is_file($v) && !$cover) {
						continue;
					}
					if (!copy($k, $v)) {
						self::$errorMessage[Config::Lang('_FILE_CANNOT_WRITE_')] = securePath($v);
					}
					unlink($k);
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * 批量复制文件
	 * @access public
	 * @param array $file 要复制文件的数组，格式：$k => 原始位置 $v => 目的位置
	 * @param boolean $cover 覆盖重名文件
	 * @return boolean true 复制文件完成 / false 复制文件失败
	 */
	public static function CopyFile($file, $cover = false)
	{
		if (is_array($file)) {
			if (count($file) === 0) return false;
			foreach ($file as $k => $v) {
				if (is_file($k)) {
					if (!is_dir(dirname($v))) {
						if (!mkdir(dirname($v), 0777, true)) {
							self::$errorMessage[Config::Lang('_MAKE_DIR_FAILED_')] = securePath($v);
						}
					}
					if (is_file($v) && $cover) {
						self::$errorMessage[Config::Lang('_FILE_EXIST_')] = securePath($v);
						continue;
					}
					if (!copy($k, $v)) {
						self::$errorMessage[Config::Lang('_COPY_FILE_FAILED_')] = securePath($v);
					}
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * 批量删除文件
	 * @todo
	 */
	public static function removeFile($file)
	{}


}
