<?php

/**
 * Wiicode PHP Framework
 * @namespace Wiicode
 * @package wiicode
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

define('ENVIRONMENT', 'development');

define('ROOT_PATH', str_replace('\\', '/', __DIR__));
define('SYSTEM_PATH', ROOT_PATH . '/Framework');

define('APP_NAME', 'Application');
define('APP_PATH', ROOT_PATH . '/' . APP_NAME);

require SYSTEM_PATH . '/Bootstrap.php';

\System\Core\Application::create('Bootstrap');