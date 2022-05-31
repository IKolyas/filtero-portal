<?php

namespace app\models\interfaces;

interface Product {

    public function getProductId(): string;
    public function getProductName(): string;
    public function getProductPrice(): string;

}