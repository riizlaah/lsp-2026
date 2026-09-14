<?php
namespace App\Controllers;

use App\Models\Achievement;

class manage_achievements {
    public function index() {
        $search = trim($_GET["search"]) ?? "";
        $records = [];
        if(!empty($search)) {
            $records = Achievement::where('title', "%$search%", "LIKE")->getAll();
        } else {
            $records = Achievement::getAll();
        }
        ensureIsAdmin();
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
        view("dashboard.achievements.edit", ["title" => "Tambah Pencapaian", "record" => $record]);
    }

    public function edit_put($id = "") {
        ensureIsAdmin();
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-achievements");
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
        if(!ctype_digit($year) || intval($year) < 0) redirectBackWithErrors(["tahun" => ["Tahun tidak valid"]]);
        if(!ctype_digit($month) || intval($month) < 0) redirectBackWithErrors(["bulan" => ["Bulan tidak valid"]]);
        if(!Achievement::where('id', $actualId)->any()) errCode(404, "Pencapaian tidak ditemukan");
        Achievement::where('id', $actualId)->update([
            "title" => $name,
            "rank" => intval($rank),
            "level" => $level,
            "isTiered" => $isTiered == "t" ? true : false,
            "content" => $content,
            "year" => intval($year),
            "month" => intval($month)
        ]);
        session_flash('message', "Berhasil mengubah pencapaian!");
        redirect('/manage-achievements');
    }

    public function create_post() {
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
        if(!ctype_digit($year) || intval($year) < 0) redirectBackWithErrors(["tahun" => ["Tahun tidak valid"]]);
        if(!ctype_digit($month) || intval($month) < 0) redirectBackWithErrors(["bulan" => ["Bulan tidak valid"]]);
        $userId = getAuthData()["id"];
        Achievement::add([
            "userId" => $userId,
            "title" => $name,
            "rank" => intval($rank),
            "level" => $level,
            "isTiered" => $isTiered == "t" ? true : false,
            "content" => $content,
            "year" => intval($year),
            "month" => intval($month)
        ]);
        session_flash("message", "Pencapaian ditambahkan!");
        redirect('/manage-achievements');
    }

    public function _delete($id = "") {
        $actualId = intval($id);
        if($actualId <= 0) redirect("/manage-achievements");
        if(!Achievement::where('id', $actualId)->any()) redirect('/manage-achievements');
        Achievement::where('id', $actualId)->delete();
        session_flash('message', "Berhasil menghapus pencapaian!");
        redirect('/manage-achievements');
    }
}