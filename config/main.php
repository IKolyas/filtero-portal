<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "../config.php");


return [
    'components' => [
        'db' => [
            'class' => \app\services\DataBase::class,
            'driver' => DB_CONF['driver'],
            'host' => DB_CONF['host'],
            'database' => DB_CONF['database'],
            'user' => DB_CONF['user'],
            'password' => DB_CONF['password'],
            'charset' =>  DB_CONF['charset']
        ]
    ]
];