<?php
namespace App\Controllers;


class profile {
    public function index() {
        view('profile', ['title' => 'Profil']);
    }
}