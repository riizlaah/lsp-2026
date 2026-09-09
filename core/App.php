<?php
namespace App;

require __DIR__ . "/RequiredFunctions.php";
require __DIR__ . "/Helper.php";



class App {
    public function __construct() {
        Config::loadEnv();
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
        $controllerPath = __DIR__."/controllers/".$parts[0].".php";
        if(!file_exists($controllerPath)) {
            errCode(404, "Tidak ditemukan");
        }
        require $controllerPath;
        $controller = new $parts[0]();
        if(empty($parts[1])) $parts[1] = 'index';
        $methodName = str_replace("-", "_", $parts[1]);
        $reqMethod = strtolower($_POST["_method"] ?? $_SERVER["REQUEST_METHOD"]);
        if($reqMethod != "get") {
            if(strtolower($methodName) != $reqMethod) $methodName .= "_$reqMethod";
            else $methodName = $reqMethod . "_";
        }
        if(!method_exists($controller, $methodName)) {
            errCode(404, "Tidak ditemukan");
        }
        if(in_array($reqMethod, ["post", "put", "patch", "delete"])) {
            if(!validateCSRFToken()) {
                var_dump("csrf failed");
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
        call_user_func_array([$controller, $methodName], $args);
    }
}