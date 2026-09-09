<?php
use function App\view;

class student_affairs {
    public function index() {
        view('student-affairs', ["title" => "Kesiswaan"]);
    }

    public function galeries($id = "") {
        view('galeries', ["title" => "Galeri"]);
    }

    public function achievements($id = "") {
        view('achievements', ["title" => "Prestasi & Karya"]);
    }
}