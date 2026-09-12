<?php

use App\view;

use function App\isLoggedIn;
use function App\view;

class dashboard {
    public function index() {
        if(!isLoggedIn()) {
            view("login", ["title" => "Login to Dashboard"]);
            return;
        }
        view("dashboard");
    }
}