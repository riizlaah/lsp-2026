<?php
namespace App\Controllers;

use function App\view;


class information {
    public function index() {
        view("information", ["title" => "Informasi & Berita"]);
    }
}