<?php

namespace app\models\abstracts;

use app\models\interfaces\Product;

abstract class AbstractProducts implements Product
{

    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->price = $price;
        $this->name = $name;
    }

    public function getProductId(): string
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->name;
    }

    public function getProductPrice(): string
    {
        return $this->price;
    }

}