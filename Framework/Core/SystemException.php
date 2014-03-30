<?php

namespace System\Core;

class SystemException extends \Exception
{

	public function __construct($message = null, $code = null, $previous = null) {
		
		parent::__construct();
	}
}