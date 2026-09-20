<?php

namespace App\Models;

use App\Model;

class TmpFile extends Model
{
    protected static $guarded = ['id'];
    protected static $tableName = "tmp_files";
    protected static $fillable = ['filename', 'createdAt'];
    protected static $relationships = [];

    public static function freeTmpFilesFromContent(string $content)
    {
        $files = getFilenamesFromHTMLContent($content);

        if (!empty($files)) {
            static::whereIn('filename', $files)->delete();
        }

        return $files;
    }
}
