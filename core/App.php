<?php
namespace App;

use App\Models\TmpFile;
use Carbon\Carbon;

require __DIR__ . "/CoreFunctions.php";
require __DIR__ . "/Helper.php";



class App {
    public function __construct() {
        Config::init();
        Model::initDB();
    }

    public function run(string $route) {
        $route = filter_var($route, FILTER_SANITIZE_URL);
        $parts = explode('/', $route);
        array_shift($parts);
        if(empty($parts[0])) {
            $parts[0] = 'index';
        }
        $parts[0] = str_replace("-", "_", $parts[0]);
        $controllerPath = __DIR__."/Controllers/".$parts[0].".php";
        if(!file_exists($controllerPath)) {
            errCode(404, "Tidak ditemukan");
        }
        $className = "\App\\Controllers\\".$parts[0];
        $controller = new $className();
        if(empty($parts[1])) $parts[1] = 'index';
        $methodName = str_replace("-", "_", $parts[1]);
        $reqMethod = strtolower($_POST["_method"] ?? $_SERVER["REQUEST_METHOD"]);
        if($reqMethod != "get") {
            if(strtolower($methodName) === $reqMethod || $methodName === 'index') $methodName = "_" . $reqMethod;
            else $methodName .= "_$reqMethod";
        }
        if(!method_exists($controller, $methodName)) {
            errCode(404, "Tidak ditemukan");
        }
        if(in_array($reqMethod, ["post", "put", "patch", "delete"])) {
            if(!validateCSRFToken()) {
                if($_SERVER["HTTP_ACCEPT"] == "application/json") {
                    header("Content-Type: application/json");
                    echo json_encode(["message" => "CSRF Token mismatch"]);
                    die;
                }
                errCode(419, "Halaman sudah basi");
            }
            foreach(array_merge($_GET, $_POST) as $key => $value) {
                if(in_array($key, ["_method", "_csrf_token"])) continue;
                $_SESSION["_flash"]["oldInput"][$key] = $value;
            }
        }
        $args = [];
        if(count($parts) > 2) $args = array_slice($parts, 2);
        // $clippedRoute = $route;
        $GLOBALS['clippedRoute'] = $route;
        $this->beforeAction();
        call_user_func_array([$controller, $methodName], $args);
        $this->afterAction();
    }

    public function beforeAction() {
        $now = Carbon::now();
        if(!isset($_SESSION['lastAction'])) $_SESSION['lastAction'] = $now->toDateTimeString();
        $lastAction = Carbon::parse($_SESSION['lastAction']);
        if($lastAction->diffInMinutes($now) > 59) {
            $files = TmpFile::where('createdAt', $now->toDateTimeString(), '<')->getAll();
            if(!empty($files)) {
                $ids = [];
                foreach($files as $file) {
                    $hourDiff = Carbon::parse($file->createdAt)->diffInHours(Carbon::now());
                    if($hourDiff > 0.9) {
                        $filepath = getUploadDirPath() . $file->filename;
                        safeUnlink($filepath);
                        $ids[] = $file->id;
                    }
                }
                if(!empty($ids)) TmpFile::whereIn('id', $ids)->delete();
            }
            $_SESSION['lastAction'] = $now->toDateTimeString();
        }
    }

    public function afterAction() {}
}