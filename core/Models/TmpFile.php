<?php

namespace App\Models;

use App\Model;

class TmpFile extends Model
{
    protected static $guarded = ['id'];
    protected static $tableName = "tmp_files";
    protected static $fillable = ['filename', 'createdAt'];
    protected static $relationships = [];

    public static function freeTmpFilesFromContent(string $content, $imgOnly = true)
    {
        $files = getFilenamesFromHTMLContent($content);

        if (!empty($files)) {
            static::whereIn('filename', $files)->delete();
        }
        if($imgOnly) {
            $images = [];
            $allowed = ["png", "jpg", "jpeg", "webp"];
            foreach($files as $file) {
                if(in_array(pathinfo($file, PATHINFO_EXTENSION), $allowed)) $images[] = $file;
            }
            return $images;
        }

        return $files;
    }
}
