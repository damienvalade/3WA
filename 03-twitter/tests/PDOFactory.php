<?php

namespace Test;

use PDO;

abstract class PDOFactory{
    public static function getPdo(): PDO{
        return new PDO('mysql:host=localhost;dbname=twitter_test', 'root', '',[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }
}