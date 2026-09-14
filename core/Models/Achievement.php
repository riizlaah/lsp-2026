<?php

namespace App\Models;

use App\Model;

class Achievement extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "achievements";
    protected static $fillable = ['title', 'userId', 'level', 'rank', 'content', 'isTiered', 'year', 'month'];
    protected static $relationships = [
        'user' => [Model::HAS_ONE, User::class, 'id', 'userId']
    ];
}