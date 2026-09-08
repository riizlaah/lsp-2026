<?php

require __DIR__ . "/post.php";

class User extends Model {
    protected static $tableName = "users";
    protected static $guarded = ['id'];
    protected static $fillable = ['username', 'password', 'fullName', 'email', 'role'];
    protected static $relationships = [
        'posts' => [Model::HAS_MANY, Post::class, 'userId', 'id']
    ];
}