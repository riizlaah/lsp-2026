<?php

namespace App\Models;

use App\Model;

class User extends Model {
    protected static $tableName = "users";
    protected static $guarded = ['id'];
    protected static $fillable = ['username', 'password', 'fullName', 'email', 'role'];
    protected static $relationships = [
        'posts' => [Model::HAS_MANY, Post::class, 'userId', 'id']
    ];
}