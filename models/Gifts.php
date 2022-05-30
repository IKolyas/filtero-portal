<?php

namespace app\models;

use app\abstracts\AbstractProducts as AbstractProduct;
use app\traits\GetSale as GetSale;

class Gifts extends AbstractProduct {
    use GetSale;
}