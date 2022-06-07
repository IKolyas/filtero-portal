<?php

return [
    'views_dir' => realpath(__DIR__ . '/../') . "/views/",
    'default_controller' => 'activities',
    'controller_namespace' => 'app\controllers\\',
    'components' => [
        'user' => [
            'class' => \app\models\User::class,
        ],
        'request' => [
            'class' => \app\base\Request::class,
        ],
        'path' => [
            'class' => \app\services\Path::class,
        ],
        'db' => [
            'class' => \app\services\DataBase::class,
            'driver' => DB_CONF['driver'],
            'host' => DB_CONF['host'],
            'database' => DB_CONF['database'],
            'user' => DB_CONF['user'],
            'password' => DB_CONF['password'],
            'charset' => DB_CONF['charset']
        ],
        'userRepository' => [
            'class' => \app\models\repositories\UserRepository::class,
        ],
    ]
];
