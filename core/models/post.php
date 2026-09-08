<?php



class Post extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "posts";
    protected static $fillable = ['title', 'userId', 'content', 'updatedAt', 'createdAt'];
    protected static $relationships = [
        'user' => [Model::HAS_ONE, User::class, 'id', 'userId']
    ];
}