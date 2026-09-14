<?php
namespace App\Controllers;

class index {
    public function index() {
        view('index', ['title' => 'Index']);
    }
}