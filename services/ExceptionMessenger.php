<?php

namespace app\services;

class ExceptionMessenger
{

    protected array $errors = [
        'database' => [
            'update' => 'Не удалось обновить поля в базе данных',
            'create' => 'Не удалось создать поля в базе данных',
            'delete' => 'Не удалось удалить поля в базе данных',
            'connection' => 'Не удалось подключиться к базе данных'
        ],
        'migration' => [
            'create' => 'Не удалось создать миграцию',
            'drop' => 'Не удалось удалить миграцию',
            'up' => 'Fail UP',
            'down' => 'Fail DOWN',
            'createClass' => 'Не удалось создать класс миграции',
            'findMigration' => 'Не удалось найти миграцию'
        ]
//        'validate' =>
    ];

    protected array $types = [
        'database' => 'База данных',
        'migration' => 'Миграция'
    ];


    public function sendMessage($error_type, $error_action): array
    {
        return ['type' => $this->types[$error_type], 'message' => $this->errors[$error_type][$error_action]];
    }
}