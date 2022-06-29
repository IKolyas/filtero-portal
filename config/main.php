<?php

/*
'views_dir'                     -       корневая директория шаблонов по клиентской части
'default_controller'            -       контроллер, которое при переходе на сайт пользователю открывает страницу по умолчанию
'controller_namespace'          -       пространство имен контроллеров
'cookie_time'                   -       время хранения куки зарегистрированного пользователя
'components'                    -       Массив предоставляющий доступ к классам из любой точки проекта. 
                                        Массив можно расширить добавляя необходимые компоненты для дальнейшего его использования.
*/

return [
    'views_dir' => realpath(__DIR__ . '/../') . "/" . CONFIG['views_dir'] . "/",
    'default_controller' => CONFIG['default_controller'],
    'controller_namespace' => 'app\controllers\\',
    'cookie_time' => CONFIG['cookie_time'],
    'components' => [
//       BASE
        'request' => [
            'class' => \app\base\Request::class,
        ],
        'path' => [
            'class' => \app\services\Path::class,
        ],
        'db' => [
            'class' => \app\services\DataBase::class,
            'driver' => CONFIG['db_driver'],
            'host' => CONFIG['db_host'],
            'database' => CONFIG['db_database'],
            'user' => CONFIG['db_user'],
            'password' => CONFIG['db_password'],
            'charset' => CONFIG['db_charset']
        ],
        'renderer' => [
            'class' => \app\services\renderers\TwigRenderer::class,
        ],
        'session' => [
            'class' => \app\base\Session::class,
        ],
        'cookie' => [
            'class' => \app\base\Cookie::class,
        ],

//       PROJECT ENTITIES
        'userRepository' => [
            'class' => \app\models\repositories\UserRepository::class,
        ],
        'user' => [
            'class' => \app\models\User::class,
        ],
    ]
];
