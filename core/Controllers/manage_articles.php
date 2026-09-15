<?php
namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleAttachment;
use App\Models\Category;

class manage_articles {
    public function index() {
        $search = trim($_GET["search"]) ?? "";
        $records = [];
        if(!empty($search)) {
            $records = Article::where('title', "%$search%", "LIKE")->getAll();
        } else {
            $records = Article::getAll();
        }
        ensureIsAdmin();
        view("dashboard.articles.index", ["title" => "Kelola Artikel", "records" => $records]);
    }

    public function create() {
        ensureIsAdmin();
        $categories = Category::getAll();
        view("dashboard.articles.create", ["title" => "Tambah Artikel", "useTrix" => true, "categories" => $categories]);
    }

    public function edit($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-articles");
        $record = Article::where('id', $actualId)->first();
        if(!$record) errCode(404, "Artikel tidak ditemukan");
        view("dashboard.articles.edit", ["title" => "Edit Artikel", "record" => $record, "useTrix" => true]);
    }

    public function edit_put($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-articles");
        ensureInputFilled($_POST, ["nama", "rank", "tingkat", "berjenjang", "konten", "tahun", "bulan"]);
        $name = sanitizeInput("nama");
        $rank = sanitizeInput("rank");
        $level = sanitizeInput("tingkat");
        $isTiered = sanitizeInput("berjenjang");
        $content = sanitizeInput("konten");
        $year = sanitizeInput("tahun");
        $month = sanitizeInput("bulan");
        if(!ctype_digit($rank) || intval($rank) < 0) redirectBackWithErrors(["rank" => ["Rank tidak valid"]]);
        if(!in_array($level, ["Tidak diketahui","Kecamatan","Kabupaten","Provinsi","Nasional","Internasional"]))
            redirectBackWithErrors(["tingkat" => ["Tingkat tidak valid"]]);
        if(!in_array($isTiered, ["t", "f"])) redirectBackWithErrors(["berjenjang" => ["Opsi berjenjang tidak valid"]]);
        if(!ctype_digit($year) || intval($year) <= 0) redirectBackWithErrors(["tahun" => ["Tahun tidak valid"]]);
        if(!ctype_digit($month) || intval($month) <= 0) redirectBackWithErrors(["bulan" => ["Bulan tidak valid"]]);
        if(!Article::where('id', $actualId)->any()) errCode(404, "Artikel tidak ditemukan");
        Article::where('id', $actualId)->update([
            "title" => $name,
            "rank" => intval($rank),
            "level" => $level,
            "isTiered" => $isTiered == "t" ? true : false,
            "content" => $content,
            "year" => intval($year),
            "month" => intval($month)
        ]);
        session_flash('message', "Berhasil mengubah Artikel!");
        redirect('/manage-articles');
    }

    public function create_post() {
        ensureIsAdmin();
        ensureInputFilled($_POST, ["nama", "rank", "tingkat", "berjenjang", "konten", "tahun", "bulan"]);
        $name = sanitizeInput("nama");
        $rank = sanitizeInput("rank");
        $level = sanitizeInput("tingkat");
        $isTiered = sanitizeInput("berjenjang");
        $content = sanitizeInput("konten");
        $year = sanitizeInput("tahun");
        $month = sanitizeInput("bulan");
        if(!ctype_digit($rank) || intval($rank) < 0) redirectBackWithErrors(["rank" => ["Rank tidak valid"]]);
        if(!in_array($level, ["Tidak diketahui","Kecamatan","Kabupaten","Provinsi","Nasional","Internasional"]))
            redirectBackWithErrors(["tingkat" => ["Tingkat tidak valid"]]);
        if(!in_array($isTiered, ["t", "f"])) redirectBackWithErrors(["berjenjang" => ["Opsi berjenjang tidak valid"]]);
        if(!ctype_digit($year) || intval($year) <= 0) redirectBackWithErrors(["tahun" => ["Tahun tidak valid"]]);
        if(!ctype_digit($month) || intval($month) <= 0) redirectBackWithErrors(["bulan" => ["Bulan tidak valid"]]);
        $userId = getAuthData()["id"];
        Article::add([
            "userId" => $userId,
            "title" => $name,
            "rank" => intval($rank),
            "level" => $level,
            "isTiered" => $isTiered == "t" ? true : false,
            "content" => $content,
            "year" => intval($year),
            "month" => intval($month)
        ]);
        session_flash("message", "Artikel ditambahkan!");
        redirect('/manage-articles');
    }

    public function _delete($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-articles");
        if(!Article::where('id', $actualId)->any()) redirect('/manage-articles');
        Article::where('id', $actualId)->delete();
        session_flash('message', "Berhasil menghapus Artikel!");
        redirect('/manage-articles');
    }

    public function generate_slug() {
        ensureIsAdmin();
        $title = trim($_GET["title"]) ?? "";
        header("Content-Type: application/json");
        if(empty($title)) {
            http_response_code(400);
            echo json_encode(["message" => "Judul wajib ada", "slug" => ""]);
            exit;
        }
        $slug = preg_replace("/[^a-z0-9\-]/", "-", strtolower($title));
        $slug = preg_replace("/\-+/", "-", $slug);
        for($i = 0; $i < 32; $i++) {
            $duplicateCount = Article::where('slug', $slug)->count();
            if($duplicateCount === 0) break;
            $slug = $slug . (string)$duplicateCount;
        }
        if(Article::where('slug', $slug)->count() > 0) {
            http_response_code(429);
            echo json_encode(["message" => "Failed to generate unique slug", "slug" => ""]);
        } else {
            echo json_encode(["slug" => $slug]);
        }
    }
}