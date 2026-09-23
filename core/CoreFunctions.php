<?php

// namespace App;

use App\Config;
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
    if(!isset($_SESSION["_csrf_token"])) return false;
    $input = trim($_POST["_csrf_token"]);
    $valid = hash_equals($_SESSION["_csrf_token"], $input);
    if($valid) unset($_SESSION["_csrf_token"]);
    return $valid;
}

function errCode(int $code, string $message = "") {
    http_response_code($code);
    echo "<h1>$code | $message</h1>";
    echo "<script>setTimeout(() => {document.location.href = \"/\"}, 2000)</script>";
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

function redirectBackWithError(string $inputName, array $messages) {
    $_SESSION["_errors"][$inputName] = array_merge($_SESSION["_errors"][$inputName] ?? [], $messages);
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

function flash_exists(string $name) {
    return isset($_SESSION["_flash"][$name]);
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

function ensureAttachmentValid(string $inputName, int $maxSize = 10000000, $mimetypes = ["image/png", "image/jpeg", "image/webp"]) {
    if(!isset($_FILES[$inputName])) redirectBackWithError($inputName, ["'$inputName' harus diisi"]);
    $fileErr = $_FILES[$inputName]["error"];
    if($fileErr != UPLOAD_ERR_OK) redirectBackWithError($inputName, ["'$inputName' gagal diupload (kode: " . (string)$fileErr . ")"]);
    $fileSize = $_FILES[$inputName]["size"];
    $filename = $_FILES[$inputName]["tmp_name"];
    if($fileSize > $maxSize) redirectBackWithError($inputName, ["ukuran '$inputName' terlalu besar (maksimal: " . (string)round((float)$maxSize / 1000000, 2) . "MB"]);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimetype = $finfo->file($filename);
    if(!$mimetype) redirectBackWithError($inputName, ["Gagal membaca MIMETYPE dari '$inputName'"]);
    if(!in_array($mimetype, $mimetypes)) redirectBackWithError($inputName, ["File harus berupa format: " . implode(", ", $mimetypes)]);

}

function ensureAttachmentValidJSON(string $inputName, int $maxSize = 10000000, $mimetypes = ["image/png", "image/jpeg", "image/webp"]) {
    header("Content-Type: application/json");
    if(!isset($_FILES[$inputName])) {
        http_response_code(400);
        echo json_encode(["message" => "'$inputName' harus diisi"]);
        die;
    }
    $fileErr = $_FILES[$inputName]["error"];
    if($fileErr != UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(["message" => "'$inputName' gagal diupload (kode: " . (string)$fileErr . ")"]);
        die;
    }
    $fileSize = $_FILES[$inputName]["size"];
    $filename = $_FILES[$inputName]["tmp_name"];
    if($fileSize > $maxSize) {
        http_response_code(400);
        echo json_encode(["message" => "ukuran '$inputName' terlalu besar (maksimal: " . (string)round((float)$maxSize / 1000000, 2) . "MB"]);
        die;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimetype = $finfo->file($filename);
    if(!$mimetype) {
        http_response_code(400);
        echo json_encode(["message" => "Gagal membaca MIMETYPE dari '$inputName'"]);
        die;
    }
    if(!in_array($mimetype, $mimetypes)) {
        http_response_code(400);
        echo json_encode(["message" => "File harus berupa format: " . implode(", ", $mimetypes)]);
        die;
    }
}

function isFileUploaded(string $inputName) {
    if(empty($_FILES)) return false;
    $tmpName = $_FILES[$inputName]["tmp_name"];
    if($_FILES[$inputName]["error"] === UPLOAD_ERR_NO_FILE) return false;
    if(!file_exists($tmpName) || !is_uploaded_file($tmpName)) return false;
    return true;
}

function moveUploadedFile(string $inputName, string $directory, $target = "") {
    $fileTmpPath = $_FILES[$inputName]["tmp_name"];
    $ext = pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION);
    $actualTarget = empty($target) ? bin2hex(random_bytes(16)) . ".$ext" : $target;
    $targetFilePath = $directory . $actualTarget;
    $result = move_uploaded_file($fileTmpPath, $targetFilePath);
    if(!$result) throw new Exception("Gagal memindahkan file yang telah diupload");
    return $actualTarget;
}

function dd(mixed ...$vars) {
    var_dump(...$vars);
    die;
}

function getValidPageArg() {
    $page = trim($_GET["page"] ?? "1");
    if(!ctype_digit($page)) redirectBack();
    $page = intval($page);
    if($page <= 0) redirectBack();
    return $page;
}

function env(string $name, $default = '') {
    return Config::getEnv($name, $default);
}

function getUploadDirPath() {
    return Config::getUploadDirPath();
}

