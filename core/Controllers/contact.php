<?php
namespace App\Controllers;


class contact {
    public function index() {
        view('contact', ["title" => "Kontak"]);
    }
}