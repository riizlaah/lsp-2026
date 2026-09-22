<?php

namespace App\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use Carbon\Carbon;

class information
{
    public function index()
    {
        $now = Carbon::now()->toDateTimeString();
        $articles = Article::with(["category"])->where('isReleased', true)->orderBy('createdAt')->limit(4)->getAll();
        $announcements = Announcement::where('publishedAt', $now, "<=")->where('expiredAt', $now, ">=")->orderBy('publishedAt')->limit(4)->getAll();
        view("information", ["title" => "Informasi & Berita", "articles" => $articles, "announcements" => $announcements]);
    }

    public function articles($slug = "")
    {
        if (empty(trim($slug))) {
            $search = trim($_GET["search"] ?? "");
            $query = Article::with(["category"])->where('isReleased', true)->orderBy('createdAt');
            if (!empty($search)) $query = $query->where('title', "%$search%", "LIKE")->getAll();
            $records = $query->paginate(getValidPageArg());
            view('articles', ["title" => "Artikel", "records" => $records["rows"], "page" => $records["page"], "maxPage" => $records["maxPage"], "items" => $records["items"]]);
        } else {
            $query = Article::with(["category"])->where('slug', $slug);
            if (!isLoggedIn()) $query = $query->where('isReleased', true);
            $record = $query->first();
            if (!$record) redirectBack();
            view("article-detail", ["title" => "Detail Artikel", "record" => $record]);
        }
    }

    public function announcements($slug = "")
    {
        if (empty(trim($slug))) {
            $search = trim($_GET["search"] ?? "");
            $records = [];
            $now = Carbon::now()->toDateTimeString();
            $query = Announcement::where('publishedAt', $now, "<=")->where('expiredAt', $now, ">=")->orderBy('publishedAt');
            if (!empty($search)) $records = $query->where('title', "%$search%", "LIKE")->getAll();
            else $records = $query->paginate(getValidPageArg());
            view('announcements', ["title" => "Pengumuman", "records" => $records["rows"], "page" => $records["page"], "maxPage" => $records["maxPage"], $records["items"]]);
        } else {
            $now = Carbon::now()->toDateTimeString();
            $query = Announcement::where('slug', $slug);
            if (!isLoggedIn()) $query = $query->where('publishedAt', $now, "<=")->where('expiredAt', $now, ">=");
            $record = $query->first();
            if (!$record) redirectBack();
            view("announcement-detail", ["title" => "Detail Pengumuman", "record" => $record]);
        }
    }
}
