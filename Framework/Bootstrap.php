<?php

/**
 * Framework bootstrap
 * @namespace System
 * @package system.bootstrap
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

require SYSTEM_PATH . 'Core/Loader.php';
$loader = new \System\Core\Loader();
$loader->register();
$loader->registerNamespace(array(
    'System\\Cache' => SYSTEM_PATH . 'Cache',
    'System\\Cache\\Adapter' => SYSTEM_PATH . 'Cache/Adapter',
    'System\\Core' => SYSTEM_PATH . 'Core',
    'System\\Event' => SYSTEM_PATH . 'Event',
    'System\\Extend' => SYSTEM_PATH . 'Extend',
    'System\\Database' => SYSTEM_PATH . 'Database',
    'System\\Database\\Adapter' => SYSTEM_PATH . 'Database/Adapter',
    'System\\Database\\Adapter\\MySQL' => SYSTEM_PATH . 'Database/Adapter/MySQL',
    'System\\Database\\Adapter\\MySQLi' => SYSTEM_PATH . 'Database/Adapter/MySQLi',
    'System\\Database\\Adapter\\PDO' => SYSTEM_PATH . 'Database/Adapter/PDO',
    'System\\Helper' => SYSTEM_PATH . 'Helper',
    'System\\Session' => SYSTEM_PATH . 'Session',
    'System\\Session\\Adapter' => SYSTEM_PATH . 'Session/Adapter',
));
\System\Core\DI::factory()->set('loader', $loader);