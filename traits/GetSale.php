<?php

namespace app\traits;

trait GetSale
{
    public function __construct($id, $name, $price)
    {
        parent::__construct($id, $name, $price);
    }

    public function getSale()
    {
        return $this->price / 2;
    }

}