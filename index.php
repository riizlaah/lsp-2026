<?php
session_start();
require_once __DIR__."/core/app.php";


$uri = $_SERVER["REQUEST_URI"];
$uri = strtok($uri, '?');

$app = new App();
$app->run($uri);