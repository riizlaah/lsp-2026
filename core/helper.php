<?php

function tryLogin(array $input) {
    $user = User::where('username', $input["username"])->first();
    if(!$user) return false;
    if(!password_verify($input["password"], $user->password)) return false;
    $_SESSION["auth"] = $user;
    if(isset($input["rememberMe"]) && $input["rememberMe"]) {

    }
    return true;
}

function validateRememberToken($token) {}

function ensureAuthenticated() {
    return isset($_SESSION["auth"]);
}

function ensureIsRole(string $role) {
    return getAuthData()?->role === $role;
}

function getAuthData() {
    return $_SESSION["auth"] ?? null;
}

