<?php
use function App\view;

class contact {
    public function index() {
        view('contact', ["title" => "Kontak"]);
    }
}