<?php

return array(
    'namespace' => array(
        'App\\Common' => APP_PATH . '/Common',
        'App\\Event' => APP_PATH . '/Event',
        'App\\Model' => APP_PATH . '/Model',
    ),

    'module' => array(
        'site' => array(
            'path' => 'App\\Site',
            'namespace' => array(
                'App\\Site' => APP_PATH . 'Site',
                'App\\Site\\Controller' => APP_PATH . 'Site/Controller',
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
            // support mode: pathinfo / queryinfo / rewrite
            'mode' => 'rewrite',
            'defaultModule' => 'site',
            'defaultController' => 'site',
            'defaultAction' => 'index',
            'rules' => array(
                '/' => array('site/site/index')
            )
        ),

        'view' => array(
            // support engine: native / smarty / tplite'
            'engine' => 'native',
            'theme' => 'Default',
            'layout' => 'layout',

            // smarty and tplite engine setting
        ),

        'database' => array(
            'adapter' => 'pdo',
            'cache' => true, // field cache
            'prefix' => '',
            'servers' => array(
                'master' => array(
                    'host' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8',
                    'database' => '_test_'
                ),
                'slave' => array(
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
            // support adapter: file, memcached, redis
            'adapter' => 'redis',

            // file adapter setting
            'filePath' => 'Runtime/Cache',
            'fileNode' => 10,

            // redis adapter setting
            'redisServers' => array(
                array('localhost', 6379),
                array('localhost', 6380),
            ),

            // memcached adapter setting
            'memcachedServers' => array(
                // host , port , weight
                array('localhost', 11211, 1),
                array('localhost', 11212, 1),
            ),
        ),

        'cookie' => array(
            'prefix' => 'fw_',
            'expire' => 3600,
            'path' => '/',
            'domain' => ''
        ),

        'session' => array(
            // support adapter: file, memcached, redis, database
            'adapter' => 'redis',
            'name' => 'connect-session',
            'expire' => 3600,
            'encrypt' => false,

            // database adapter setting
            'databaseTable' => 'pre_session'
        ),

        'logger' => array(
            'level' => 'error,warning,notice,sql',
            'path' => 'Runtime/Logs',
            'size' => 204800,
            'format' => 'Ymd',
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