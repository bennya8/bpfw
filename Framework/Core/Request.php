<?php

namespace System\Core;

class Request extends Component
{

	/**
	 * 构造函数
	 */
	public function __construct() {
		
		if (get_magic_quotes_gpc()) {
			set_magic_quotes_runtime(0);
		}
		$_GET = $this->filterEscape($_GET);
		$_POST = $this->filterEscape($_POST);
		$_COOKIE = $this->filterEscape($_COOKIE);
	}

	public function getUserAgent() {}

	public function getUserIp() {}

	/**
	 * 递归添加转义字符
	 * @param mixed $data
	 * @return mixed
	 */
	public function filterEscape($data) {
		if (is_string($data)) return addslashes($data);
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = $this->filterEscape($v);
			}
		}
		return $data;
	}

	/**
	 * 递归去除转义字符
	 * @param mixed $data
	 * @return mixed
	 */
	public function filterUnescape($data) {
		if (is_string($data)) return stripslashes($data);
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = $this->filterUnescape($v);
			}
		}
		return $data;
	}
}
