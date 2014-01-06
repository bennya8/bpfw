<?php

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
	 * @access private
	 * @var array
	 */
	private static $errorMessage = array();

	/**
	 * 创建目录
	 * @access public
	 * @param string $dir 目录路径
	 * @param int $mode 目录权限
	 * @param boolean $recursive 递归创建子目录
	 * @return void 可通过获取 GetError() 信息判定目录删除成功与否信息
	 */
	public static function MakeDir($dir, $mode = 0755, $recursive = true) {
		if (is_string($dir) && !is_dir($dir)) {
			if (!mkdir($dir, $mode, $recursive)) self::SetError('_MAKE_DIR_FAILED_', $dir);
		}
	}

	/**
	 * 删除目录
	 * @access public
	 * @param string $dir 目录路径
	 * @param boolean $recursive 递归删除子目录
	 * @return void 可通过获取 GetError() 信息判定目录删除成功与否信息
	 */
	public static function RemoveDir($dir, $recursive = true) {
		if (is_string($dir) && is_dir($dir)) {
			$handle = opendir($dir);
			while (false !== ($file = readdir($handle))) {
				if ($file !== '.' && $file !== '..') {
					$path = $dir . DS . $file;
					if (is_dir($path) && $recursive) {
						self::RemoveDir($path);
					} else {
						self::RemoveFile($path);
					}
				}
			}
			if (!rmdir($dir)) self::SetError('_REMOVE_DIR_FAILED_', $dir);
		}
	}

	/**
	 * 移动文件
	 * @access public
	 * @param string $source 文件原路径
	 * @param string $target 文件新路径
	 * @param boolean $cover 是否覆盖重名文件
	 * @return void 可通过获取 GetError() 信息判定目录删除成功与否信息
	 */
	public static function MoveFile($source, $target, $cover = false) {
		if (is_string($source) && is_string($target)) {
			self::MakeDir(dirname($target));
			if (is_file($source)) {
				if (is_file($target) && $cover) {
					self::RemoveFile($target);
					if (!copy($source, $target)) self::SetError('_MOVE_FILE_FAILED_', $target);
					self::RemoveFile($source);
				} else {
					self::SetError('_FILE_EXIST_', $target);
				}
			}
		}
	}

	/**
	 * 复制文件
	 * @access public
	 * @param string $source 文件原路径
	 * @param string $target 文件新路径
	 * @param boolean $cover 是否覆盖重名文件
	 * @return void 可通过获取 GetError() 信息判定目录删除成功与否信息
	 */
	public static function CopyFile($source, $target, $cover = false) {
		if (is_string($source) && is_string($target)) {
			self::MakeDir(dirname($target));
			if (is_file($source)) {
				if (is_file($target) && $cover) {
					self::RemoveFile($target);
					if (!copy($source, $target)) self::SetError('_COPY_FILE_FAILED_', $target);
				} else {
					self::SetError('_FILE_EXIST_', $target);
				}
			}
		}
	}

	/**
	 * 批量删除文件
	 * @access public
	 * @param array / string 文件路径
	 * @return void 可通过获取 GetError() 信息判定目录删除成功与否信息
	 */
	public static function RemoveFile($source) {
		if (is_string($source) && is_file($source)) {
			if (unlink($source)) self::SetError('_REMOVE_FILE_FAILED_', $source);
		}
	}

	/**
	 * 设置错误信息
	 * @access public
	 * @param string $errorType 消息类别
	 * @param string $path 文件/目录信息
	 * @return void
	 */
	public static function SetError($errorType, $path) {
		self::$errorMessage[] = Config::Lang($errorType) . ' => ' . securePath($path);
	}

	/**
	 * 获取错误信息列表
	 * @access public
	 * @return array 错误信息列表
	 */
	public static function GetError() {
		return self::$errorMessage;
	}
}
