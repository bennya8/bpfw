<?php

namespace System\Core;

class Debug {
	private static $_trace = array();
	private static $_timeStart = '';
	private static $_timeEnd = '';
	
	public static function start(){
		self::$_timeStart = microtime(true);
	}
	
	public static function end(){
		self::$_timeEnd = microtime(true);
		return round((self::$_timeEnd - self::$_timeStart) , 4);
	}
	

	public static function trace($message) {
		if(defined('DEBUG')){
			if(is_string($message)) self::$_trace[] = $message;
		}
	}

	public static function printTrace() {
		if(defined('DEBUG')){
			$trace = array_reverse(self::$_trace);
			$html = '<table width="98%" style="position:absolute;bottom:0;">';
			foreach($trace as $v){
				$microtime = explode(' ', microtime());
				$html .= '<tr><td style="background:#eee;">' . date('Y-m-d H:i:s', time()) . ' ' . $microtime[0] . ' ' . $v . '</td></tr>';
			}
			$html .= '</table>';
			echo $html;
		}
	}
}
