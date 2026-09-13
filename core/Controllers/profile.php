<?php
namespace App\Controllers;

use function App\view;


class profile {
    public function index() {
        view('profile', ['title' => 'Profil']);
    }
}