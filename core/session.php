<?php

class Session {
    

    public static function flash(string $name, mixed $value = null) {
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

    public static function destroy() {
        $_SESSION = [];
        session_destroy();
        session_regenerate_id();
    }
}