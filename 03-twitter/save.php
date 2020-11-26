<?php

require_once __DIR__ . '\vendor\autoload.php';

use Twitter\Controller\TweetController;
use Twitter\Http\Request;
use Twitter\Model\TweetModel;

$db = new PDO('mysql:host=localhost;dbname=twitter_test', 'root', '',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$model = new TweetModel($db);
$controller = new TweetController($model);

$request = new Request($_REQUEST);

$response = $controller->saveTweet($request);
$response->send();