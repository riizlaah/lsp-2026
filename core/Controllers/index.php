<?php
namespace App\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;

class index {
    public function index() {
        $now = Carbon::now()->toDateTimeString();
        $announcement = Announcement::where('publishedAt', $now, "<=")->where('expiredAt', $now, ">=")->orderBy('publishedAt')->first();
        $activities = Article::with(["category"])->where('categoryId', Category::TYPE_PUBLICATION, "!=")->orderBy('createdAt')->limit(3)->getAll();
        $exception = array_map(fn($item) => $item->id, $activities);
        $articles = Article::whereNotIn('id', $exception)->getAll();
        view('index', ['title' => 'Index', 'activities' => $activities, 'announcement' => $announcement, 'articles' => $articles]);
    }
}