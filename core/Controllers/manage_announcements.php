<?php

namespace App\Controllers;

use App\Config;
use App\Model;
use App\Models\Announcement;
use App\Models\AnnouncementAttachment;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\TmpFile;
use Carbon\Carbon;
use Exception;
use HTMLPurifier;

class manage_announcements
{
    public function index()
    {
        $search = trim($_GET["search"]) ?? "";
        $records = [];
        if (!empty($search)) {
            $records = Announcement::where('title', "%$search%", "LIKE")->getAll();
        } else {
            $records = Announcement::getAll();
        }
        ensureIsAdmin();
        view("dashboard.announcements.index", ["title" => "Kelola Pengumuman", "records" => $records]);
    }

    public function create()
    {
        ensureIsAdmin();
        $categories = Category::getAll();
        view("dashboard.announcements.create", ["title" => "Tambah Pengumuman", "useTrix" => true, "categories" => $categories]);
    }

    public function edit($id = "")
    {
        ensureIsAdmin();
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-announcements");
        $record = Announcement::where('id', $actualId)->first();
        if (!$record) errCode(404, "Pengumuman tidak ditemukan");
        $categories = Category::getAll();
        view("dashboard.announcements.edit", ["title" => "Edit Pengumuman", "record" => $record, "categories" => $categories, "useTrix" => true]);
    }

    public function edit_put($id = "")
    {
        $purifier = new HTMLPurifier(Config::getHTMLPurifierConf());
        $content = $purifier->purify(trim($_POST["konten"] ?? ""));
        $_SESSION["_flash"]["oldInput"]["konten"] = $content;
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "slug", "konten",  "batasWaktu"]);
        if (isset($_FILES["gambarTajuk"])) ensureImageValid("gambarTajuk");
        $title = sanitizeInput("judul");
        $slug = sanitizeInput("slug");
        $publishNow = isset($_POST["umumkanSekarang"]);
        $publishedAt = (isset($_POST["tanggalPublikasi"]) && !empty(trim($_POST["tanggalPublikasi"]))) ? sanitizeInput("tanggalPublikasi") : null;
        $expiredAt = sanitizeInput("batasWaktu");
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-announcements");
        $record = Announcement::where('id', $actualId)->first();
        if (!$record) errCode(404, "Pengumuman tidak ditemukan");
        if (Announcement::where('slug', $slug)->where('id', $actualId, "!=")->any()) redirectBackWithError("slug", ["Slug sudah terpakai"]);
        try {
            Model::beginTransaction();
            Announcement::where('id', $actualId)->update([
                "title" => $title,
                "slug" => $slug,
                "content" => $content,
                "publishedAt" => !$publishNow ? Carbon::parse($publishedAt)->toDateTimeString() : Carbon::now()->toDateTimeString(),
                "expiredAt" => Carbon::parse($expiredAt)->toDateTimeString(),
            ]);
            Model::commit();
            session_flash("message", "Pengumuman berhasil diupdate!");
            redirect('/manage-announcements');
        } catch (Exception $e) {
            redirectBackWithError("", ["Gagal mengupdate pengumuman: " . $e->getMessage()]);
            Model::rollback();
            foreach ($images as $img) safeUnlink(Config::getUploadDirPath() . $img);
        }
    }

    public function create_post()
    {
        $purifier = new HTMLPurifier(Config::getHTMLPurifierConf());
        $content = $purifier->purify(trim($_POST["konten"] ?? ""));
        $_SESSION["_flash"]["oldInput"]["konten"] = $content;
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "slug", "kategori", "konten", "status"]);
        ensureImageValid("gambarTajuk");
        $title = sanitizeInput("judul");
        $slug = sanitizeInput("slug");
        $publishNow = isset($_POST["umumkanSekarang"]);
        $publishedAt = (isset($_POST["tanggalPublikasi"]) && !empty(trim($_POST["tanggalPublikasi"]))) ? sanitizeInput("tanggalPublikasi") : null;
        $expiredAt = sanitizeInput("batasWaktu");
        if (Announcement::where('slug', $slug)->any()) redirectBackWithError("slug", ["Slug sudah terpakai"]);
        try {
            Model::beginTransaction();
            $userId = getAuthData()["id"];
            Announcement::add([
                "userId" => $userId,
                "title" => $title,
                "slug" => $slug,
                "content" => $content,
                "publishedAt" => !$publishNow ? Carbon::parse($publishedAt)->toDateTimeString() : Carbon::now()->toDateTimeString(),
                "expiredAt" => Carbon::parse($expiredAt)->toDateTimeString(),
            ]);
            Model::commit();
            session_flash("message", "Pengumuman ditambahkan!");
            redirect('/manage-announcements');
        } catch (Exception $e) {
            redirectBackWithError("", ["Gagal membuat pengumuman: " . $e->getMessage()]);
            Model::rollback();
            foreach ($images as $img) safeUnlink(Config::getUploadDirPath() . $img);
        }
    }

    public function _delete($id = "")
    {
        ensureIsAdmin();
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-announcements");
        if (!Announcement::where('id', $actualId)->any()) redirect('/manage-announcements');
        Announcement::where('id', $actualId)->delete();
        redirect('/manage-announcements');
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
            $duplicateCount = Announcement::where('slug', $slug)->count();
            if ($duplicateCount === 0) break;
            $slug = $slug . (string)$duplicateCount;
        }
        if (Announcement::where('slug', $slug)->count() > 0) {
            http_response_code(429);
            echo json_encode(["message" => "Failed to generate unique slug", "slug" => ""]);
        } else {
            echo json_encode(["slug" => $slug]);
        }
    }
}
