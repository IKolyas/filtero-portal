<?php

namespace app\services;

class ExceptionMessenger
{

    protected array $errors = [
        'database' => [
            'update' => 'Не удалось обновить поля в базе данных',
            'create' => 'Не удалось создать поля в базе данных',
        ],
//        'validate' =>
    ];

    protected array $types = [
        'database' => 'База данных'
    ];


    public function sendMessage($error_type, $error_action): array
    {
        return ['type' => $this->types['database'], 'message' => $this->errors[$error_type][$error_action]];
    }
}