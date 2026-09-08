<?php

require_once __DIR__ . "/viewRenderer.php";

function view(string $viewName, array $vars = []) {
    ViewRenderer::loadView($viewName, $vars);
}

function generateCSRFToken() {
    if(isset($_SESSION["_csrf_token"])) return $_SESSION["_csrf_token"];
    $hexStr = bin2hex(random_bytes(32));
    $_SESSION["_csrf_token"] = $hexStr;
    return $hexStr;
}

function validateCSRFToken() {
    $input = trim($_POST["_csrf_token"]);
    if(!isset($_SESSION["_csrf_token"])) return false;
    $valid = hash_equals($_SESSION["_csrf_token"], $input);
    if($valid) unset($_SESSION["_csrf_token"]);
    return $valid;
}

function errCode(int $code, string $message = "") {
    http_response_code($code);
    echo "<h1>$code | $message</h1>";
    exit;
}

function redirect(string $route) {
    header("Location: $route");
    exit;
}

function redirectWithAlert(string $route, string $message) {
    echo "<script>alert('$message'); document.location.href = '$route';</script>";
    exit;
}

function old(string $inputName) {
    if(!isset($_SESSION["_flash"]["oldInput"][$inputName])) return null;
    return Session::flash('oldInput')[$inputName];
}
