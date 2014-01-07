<?php

/**
 * 系统配置文件
 * @package Root.Framework.Core.Conf
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
return array(
	/* 系统配置 */
	// 环境设定：生产环境(PRODUCTION) 开发环境(DEVELOPMENT)
	'SYS_ENV' => 'DEVELOPMENT',
	// 语言设定：简体中文(ZH-CN) 英文(EN)
	'SYS_LANG' => 'ZH-CN',
	// 时区设定：香港时间(Asia/Hong_Kong) 北京时间(Asia/Beijing)
	'SYS_TIMEZONE' => 'Asia/Hong_Kong',
	// 注意：留空表示使用系统内置跳转模板
	'SYS_ERROR_PAGE' => '', // 错误跳转页面，格式：Controller:Action，如当前应用下的Index:error
	'SYS_SUCCESS_PAGE' => '', // 成功跳转页面，格式：Controller:Action，如当前应用下的Index:success

	
	/* 路由配置 */
	// 路由模式：路径模式(PATH_INFO) 原始模式(ORIGINAL) URL重写(URL-REWRITE)
	// 注意：
	// 百度BAE环境下，不支持PATH_INFO，可选用ORIGINAL模式，配合修改BAE中URL规则实现PATH_INFO访问
	// 百度BAE的URL规则：
	// url /Public/(.*) /Public//$1
	// url /(\w+) /index.php?c=/$1
	// url /(\w+)/(\w+) /index.php?c=/$1&a=/$2
	'Router' => array(
		'URL_MODE' => 'PATH_INFO',
		'DEFAULT_CONTROLLER' => 'Index', // 默认控制器
		'DEFAULT_ACTION' => 'index' ,// 默认方法
	),
						
    /* 数据库配置 */
	// 数据库引擎：MySQL MySQLi PDO:MySQL PDO:SQLite PDO:Oracle
	// 注意：暂只支持MySQL MySQLi PDO:MySQL，其它驱动会在后续版本新增
	
	/* 
	 * 百度BAE MySQL/MySQLi数据库配置参考：
	 * 从平台获取查询要连接的数据库名称
	 * 'DB_ENGINE' => 'MySQL', 或 'DB_ENGINE' => 'MySQLi',
	 * 从BAE环境变量里取出数据库连接需要的参数
	 * 'DB_HOST' => getenv('HTTP_BAE_ENV_ADDR_SQL_IP'),				
	 * 'DB_PORT' => getenv('HTTP_BAE_ENV_ADDR_SQL_PORT'),
	 * 'DB_USER' => getenv('HTTP_BAE_ENV_AK'),
	 * 'DB_PWD' => getenv('HTTP_BAE_ENV_SK'),
	 * 从BAE环境变量里取出数据库连接需要的参数
	 * 'DB_NAME' => 'WBxduSiUccUSWSwuySym',
	 * */
	'DB_ENGINE' => 'MySQL',
	'DB_PREFIX' => '', // 表前缀
	'DB_SHUFIX' => '', // 表后缀
	'DB_HOST' => 'localhost', // IP地址
	'DB_PORT' => '3306', // 端口
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => 'root', // 密码
	'DB_NAME' => 'test', // 数据库名
	'DB_CHARSET' => 'utf8', // 字符集
										
	/* 模板配置 */
	// 模板引擎：Smarty3.1.3(Smarty) TemplateLite2.11(TemplateLite) 原生PHP模板(Native)
	'View' => array(
		'VIEW_ENGINE' => 'smarty', // 模板引擎
		'VIEW_THEME' => 'Default',// 模板皮肤：
	),
	
	/* SMARTY配置 */
	'Smarty' => array(
		'SMARTY_LEFT_DELIMITER' => '<{', // 左边界符
		'SMARTY_RIGHT_DELIMITER' => '}>', // 右边界符
		'SMARTY_TEMPLATE_DIR' => APP_PATH . '/View/', // 模板目录，请不要随意修改
		'SMARTY_COMPILE_DIR' => APP_PATH . '/Temp/Compiled', // 编译模板目录，请不要随意修改
		'SMARTY_CACHE_DIR' => APP_PATH . '/Temp/Cache', // 静态网页缓存目录，请不要随意修改
		'SMARTY_FORCE_COMPILE' => false, // 强制编译模板，开发环境下建议开启
		'SMARTY_COMPILE_CHECK' => false, // 检查编译模板，开发环境下建议开启
		'SMARTY_CACHING' => false, // 静态页面缓存，生产环境下建议开启
		'SMARTY_CACHE_TIME' => 3600, // 缓存时间，静态页面缓存关闭时，此选项失效
	),
	
	/* TEMPLATE LITE配置 */
	'TMPLITE' => array(
		'TMPLITE_LEFT_DELIMITER' => '<{', // 左边界符
		'TMPLITE_RIGHT_DELIMITER' => '}>', // 右边界符
		'TMPLITE_TEMPLATE_DIR' => APP_PATH . '/View/', // 模板目录，请不要随意修改
		'TMPLITE_COMPILE_DIR' => APP_PATH . '/Temp/Compiled', // 编译模板目录，请不要随意修改
		'TMPLITE_CACHE_DIR' => APP_PATH . '/Temp/Cache/', // 静态网页缓存目录，请不要随意修改
		'TMPLITE_FORCE_COMPILE' => false, // 强制编译模板，开发环境下建议开启
		'TMPLITE_COMPILE_CHECK' => false, // 检查编译模板，开发环境下建议开启
		'TMPLITE_CACHE' => false, // 静态页面缓存，生产环境下建议开启
		'TMPLITE_CACHE_TIME' => 3600 // 缓存时间，静态页面缓存关闭时，此选项失效
	)
);
