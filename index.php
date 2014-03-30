<?php

/**
 * Wiicode PHP Framework
 * This source file is subject to the New BSD License that is bundled
 * with this package in the file docs/LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to benny_a8@live.com so we can send you a copy immediately.
 *
 * @category    Wiicode
 * @package     Wiicode
 * @copyright   Copyright (c) 2014 wiicode.net (http://wiicode.net)
 * @author      Benny <benny_a8@live.com>
 */

define('DEBUG', TRUE);

define('ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('SYSTEM_PATH', ROOT_PATH . '/framework');
require SYSTEM_PATH . '/Bootstrap.php';

define('APP_NAME', 'Application');
define('APP_PATH', ROOT_PATH . '/' . APP_NAME);

\Wiicode\Core\Application::create('Bootstrap');