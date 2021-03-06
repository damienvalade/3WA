<?php

require_once __DIR__ . '\vendor\autoload.php';

use Twitter\Http\Request;
//use Twitter\Controller\HelloController;
use Twitter\Controller\TweetController;
use Twitter\Model\TweetModel;

$request = new Request($_REQUEST);

//$controller = new HelloController;
//$response = $controller->sayHello($request);

$db = new PDO('mysql:host=localhost;dbname=twitter_test', 'root', '',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$model = new TweetModel($db);
$controller = new TweetController($model);
$response = $controller->listTweets();

$response->send();
