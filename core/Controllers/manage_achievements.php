<?php
namespace App\Controllers;

use App\Config;
use App\Models\Achievement;

class manage_achievements {
    public function index() {
        ensureIsAdmin();
        $search = trim($_GET["search"]) ?? "";
        $query = Achievement::orderBy('year')->orderBy('month');
        if(!empty($search)) $query->where('title', "%$search%", "LIKE");
        $records = $query->getAll();
        view("dashboard.achievements.index", ["title" => "Kelola Pencapaian", "records" => $records]);
    }

    public function create() {
        ensureIsAdmin();
        view("dashboard.achievements.create", ["title" => "Tambah Pencapaian"]);
    }

    public function edit($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-achievements");
        $record = Achievement::where('id', $actualId)->first();
        if(!$record) errCode(404, "Pencapaian tidak ditemukan");
        view("dashboard.achievements.edit", ["title" => "Edit Pencapaian", "record" => $record]);
    }

    public function edit_put($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-achievements");
        ensureInputFilled($_POST, ["judul", "rank", "tingkat", "berjenjang", "konten", "tahun", "bulan"]);
        if(isFileUploaded("gambarTajuk")) ensureAttachmentValid("gambarTajuk");
        $name = sanitizeInput("judul");
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
        $record = Achievement::where('id', $actualId)->first();
        if(!$record) errCode(404, "Pencapaian tidak ditemukan");
        $image = isFileUploaded("gambarTajuk") ? moveUploadedFile("gambarTajuk", getUploadDirPath(), $record->headerImage ?? "") : $record->headerImage;
        Achievement::where('id', $actualId)->update([
            "title" => $name,
            "rank" => intval($rank),
            "level" => $level,
            "isTiered" => $isTiered == "t" ? true : false,
            "content" => $content,
            "year" => intval($year),
            "month" => intval($month),
            "headerImage" => $image
        ]);
        session_flash('message', "Berhasil memperbarui pencapaian!");
        redirect('/manage-achievements');
    }

    public function create_post() {
        ensureIsAdmin();
        ensureInputFilled($_POST, ["judul", "rank", "tingkat", "berjenjang", "konten", "tahun", "bulan"]);
        if(isFileUploaded("gambarTajuk")) ensureAttachmentValid("gambarTajuk");
        $name = sanitizeInput("judul");
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
        $image = isFileUploaded("gambarTajuk") ? moveUploadedFile("gambarTajuk", getUploadDirPath()) : null;
        Achievement::add([
            "userId" => $userId,
            "title" => $name,
            "rank" => intval($rank),
            "level" => $level,
            "isTiered" => $isTiered == "t" ? true : false,
            "content" => $content,
            "year" => intval($year),
            "month" => intval($month),
            "headerImage" => $image
        ]);
        session_flash("message", "Pencapaian ditambahkan!");
        redirect('/manage-achievements');
    }

    public function _delete($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-achievements");
        if(!Achievement::where('id', $actualId)->any()) redirect('/manage-achievements');
        Achievement::where('id', $actualId)->delete();
        session_flash('message', "Berhasil menghapus pencapaian!");
        redirect('/manage-achievements');
    }
}