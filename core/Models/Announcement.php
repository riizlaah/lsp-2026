<?php

namespace App\Models;

use App\Model;

class Announcement extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "announcements";
    protected static $fillable = ['userId' ,'slug', 'title', 'content', 'publishedAt', 'expiredAt', 'createdAt', 'updatedAt'];
    protected static $relationships = [
        'user' => [Model::HAS_ONE, User::class, 'id', 'userId'],
        'announcementAttachments' => [Model::HAS_MANY, AnnouncementAttachment::class, 'announcementId', 'id']
    ];
}