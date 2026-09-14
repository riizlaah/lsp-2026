<?php

// namespace App;

use App\ViewRenderer;

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

function redirectBack() {
    $ref = empty($_SERVER["HTTP_REFERER"]) ? "/" : $_SERVER["HTTP_REFERER"];
    redirect($ref);
}

function redirectBackWithErrors(array $errors) {
    $_SESSION["_errors"] = $errors;
    redirectBack();
}

function redirectBackWithAlert(string $message) {
    $ref = empty($_SERVER["HTTP_REFERER"]) ? "/" : $_SERVER["HTTP_REFERER"];
    redirectWithAlert($ref, $message);
}

function session_flash(string $name, mixed $value = null) {
    if(!isset($_SESSION["_flash"][$name]) && !is_null($value)) {
        $_SESSION["_flash"][$name] = $value;
        return;
    }
    if(isset($_SESSION["_flash"][$name])) {
        $val = $_SESSION["_flash"][$name];
        unset($_SESSION["_flash"][$name]);
        return $val;
    }
}

function session_invalidate() {
        $_SESSION = [];
        session_destroy();
        session_regenerate_id();
    }

function old(string $inputName, bool $escape = true) {
    if(!isset($_SESSION["_flash"]["oldInput"][$inputName])) return null;
    $value = $escape ? htmlspecialchars($_SESSION["_flash"]["oldInput"][$inputName]) : $_SESSION["_flash"]["oldInput"][$inputName];
    // unset($_SESSION["_flash"]["oldInput"][$inputName]);
    return $value;
}

function pushErr(string $inputName, array $messages) {
    $_SESSION["_errors"][$inputName] = array_merge( $_SESSION["_errors"][$inputName] ?? [], $messages);
}

function err(string $inputName = "") {
    if(empty($inputName)) return $_SESSION["_errors"] ?? [];
    return $_SESSION["_errors"][$inputName] ?? null;
}

function ensureInputFilled(array $input, array $requiredKeys) {
    // dd($input);
    foreach($requiredKeys as $key) {
        if(isset($input[$key])) {
            if(!empty(trim($input[$key]))) continue;
        }
        pushErr($key, ["'$key' harus diisi"]);
    }
    if(!empty($_SESSION["_errors"])) redirectBack();
    
}

function sanitizeInput(string $inputName, $escHTML = true) {
    return $escHTML ? htmlspecialchars(trim($_POST[$inputName])) : trim($_POST[$inputName]);
}

function ensureImageValid(string $inputName) {
    if(!isset($_FILES[$inputName])) redirectBackWithErrors([$inputName => ["'$inputName' harus diisi"]]);
    
}

function moveUploadedFile($inputName, $directory, $target = "") {
    
}

function dd(mixed ...$vars) {
    var_dump(...$vars);
    die;
}

