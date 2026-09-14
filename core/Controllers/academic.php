<?php
namespace App\Controllers;

class academic {
    public function index() {
        view("academic", ["title" => "Akademik"]);
    }
}