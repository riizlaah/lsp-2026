<?php

namespace App\Models;

use App\Model;

class AnnouncementAttachment extends Model {
    protected static $guarded = ['id'];
    protected static $tableName = "announcementsAttachments";
    protected static $fillable = ['announcementId', 'name', 'type', 'url'];
    protected static $relationships = [
        'announcement' => [Model::HAS_ONE, Article::class, 'id', 'announcementId'],
    ];
}