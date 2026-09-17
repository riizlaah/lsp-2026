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
        if (empty($images)) {
            static::where('refTable', $refTable)->where('refId', $refId)->delete();
            return;
        }
        $existingGalleries = static::where('refTable', $refTable)->where('refId', $refId)->getAll();
        $existingFiles = [];
        foreach ($existingGalleries as $file) $existingFiles[] = $file;
        $data = [];
        $toRemove = [];
        foreach ($existingFiles as $file) {
            if (in_array($file, $images)) continue;
            $toRemove[] = $file;
        }
        if (!empty($toRemove)) {
            static::where('refTable', $refTable)->where('refId', $refId)->whereIn('mediaPath', $toRemove)->delete();
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
        if($existingFiles[0] !== $images[0]) {
            $first = static::where('refTable', $refTable)->where('refId', $refId)->first();
            static::where('id', $first->id)->delete();
            safeUnlink(Config::getUploadDirPath() . $first->mediaPath);
        }
    }
}
