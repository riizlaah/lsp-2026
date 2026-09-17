<?php

namespace App;

use HTMLPurifier_Config;

class Config
{
    public static $properties = [];

    public static function loadEnv()
    {
        $content = trim(file_get_contents(__DIR__ . "/.env"));
        $content = str_replace("\r\n", "\n", $content);
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            preg_match("/(.*)=(.*)/", $line, $matches);
            self::$properties[trim($matches[1])] = trim($matches[2]);
        }
        static::postLoadEnv();
    }

    private static function postLoadEnv() {
        date_default_timezone_set('Asia/Jakarta');
    }

    public static function get(string $name, $default = '')
    {
        if (!isset(self::$properties[$name])) return $default;
        return self::$properties[$name];
    }

    public static function getUploadDirPath()
    {
        return dirname(__DIR__) . "/assets/uploads/";
    }

    public static function getHTMLPurifierConf()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,i,u,strong,del,pre,em,ul,ol,li,br,a[href|title],img[src|alt|width|height],figure[data-trix-attributes|data-trix-attachment],figcaption,div,blockquote');
        $config->set('HTML.TargetBlank', true); // Membuka tautan di tab baru
        $config->set('HTML.Nofollow', true);    // Menambahkan rel="nofollow"
        $config->set('HTML.TargetNoreferrer', true);
        $config->set('HTML.TargetNoopener', true);
        return $config;
    }
}
