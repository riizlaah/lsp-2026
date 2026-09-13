<?php
namespace App\Controllers;

use function App\view;

class academic {
    public function index() {
        view("academic", ["title" => "Akademik"]);
    }
}