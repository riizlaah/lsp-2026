<?php
use function App\view;


class profile {
    public function index() {
        view('profile', ['title' => 'Profil']);
    }
}