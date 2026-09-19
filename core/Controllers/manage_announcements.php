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
        $content = sanitizeHTML(trim($_POST["konten"] ?? ""));
        $_SESSION["_flash"]["oldInput"]["konten"] = $content;
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "slug", "konten",  "jadwalKadaluarsa", "jadwalPengumuman"]);
        if (isset($_FILES["gambarTajuk"])) ensureAttachmentValid("gambarTajuk");
        $title = sanitizeInput("judul");
        $slug = sanitizeInput("slug");
        $publishedAt = sanitizeInput("jadwalPengumuman");
        $expiredAt = sanitizeInput("jadwalKadaluarsa");
        $actualId = intval($id);
        if ($actualId <= 0) redirect("/manage-announcements");
        $record = Announcement::where('id', $actualId)->first();
        if (!$record) errCode(404, "Pengumuman tidak ditemukan");
        if(!Carbon::canBeCreatedFromFormat($expiredAt, "Y-m-d\TH:i")) redirectBackWithError("jadwalKadaluarsa", ["Jadwal kadaluarsa tidak sesuai format"]);
        if(!Carbon::canBeCreatedFromFormat($publishedAt, "Y-m-d\TH:i")) redirectBackWithError("jadwalPengumuman", ["Jadwal pengumuman tidak sesuai format"]);
        $publishedAt2 = Carbon::parse($publishedAt);
        if(!$publishedAt2->eq(substr($record->publishedAt, 0, -3))) {
            if($publishedAt2->lt(Carbon::now())) redirectBackWithError("jadwalPengumuman", ["Jadwal pengumuman tidak valid"]);
        }
        if(Carbon::parse($publishedAt)->diffInHours($expiredAt) < 3) redirectBackWithError("jadwalKadaluarsa", ["Jadwal kadaluarsa harus berjarak minimal 3 jam dari jadwal kadaluarsa"]);
        if (Announcement::where('slug', $slug)->where('id', $actualId, "!=")->any()) redirectBackWithError("slug", ["Slug sudah terpakai"]);
        try {
            Model::beginTransaction();
            $this->updateTmpFilesIfExists($content);
            Announcement::where('id', $actualId)->update([
                "title" => $title,
                "slug" => $slug,
                "content" => $content,
                "publishedAt" => Carbon::parse($publishedAt)->toDateTimeString(),
                "expiredAt" => Carbon::parse($expiredAt)->toDateTimeString(),
            ]);
            Model::commit();
            session_flash("message", "Pengumuman berhasil diperbarui!");
            redirect('/manage-announcements');
        } catch (Exception $e) {
            redirectBackWithError("", ["Gagal mengupdate pengumuman: " . $e->getMessage()]);
            Model::rollback();
        }
    }

    public function create_post()
    {
        $content = sanitizeHTML(trim($_POST["konten"] ?? ""));
        $_SESSION["_flash"]["oldInput"]["konten"] = $content;
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "slug", "konten", "jadwalKadaluarsa", "waktuPengumuman"]);
        $title = sanitizeInput("judul");
        $slug = sanitizeInput("slug");
        $publishNow = sanitizeInput("waktuPengumuman") == "s";
        $publishedAt = ($publishNow && !empty(trim($_POST["jadwalPengumuman"]))) ? sanitizeInput("jadwalPengumuman") : null;
        $expiredAt = sanitizeInput("jadwalKadaluarsa");
        if(!Carbon::canBeCreatedFromFormat($expiredAt, "Y-m-d\TH:i")) redirectBackWithError("jadwalKadaluarsa", ["Jadwal kadaluarsa tidak valid"]);
        if(!$publishNow) {
            if(!Carbon::canBeCreatedFromFormat($publishedAt, "Y-m-d\TH:i")) redirectBackWithError("jadwalPengumuman", ["Jadwal pengumuman tidak sesuai format"]);
            $publishedAt2 = Carbon::parse($publishedAt);
            if($publishedAt2->lt(Carbon::now())) redirectBackWithError("jadwalPengumuman", ["Jadwal pengumuman tidak valid"]);
            if(Carbon::parse($publishedAt)->diffInHours($expiredAt) < 3) redirectBackWithError("jadwalKadaluarsa", ["Jadwal kadaluarsa harus berjarak minimal 3 jam dari jadwal kadaluarsa"]);
        } else {
            if(Carbon::now()->diffInHours($expiredAt) < 3) redirectBackWithError("jadwalKadaluarsa", ["Jadwal pengumuman harus berjarak minimal 3 jam dari jadwal kadaluarsa"]);
        }
        if (Announcement::where('slug', $slug)->any()) redirectBackWithError("slug", ["Slug sudah terpakai"]);
        try {
            Model::beginTransaction();
            $this->updateTmpFilesIfExists($content);
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
