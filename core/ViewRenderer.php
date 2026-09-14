<?php

namespace App;

use Throwable;
use Exception;

class ViewRenderer
{
    private static string $cachePath = __DIR__ . "/cache/";
    private static string $viewPath = __DIR__ . "/views/";
    private static string $componentsPath = __DIR__ . "/views/components/";
    private static string $placeholder = "<!-- SLOT_PLACEHOLDER -->";
    private const array OTHER_ELEMENTS = [
        "/<xm-([a-z]+)\s*\/>/" => ["<input type=\"hidden\" name=\"_method\" value=\"$1\">"],
        "/<xcsrf\s*\/>/" => ["<input type=\"hidden\" name=\"_csrf_token\" value=\"<?= generateCSRFToken() ?>\">"],
        "/@old\('(.*?)'\s*,\s*(.*?)\)/" => ["<?= old('$1') ?? $2 ?>", ["\$_SESSION['_flash']['oldInput'] = [];"]],
        "/@old\('(.*?)'\)/" => ["<?= old('$1') ?>", ["\$_SESSION['_flash']['oldInput'] = [];"]],
        "/@err\('(.*?)'\)\s*(.*?)\s*@enderr/s" => ["<?php \$$1 = err('$1'); if(!empty(\$$1)): ?>$2<?php endif; ?>", ["unset(\$_SESSION['_errors']);"]],
        "/@err\s*(.*?)\s*@enderr/s" => ["<?php \$errors = err(); if(!empty(\$errors)): ?>$1<?php endif; ?>", ["unset(\$_SESSION['_errors']);"]],
    ];

    public static function loadView(string $name, array $data)
    {
        $viewFile = self::$viewPath . str_replace(".", "/", $name) . ".php";
        if (!file_exists($viewFile)) {
            echo "view \"$name\" not found.";
            die;
        }
        $cachedFile = self::$cachePath . md5($name) . ".php";
        if (self::needRebuild($viewFile, $cachedFile)) {
            $content = file_get_contents($viewFile);
            $content = self::renderView($content);
            file_put_contents($cachedFile, $content);
        }
        extract($data);
        try {
            ob_start();
            require $cachedFile;
            ob_flush();
        } catch (Throwable $e) {
            throw new Exception("Error rendering view '$name': " . $e->getMessage());
        }
    }

    private static function needRebuild(string $viewFile, string $cachedFile)
    {
        if (!file_exists($cachedFile)) return true;

        $cacheTime = filemtime($cachedFile);
        if (filemtime($viewFile) > $cacheTime) return true;

        $componentFiles = glob(self::$componentsPath . "*.php");
        foreach ($componentFiles as $compFile) {
            if (filemtime($compFile) > $cacheTime) return true;
        }
        return false;
    }

    private static function getComponentContent(string $name)
    {
        if (!preg_match("/^[a-zA-Z0-9\._-]+$/", $name)) throw new Exception("Component not found.");
        $componentPath = realpath(self::$componentsPath . str_replace(".", "/", $name) . ".php");
        $baseDir = realpath(self::$componentsPath);
        if (!$componentPath or strpos($componentPath, $baseDir) !== 0) {
            throw new Exception("Component '$componentPath' not found or invalid path.");
        }
        $content = file_get_contents($componentPath);
        if (!$content) throw new Exception("Failed to read '$componentPath'.");
        if (substr_count($content, self::$placeholder) != 1) {
            throw new Exception("Component '$componentPath' must contain only one slot.");
        }
        return $content;
    }

    private static function renderView(string $content)
    {
        // matches[1] = component name, matches[2] = the content
        $pattern = "/<x-([a-zA-Z0-9._]+)>(.*?)<\/x-\g1>/s";
        $pattern2 = "/<x-([a-zA-Z0-9._]+)\s*\/>/";
        $maxIteration = 32;
        $placeholder = self::$placeholder;
        $prefixContent = [];
        $suffixContent = [];
        for ($i = 0; $i < $maxIteration; $i++) {
            $newContent = preg_replace_callback($pattern, function ($matches) use ($placeholder) {
                $componentContent = self::getComponentContent($matches[1]);
                return str_replace($placeholder, $matches[2], $componentContent);
            }, $content);
            $newContent = preg_replace_callback($pattern2, function ($matches) {
                return self::getComponentContent($matches[1]);
            }, $newContent);
            foreach (self::OTHER_ELEMENTS as $pattern3 => $data) {
                $replace = $data[0];
                $suffixes = $data[1] ?? [];
                $prefixes = $data[2] ?? [];
                if (!empty($suffixes)) $suffixContent = array_merge($suffixContent, $suffixes);
                if (!empty($prefixes)) $prefixContent = array_merge($prefixContent, $prefixes);
                $newContent = preg_replace($pattern3, $replace, $newContent);
            }
            if ($newContent === $content) break;
            $content = $newContent;
        }
        if (!empty($prefixContent)) {
            $actions = "<?php";
            $prefixContent = array_unique($prefixContent);
            foreach ($prefixContent as $action) $actions .= "\n$action";
            $actions .= "\n?>";
            $content = $actions . $content;
        }
        if (!empty($suffixContent)) {
            $actions = "<?php";
            $suffixContent = array_unique($suffixContent);
            foreach ($suffixContent as $action) $actions .= "\n$action";
            $actions .= "\n?>";
            $content = $content . $actions;
        }
        return $content;
    }
}
