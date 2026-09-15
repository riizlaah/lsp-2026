<?php
namespace App\Controllers;

use App\Models\Achievement;

class student_affairs {
    public function index() {
        view('student-affairs', ["title" => "Kesiswaan"]);
    }

    public function galeries($id = "") {
        view('galeries', ["title" => "Galeri"]);
    }

    public function achievements($id = "") {
        if(empty($id)) {
            $achievements = Achievement::getAll();
            view('achievements', ["title" => "Prestasi & Karya", "achievements" => $achievements]);
        } else {
            if(!ctype_digit($id) || intval($id) <= 0) redirectBack();
            $record = Achievement::where('id', intval($id))->first();
            if(!$record) redirectBack();
            view("achievement-detail", ["title" => "Detail Prestasi", "record" => $record]);
        }
    }
}