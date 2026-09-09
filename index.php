<?php
session_start();
require_once __DIR__."/vendor/autoload.php";

use App\App;

$uri = $_SERVER["REQUEST_URI"];
$uri = strtok($uri, '?');

$app = new App();
$app->run($uri);