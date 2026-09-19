<?php

namespace App\Models;

use App\Model;

class Article extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "articles";
    protected static $fillable = ['userId', 'categoryId' ,'slug', 'headerImage', 'title', 'content', 'isReleased', 'createdAt', 'updatedAt'];
    protected static $relationships = [
        'user' => [Model::HAS_ONE, User::class, 'id', 'userId'],
        'category' => [Model::HAS_ONE, Category::class, 'id', 'categoryId'],
    ];
}