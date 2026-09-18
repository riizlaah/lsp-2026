<?php

namespace App\Controllers;

use App\Config;
use App\Model;
use App\Models\Article;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\TmpFile;
use Exception;

class manage_articles
{
    public function index()
    {
        $search = trim($_GET["search"]) ?? "";
        $records = [];
        if (!empty($search)) {
            $records = Article::where('title', "%$search%", "LIKE")->getAll();
        } else {
            $records = Article::getAll();
        }
        ensureIsAdmin();
        view("dashboard.articles.index", ["title" => "Kelola Artikel", "records" => $records]);
    }

    public function create()
    {
        ensureIsAdmin();
        $categories = Category::getAll();
        view("dashboard.articles.create", ["title" => "Tambah Artikel", "useTrix" => true, "categories" => $categories]);
    }

    public function edit($id = "")
    {
        ensureIsAdmin();
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-articles");
        $record = Article::where('id', $actualId)->first();
        if (!$record) errCode(404, "Artikel tidak ditemukan");
        $categories = Category::getAll();
        view("dashboard.articles.edit", ["title" => "Edit Artikel", "record" => $record, "categories" => $categories, "useTrix" => true]);
    }

    public function edit_put($id = "")
    {
        $content = sanitizeHTML(trim($_POST["konten"] ?? ""));
        $_SESSION["_flash"]["oldInput"]["konten"] = $content;
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "slug", "kategori", "konten", "status"]);
        if (isFileUploaded("gambarTajuk")) ensureImageValid("gambarTajuk");
        $title = sanitizeInput("judul");
        $slug = sanitizeInput("slug");
        $categoryId = intval(sanitizeInput("kategori"));
        $status = sanitizeInput("status");
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-articles");
        $record = Article::where('id', $actualId)->first();
        if (!$record) errCode(404, "Artikel tidak ditemukan");
        if (Article::where('slug', $slug)->where('id', $actualId, "!=")->any()) redirectBackWithError("slug", ["Slug sudah terpakai"]);
        if (!Category::where('id', $categoryId)->any()) redirectBackWithError("kategori", ["Kategori invalid"]);
        if (!in_array($status, ["d", "r"])) redirectBackWithError("status", ["Opsi status invalid"]);
        try {
            Model::beginTransaction();
            $imgPath = (isFileUploaded("gambarTajuk")) ? moveUploadedFile("gambarTajuk", Config::getUploadDirPath()) : $record->headerImage;
            $images = $this->updateTmpFilesIfExists($content);
            array_unshift($images, $imgPath);
            Article::where('id', $actualId)->update([
                "categoryId" => $categoryId,
                "title" => $title,
                "slug" => $slug,
                "headerImage" => $imgPath,
                "content" => $content,
                "isReleased" => $status == "r"
            ]);
            // if ($actualId == 0) throw new Exception("Gagal mendapatkan ID dari artikel yang dibuat");
            Gallery::syncGaleries("articles", $actualId, $images);
            Model::commit();
            session_flash("message", "Artikel berhasil diupdate!");
            redirect('/manage-articles');
        } catch (Exception $e) {
            redirectBackWithError("", ["Gagal mengupdate artikel: " . $e->getMessage()]);
            Model::rollback();
            foreach ($images as $img) safeUnlink(Config::getUploadDirPath() . $img);
        }
    }

    public function create_post()
    {
        $content = sanitizeHTML(trim($_POST["konten"] ?? ""));
        $_SESSION["_flash"]["oldInput"]["konten"] = $content;
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "slug", "kategori", "konten", "status"]);
        ensureImageValid("gambarTajuk");
        $title = sanitizeInput("judul");
        $slug = sanitizeInput("slug");
        $categoryId = intval(sanitizeInput("kategori"));
        $status = sanitizeInput("status");
        if(empty($content)) redirectBackWithError("konten", ["Konten wajib diisi"]);
        if (Article::where('slug', $slug)->any()) redirectBackWithError("slug", ["Slug sudah terpakai"]);
        if (!Category::where('id', $categoryId)->any()) redirectBackWithError("kategori", ["Kategori invalid"]);
        if (!in_array($status, ["d", "r"])) redirectBackWithError("status", ["Opsi status invalid"]);
        try {
            Model::beginTransaction();
            $imgPath = moveUploadedFile("gambarTajuk", Config::getUploadDirPath());
            $images = $this->updateTmpFilesIfExists($content);
            array_unshift($images, $imgPath);
            $userId = getAuthData()["id"];
            $articleId = Article::add([
                "userId" => $userId,
                "categoryId" => $categoryId,
                "title" => $title,
                "slug" => $slug,
                "headerImage" => $imgPath,
                "content" => $content,
                "isReleased" => $status == "r"
            ]);
            if ($articleId == 0) throw new Exception("Gagal mendapatkan ID dari artikel yang dibuat");
            Gallery::generateGaleries("articles", $articleId, $images);
            Model::commit();
            session_flash("message", "Artikel ditambahkan!");
            redirect('/manage-articles');
        } catch (Exception $e) {
            redirectBackWithError("", ["Gagal membuat artikel: " . $e->getTraceAsString()]);
            Model::rollback();
            foreach ($images as $img) safeUnlink(Config::getUploadDirPath() . $img);
        }
    }

    private function updateTmpFilesIfExists(string $content)
    {
        preg_match_all("/<img\s*.*src=\"(.*?)\".*?>/", $content, $matches);
        $files = [];
        if (isset($matches[1]) && !empty($matches[1])) {
            foreach ($matches[1] as $match) {
                $parts = explode("/", trim($match, "/ "));
                $files[] = $parts[count($parts) - 1];
            }
            TmpFile::whereIn('filename', $files)->delete();
        }
        return $files;
    }

    public function _delete($id = "")
    {
        ensureIsAdmin();
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-articles");
        if (!Article::where('id', $actualId)->any()) redirect('/manage-articles');
        try {
            Model::beginTransaction();
            Gallery::where('refTable', 'articles')->where('refId', $actualId)->delete();
            Article::where('id', $actualId)->delete();
            Model::commit();
            session_flash('message', "Berhasil menghapus Artikel!");
        } catch (Exception $e) {
            Model::rollback();
        } finally {
            redirect('/manage-articles');
        }
    }

    public function generate_slug()
    {
        ensureIsAdmin();
        $title = trim($_GET["title"]) ?? "";
        header("Content-Type: application/json");
        if (empty($title)) {
            http_response_code(400);
            echo json_encode(["message" => "Judul wajib ada", "slug" => ""]);
            exit;
        }
        $slug = preg_replace("/[^a-z0-9\-]/", "-", strtolower($title));
        $slug = preg_replace("/\-+/", "-", $slug);
        for ($i = 0; $i < 32; $i++) {
            $duplicateCount = Article::where('slug', $slug)->count();
            if ($duplicateCount === 0) break;
            $slug = $slug . (string)$duplicateCount;
        }
        if (Article::where('slug', $slug)->count() > 0) {
            http_response_code(429);
            echo json_encode(["message" => "Failed to generate unique slug", "slug" => ""]);
        } else {
            echo json_encode(["slug" => $slug]);
        }
    }
}
