<?php

namespace App\Models;

use App\Model;

class Category extends Model {
    public const TYPE_PUBLICATION = 1;
    public const TYPE_GENERAL_ACT = 2;
    public const TYPE_STUDENT_ACT = 3;
    protected static $guarded = ['id'];
    protected static $tableName = "categories";
    protected static $fillable = ['name', 'description',];
    protected static $relationships = [
        'articles' => [Model::HAS_MANY, Article::class, 'categoryId', 'id'],
    ];
}