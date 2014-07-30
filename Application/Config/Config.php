<?php

return array(
    'namespace' => array(
        'App\\Common' => APP_PATH . '/Common',
        'App\\Event' => APP_PATH . '/Event',
        'App\\Model' => APP_PATH . '/Model',
    ),

    'module' => array(
        'site' => array(
            'path' => 'App\\Module\\Site',
            'namespace' => array(
                'App\\Module\\Site' => APP_PATH . 'Module/Site',
                'App\\Module\\Site\\Controller' => APP_PATH . 'Module/Site/Controller',
            )
        )
    ),

    'event' => array(
        'app_start' => array(),
        'app_end' => array(),
        'view_start' => array(),
        'view_end' => array()
    ),

    'component' => array(
        'route' => array(
            // pathinfo / queryinfo / rewrite
            'mode' => 'rewrite',
            'defaultModule' => 'site',
            'defaultController' => 'site',
            'defaultAction' => 'index',
            'rules' => array(
                '/' => array('site/site/index'),
                '/news-(:id).html' => array('site/site/test', 'id=(:id)')
            )
        ),

        'view' => array(
            // 'smarty' , 'template lite'
            'engine' => 'native',
            'forceCompile' => true,
            'templateDir' => '',
            'enableCache' => '',
            'cacheTime' => 3600,
            'cacheDir' => '',
        ),

        'database' => array(
            'adapter' => 'pdo',
            'cache' => true, // field cache
            'prefix' => '',
            'servers' => array(
                'master' => array(
                    'dsn' => 'pdo:mysql',
                    'host' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8',
                    'database' => '_test_'
                ),
                'slave' => array(
                    'dsn' => 'pdo:mysql',
                    'host' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8',
                    'database' => '_test_'
                )
            )
        ),

        'cache' => array(
            'adapter' => 'file',

            // file adapter setting
            'filePath' => 'Runtime/Cache',
            'fileNode' => 10,

            // redis adapter setting
            'redisServers' => array(),

            // memcached adapter setting
            'memcachedServers' => array(
                // host , port , weight
                array('localhost', 11211, 30),
                array('localhost', 11212, 30),
                array('localhost', 11213, 10),
            ),
        ),

        'cookie' => array(
            'prefix' => 'fw_',
            'expire' => 3600,
            'path' => '/',
            'domain' => ''
        ),

        'session' => array(
            'adapter' => 'memcached',
            'name' => 'connect-session',
            'expire' => 3600,
            'encrypt' => false,


            'databaseTable' => 'pre_session'
        ),

        'logger' => array(
            'level' => '',
            'size' => 204800,
            'format' => 'Y-m-d H:i:s',
            'extension' => '.log'
        ),

        'profiler' => array(
            'level' => ''
        ),

        'translate' => array(
            'default' => 'zh-cn'
        ),

        'security' => array(
            'encryptKey' => '123ckd'
        ),
    )
);