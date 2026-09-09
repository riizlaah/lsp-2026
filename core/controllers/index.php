<?php
use function App\view;

class index {
    public function index() {
        view('index', ['title' => 'Index']);
    }
}