<?php
session_start();
require_once __DIR__."/vendor/autoload.php";

use App\App;

$route = $_SERVER["REQUEST_URI"];
$route = strtok($route, '?');

$app = new App();
$app->run($route);