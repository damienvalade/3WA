<?php

require_once __DIR__ . '\vendor\autoload.php';

use Twitter\Http\Request;
use Twitter\Controller\HelloController;

$request = new Request($_REQUEST);
$controller = new HelloController;
$response = $controller->sayHello($request);

$response->send();