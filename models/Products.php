<?php

namespace app\models;

use app\abstracts\AbstractProducts as AbstractProduct;

use app\traits\GetSale as GetSale;

class Products extends AbstractProduct {
    use GetSale;

    public function __isset($name)
    {
        echo "Такого свойства у меня нет!!! @$name@";
    }
}