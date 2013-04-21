<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', str_replace("\\", "/", dirname(__FILE__)));

/* 框架路径，请不要随意修改 */
define('SYS_PATH', ROOT_PATH . DS . 'Framework');
define('PUBLIC_PATH', ROOT_PATH . DS . 'Public');

/* 应用路径，可自行修改'App'中的内容，'App'为你的应用目录名 */
define('APP_PATH', ROOT_PATH . DS . 'App');

/* 应用名称，可自行修改 'App'中的内容，'App'为你的应用名，用于权限识别 */
define('APP_NAME', 'App');

/* 引入核心文件，请不要修改 */
require SYS_PATH . DS . 'Core/App.class.php';

/* 应用启动 */
App::create()->run();
?>