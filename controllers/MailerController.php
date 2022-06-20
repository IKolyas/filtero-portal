<?php

namespace app\controllers;

use app\services\Mailer;
require_once ("../services/Mailer.php");

 
    $email = new Mailer();
    $email->sendEmail();
