<?php

/**
 * BPFW 2.0 Lightweight PHP Framework
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

define('ENVIRONMENT', 'development');

define('ROOT_PATH', str_replace('\\', '/', dirname(__DIR__)));
define('SYSTEM_PATH', ROOT_PATH . '/Framework/');

define('APP_NAME', 'Application');
define('APP_PATH', ROOT_PATH . '/' . APP_NAME . '/');

require SYSTEM_PATH . '/core/Application.php';
$application = new \System\Core\Application();
$application->main();

//\System\Core\Application::create('Bootstrap');