<?php

namespace App\Models;

use App\Model;

class TmpFile extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "tmp_files";
    protected static $fillable = ['filename', 'createdAt'];
    protected static $relationships = [];
}