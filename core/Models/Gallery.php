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

    public static function generateGaleries(string $refTable, int $refId, array $images)
    {
        if (empty($images)) return;
        $first = true;
        $data = [];
        foreach ($images as $img) {
            $data[] = [
                "refTable" => $refTable,
                "refId" => $refId,
                "mediaPath" => $img,
                "isCover" => $first
            ];
            if ($first) $first = false;
        }
        static::addMany($data);
    }

    public static function syncGaleries(string $refTable, int $refId, array $images)
    {
        $existingGalleries = static::byRef($refTable, $refId)->getAll();
        $existingFiles = [];
        foreach ($existingGalleries as $galleryItem) $existingFiles[] = $galleryItem->mediaPath;
        if (empty($images)) {
            static::byRef($refTable, $refId)->delete();
            foreach ($existingFiles as $file) {
                safeUnlink(Config::getUploadDirPath() . $file);
            }
            return;
        }
        $data = [];
        $toRemove = [];
        foreach ($existingFiles as $file) {
            if (in_array($file, $images)) continue;
            $toRemove[] = $file;
        }
        if (!empty($toRemove)) {
            static::byRef($refTable, $refId)->whereIn('mediaPath', $toRemove)->delete();
            foreach ($toRemove as $file) {
                safeUnlink(Config::getUploadDirPath() . $file);
            }
        }
        foreach ($images as $img) {
            if (in_array($img, $existingFiles)) continue;
            $data[] = [
                "refTable" => $refTable,
                "refId" => $refId,
                "mediaPath" => $img,
                "isCover" => false
            ];
        }
        if (!empty($data)) static::addMany($data);
        if(!static::byRef($refTable, $refId)->where('isCover', true)->any()) {
            $first = static::byRef($refTable, $refId)->where('mediaPath', $images[0]);
            static::where('id', $first->id)->update(["isCover" => true]);
            safeUnlink(Config::getUploadDirPath() . $first->mediaPath);
        }
    }

    public static function byRef(string $refTable, int $refId) {
        return static::where('refTable', $refTable)->where('refId', $refId);
    }
}
