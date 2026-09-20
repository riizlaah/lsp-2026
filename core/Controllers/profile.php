<?php
namespace App\Controllers;

use App\Models\Achievement;

class profile {
    public function index() {
        $achievements = Achievement::orderBy('year')->limit(5)->getAll();
        view('profile', ['title' => 'Profil', 'achievements' => $achievements]);
    }
}