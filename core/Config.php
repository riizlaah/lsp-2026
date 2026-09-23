<?php

namespace App;

class Config
{
    public static $envVars = [];
    public static $properties = [];

    public static function init() {
        self::loadEnv();
        self::loadConf();
    }

    public static function loadEnv()
    {
        $content = trim(file_get_contents(__DIR__ . "/.env"));
        $content = str_replace("\r\n", "\n", $content);
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            preg_match("/(.*)=(.*)/", $line, $matches);
            self::$envVars[trim($matches[1])] = trim($matches[2]);
        }
        static::postLoadEnv();
    }

    public static function loadConf()
    {
        $content = trim(file_get_contents(__DIR__ . "/app.conf"));
        $content = str_replace("\r\n", "\n", $content);
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            preg_match("/(.*?)=(.*)/", $line, $matches);
            self::$properties[trim($matches[1])] = trim($matches[2]);
        }
    }

    private static function postLoadEnv()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public static function getEnv(string $name, $default = '')
    {
        if (!isset(self::$envVars[$name])) return $default;
        return self::$envVars[$name];
    }

    public static function get(string $name, $default = '')
    {
        if (!isset(self::$properties[$name])) return $default;
        return self::$properties[$name];
    }

    public static function getAll()
    {
        return self::$properties;
    }

    public static function override(array $setting)
    {
        self::$properties = $setting;
    }

    public static function set(string $name, string $value)
    {
        if (!isset(self::$properties[$name])) return;
        self::$properties[$name] = $value;
    }

    public static function save() {
        $content = "";
        foreach(self::$properties as $key => $value) {
            $content .= $key . "=" . $value . "\n";
        }
        $content = trim($content);
        file_put_contents(__DIR__ . "/app.conf", $content);
    }

    public static function getUploadDirPath()
    {
        return dirname(__DIR__) . "/assets/uploads/";
    }
}
