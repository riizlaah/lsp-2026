<?php

require_once dirname(__DIR__) . "/models/user.php";

class index {
    public function index() {
        view('index', ['title' => 'Index']);
    }
}