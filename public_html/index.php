<?php
try {
    $connect = new PDO('mysql:dbname=a0678406_db;host=localhost', 'a0678406_db', 'filteroDb');
    var_dump($connect);
} catch (Exception $e) {
    var_dump($e);
}


