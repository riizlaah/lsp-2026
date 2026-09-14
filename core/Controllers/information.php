<?php
namespace App\Controllers;


class information {
    public function index() {
        view("information", ["title" => "Informasi & Berita"]);
    }
}