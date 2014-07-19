<?php

return array(
    'namespace' => array(
        'App\\Common' => APP_PATH . '/Common',
        'App\\Event' => APP_PATH . '/Event',
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
        'logger' => array(
            'level' => '',
            'size' => 204800,
            'format' => 'Y-m-d H:i:s',
            'extension' => '.log'
        ),

        'profiler' => array(
            'level' => ''
        ),

        'cache' => array(
            'adapter' => 'file',

            'file' => array(
                'path' => ROOT_PATH . 'Runtime/Cache',
                'node' => 10
            ),

            'redis' => array(),
            'memcache' => array(
                'servers' => array(
                    array(
                        'host' => 'localhost',
                        'port' => 11211,
                        'weight' => 10
                    ),
                    array(
                        'host' => 'localhost',
                        'port' => 11212,
                        'weight' => 10
                    ),
                    array(
                        'host' => 'localhost',
                        'port' => 11213,
                        'weight' => 10
                    ),
                    array(
                        'host' => 'localhost',
                        'port' => 11214,
                        'weight' => 10
                    ),
                    array(
                        'host' => 'localhost',
                        'port' => 11215,
                        'weight' => 10
                    ),
                ),
            ),
        ),

        'cookie' => array(
            'prefix' => 'fw_',
            'expire' => 3600,
            'path' => '/',
            'domain' => ''
        ),

        'session' => array(
            'adapter' => 'file',
        ),

        'translate' => array(
            'default' => 'zh-cn'
        ),

        'security' => array(
            'encryptKey' => '123ckd'
        ),

        'route' => array(
            'mode' => 'native',
            'defaultModule' => 'site',
            'defaultController' => 'site',
            'defaultAction' => 'index',
            'rules' => array()
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
            'adapter' => 'mysql',

            'servers' => array(
                'master' => array(
                    // only use pdo driver require this param
                    // 'dsn' => 'pdo:mysql',

                    'host' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8',
                    'database' => '_test_'
                )
            )
        )
    )
);