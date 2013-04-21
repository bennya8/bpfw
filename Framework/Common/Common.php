<?php

/**
 * 应用共用函数
 * @package Root.Framework.Core.Common
 * @author Benny <benny_a8@live.com> github.com/bennya8 <github.com/bennya8>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

/**
 * 调试函数，打印出变量信息
 * @param mixed $vars
 * @return void
 */
function dump($vars)
{
	echo '<pre>';
	var_dump($vars);
	echo '</pre>';
}

/**
 * 调试函数，作为程序断点，打印出变量信息
 * @param mixed $vars
 * @return void
 */
function breakpoint($vars = null)
{
	echo '<pre>';
	var_dump($vars);
	echo '</pre>';
	exit();
}

/**
 * 返回安全路径
 * @param string $path 完整路径
 * @return string 安全路径
 * @example /Volumes/Workspace//App/Action/IndexAction.class.php =>
 *          /App/Action/IndexAction.class.php
 */
function securePath($path)
{
	return str_replace(ROOT_PATH, '', $path);
}

/**
 * 多维数组的合并，当相同的字符串键名，后面的自动覆盖前面
 * @author caoge
 * @param array $array1 数组1
 * @param array $array2 数组2
 * @return array 合并后的数组
 */
function multi_array_merge($array1, $array2)
{
	if (is_array($array2) && count($array2)) { // 不是空数组的话
		foreach ($array2 as $k => $v) {
			if (is_array($v) && count($v)) {
				$array1[$k] = multi_array_merge($array1[$k], $v);
			} else {
				if (!empty($v)) {
					$array1[$k] = $v;
				}
			}
		}
	} else {
		$array1 = $array2;
	}
	return $array1;
}
?>