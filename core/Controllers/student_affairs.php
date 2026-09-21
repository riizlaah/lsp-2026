<?php
namespace App\Controllers;

use App\Models\Achievement;
use App\Models\Gallery;

class student_affairs {
    public function index() {
        $galleries = Gallery::where('isCover', true)->orderBy('createdAt')->limit(4)->getAll();
        $achievements = Achievement::orderBy('year')->orderBy('month')->limit(4)->getAll();
        view('student-affairs', ["title" => "Kesiswaan", "galleries" => $galleries, "achievements" => $achievements]);
    }

    public function galleries($refTable = "", $refId = "") {
        if(empty($refTable) && empty($refId)) {
            $galleries = Gallery::where('isCover', true)->orderBy('createdAt')->getAll();
            view('galleries', ["title" => "Galeri", "galleries" => $galleries]);
        } else {
            if(!ctype_alpha($refTable)) redirectBack();
            if(!ctype_digit($refId) || intval($refId) <= 0) redirectBack();
            $record = Gallery::where('refId', intval($refId))->where('refTable', $refTable)->where('isCover', true)->first();
            if(!$record) redirectBack();
            $records = Gallery::where('refId', intval($refId))->where('refTable', $refTable)->where('isCover', false)->getAll();
            view("gallery-detail", ["title" => "Detail Galeri", "cover" => $record, "extras" => $records]);
        }
    }

    public function achievements($id = "") {
        if(empty($id)) {
            $achievements = Achievement::orderBy('year')->orderBy('month')->getAll();
            view('achievements', ["title" => "Prestasi & Karya", "achievements" => $achievements]);
        } else {
            if(!ctype_digit($id) || intval($id) <= 0) redirectBack();
            $record = Achievement::where('id', intval($id))->first();
            if(!$record) redirectBack();
            view("achievement-detail", ["title" => "Detail Prestasi", "record" => $record]);
        }
    }
}