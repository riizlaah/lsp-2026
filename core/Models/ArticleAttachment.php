<?php

namespace App\Models;

use App\Model;

class ArticleAttachment extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "articlesAttachments";
    protected static $fillable = ['articleId', 'name', 'type', 'url'];
    protected static $relationships = [
        'article' => [Model::HAS_ONE, Article::class, 'id', 'articleId'],
    ];
}