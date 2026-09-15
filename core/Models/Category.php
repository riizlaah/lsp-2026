<?php

namespace App\Models;

use App\Model;

class Category extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "categories";
    protected static $fillable = ['name', 'description',];
    protected static $relationships = [
        'articles' => [Model::HAS_MANY, Article::class, 'categoryId', 'id'],
    ];
}