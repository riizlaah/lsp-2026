<?php

class Config {
    public static $properties = [];

    public static function loadEnv() {
        $content = trim(file_get_contents(__DIR__."/.env"));
        $content = str_replace("\r\n", "\n", $content);
        $lines = explode("\n", $content);
        foreach($lines as $line) {
            preg_match("/(.*)=(.*)/", $line, $matches);
            self::$properties[trim($matches[1])] = trim($matches[2]);
        }
    }

    public static function get(string $name, $default = '') {
        if(!isset(self::$properties[$name])) return $default;
        return self::$properties[$name];
    }
}