<?php

return array(
    'namespace' => array(),
    'module' => array(),

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
        'route' => array(
            'mode' => 'pathinfo',
            'defaultModule' => 'site',
            'defaultController' => 'site',
            'defaultAction' => 'site',
            'rules' => array()
        ),
        'cache' => array(
            'adapter' => 'file',

        ),
        'session' => array(
            'adapter' => 'file',

        ),
        'translate' => array(
            'default' => 'zh-cn'

        ),
        'security' => array(
            'enable' => ''
        ),
        'database' => array(
            // mysql,mysqli,pdo,access
            'adapter' => 'mysql',
            'server' => array(
                'master' => array(
                    'host' => 'localhost',
                    'port' => 3306,
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8',
                    'database' => '_test_'
                )
            ),
        ),
        'request' => array(
            'defaultFilter' => 'addslashed'
        ),
        'response' => array(
            ''
        ),
        'view' => array(
            // 'smarty' , 'template lite'
            'engine' => 'native',
            'forceCompile' => true,
            'templateDir' => '',
            'enableCache' => '',
            'cacheTime' => 3600,
            'cacheDir' => '',
        )
    ),


    'route' => array(),


);