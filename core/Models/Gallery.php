<?php

namespace App\Models;

use App\Config;
use App\Model;

class Gallery extends Model
{
    protected static $guarded = ['id'];
    protected static $tableName = "galeries";
    protected static $fillable = ['refTable', 'refId', 'isCover', 'mediaPath', 'description', 'createdAt'];
    protected static $relationships = [];

    public static function generateGaleries(string $tableRef, int $refId, array $images)
    {
        if (empty($images)) return;
        $first = true;
        $data = [];
        foreach ($images as $img) {
            $data[] = [
                "refTable" => $tableRef,
                "refId" => $refId,
                "mediaPath" => $img,
                "isCover" => $first
            ];
            if ($first) $first = false;
        }
        static::addMany($data);
    }

    public static function syncGaleries(string $tableRef, int $refId, array $images)
    {
        if (empty($images)) {
            static::where('refTable', $tableRef)->where('refId', $refId)->delete();
            return;
        }
        $existingGalleries = static::where('refTable', $tableRef)->where('refId', $refId)->getAll();
        $existingFiles = [];
        foreach ($existingGalleries as $file) $existingFiles[] = $file;
        $data = [];
        $toRemove = [];
        foreach ($existingFiles as $file) {
            if (in_array($file, $images)) continue;
            $toRemove[] = $file;
        }
        if (!empty($toRemove)) {
            static::where('refTable', $tableRef)->where('refId', $refId)->whereIn('filename', $toRemove)->delete();
            foreach ($toRemove as $file) {
                safeUnlink(Config::getUploadDirPath() . $file);
            }
        }
        foreach ($images as $img) {
            if (in_array($img, $existingFiles)) continue;
            $data[] = [
                "refTable" => $tableRef,
                "refId" => $refId,
                "mediaPath" => $img,
                "isCover" => false
            ];
        }
        if (!empty($data)) static::addMany($data);
    }
}
