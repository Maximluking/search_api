<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=sphinx;port=9306;',
            'username' => '',
            'password' => '',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
