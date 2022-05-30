<?php

namespace app\interfaces;

interface Product {

    public function getProductId(): string;
    public function getProductName(): string;
    public function getProductPrice(): string;

}