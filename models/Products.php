<?php

namespace app\models;

use app\models\abstracts\AbstractProducts as AbstractProduct;
use app\traits\GetSale as GetSale;

class Products extends AbstractProduct {
    use GetSale;

    public function test($name)
    {
        echo "facade $name";
    }

    public function __isset($name)
    {
        echo "Такого свойства у меня нет!!! @$name@";
    }

    public static function __callStatic($name, $arguments)
    {
        var_dump(method_exists(self::class, $name));
        if(method_exists(self::class, $name)) {
            call_user_func((self::class)->$name($arguments));
        }
    }
}