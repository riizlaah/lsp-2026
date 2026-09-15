<?php

namespace App\Models;

use App\Model;

class Article extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "articles";
    protected static $fillable = ['userId', 'categoryId' ,'slug', 'title', 'content', 'isReleased', 'createdAt', 'updatedAt'];
    protected static $relationships = [
        'user' => [Model::HAS_ONE, User::class, 'id', 'userId'],
        'articleAttachments' => [Model::HAS_MANY, ArticleAttachment::class, 'articleId', 'id']
    ];
}