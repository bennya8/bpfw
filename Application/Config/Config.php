<?php

return array(
    /* auto load common namespace */
    'namespace' => array(
        'App\\Common' => APP_PATH . '/Common',
        'App\\Event' => APP_PATH . '/Event',
        'App\\Model' => APP_PATH . '/Model',
    ),

    /* auto load module namespace */
    'module' => array(
        'site' => array(
            'path' => 'App\\Site',
            'realpath' => APP_PATH . 'Module/Site',
            'namespace' => array(
                'App\\Site' => APP_PATH . 'Module/Site',
                'App\\Site\\Controller' => APP_PATH . 'Module/Site/Controller',
                'App\\Site\\Event' => APP_PATH . 'Module/Site/Event',
                'App\\Site\\Model' => APP_PATH . 'Module/Site/Model',
            )
        ),

        'admin' => array(
            'path' => 'App\\Admin',
            'realpath' => APP_PATH . 'Module/Admin',
            'namespace' => array(
                'App\\Admin' => APP_PATH . 'Module/Admin',
                'App\\Admin\\Controller' => APP_PATH . 'Module/Admin/Controller',
                'App\\Admin\\Event' => APP_PATH . 'Module/Admin/Event',
                'App\\Admin\\Model' => APP_PATH . 'Module/Admin/Model',
            )
        ),

    ),

    /* helper */
    'helper' => array(
        // example:
        // 'asset' => array( // di instance name
        //      'class'=>'App\Helper\YourSDK', // Your Helper Class
        //      'args' => array( // Initialize args
        //          'server_url'=>'127.0.0.1')
        //       ),
        //'asset' => array('class' => 'System\Helper\Asset'),
        //'captcha' => array('class' => 'System\Helper\Captcha'),
        //'cart' => array('class' => 'System\Helper\Cart'),
        //'http' => array('class' => 'System\Helper\Http'),
        //'queue' => array('class' => 'System\Helper\Queue'),
        //'tree' => array('class' => 'System\Helper\Tree'),
        //'upload' => array('class' => 'System\Helper\Upload'),
    ),

    /* event trigger */
    'event' => array(
        'app_start' => array(),
        'dispatcher_start' => array(),
        'view_start' => array(),
        'view_end' => array(),
        'dispatcher_end' => array(),
        'app_end' => array(),
    ),

    /* framework components */
    /* notice: you can comment out following components which you don't want to use */
    'component' => array(
        /*

        'route' => array(
            // support mode: pathinfo / queryinfo / rewrite
            'mode' => 'pathinfo',
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
            'cache' => false, // field cache
            'prefix' => 'shop_',
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
            'adapter' => 'file',

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

        'translate' => array(
            'default' => 'zh-cn'
        ),

        'security' => array(
            'encryptKey' => '123ckd'
        ),
        */
    )
);