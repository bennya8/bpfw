<?php

namespace System\Core;

class Response extends Component
{
	private static $statusCode = array(
		200 => 'HTTP/1.1 200 OK',
		301 => 'HTTP/1.1 301 Moved Permanently',
		401 => 'HTTP/1.1 401 Unauthorized',
		403 => 'HTTP/1.1 403 Forbidden',
		404 => 'HTTP/1.1 404 Not Found',
		500 => 'HTTP/1.1 500 Internal Server Error',
		508 => 'HTTP/1.1 508 Loop Detected',
		
		510 => 'HTTP/1.1 510 Not Extended',
		600 => 'HTTP/1.1 600 Unparseable Response Headers'
	);

	public function sendStatus($code) {
		header(self::$statusCode[$code]);
	}

	public function sendLang($lang) {}
}