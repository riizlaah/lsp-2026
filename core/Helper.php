<?php


use App\Models\User;

// function tryLogin(array $input) {
//     $user = User::where('username', $input["username"])->first();
//     if(!$user) return false;
//     if(!password_verify($input["password"], $user->password)) return false;
//     $_SESSION["auth"] = serialize($user);
//     if(isset($input["rememberMe"]) && $input["rememberMe"]) {

//     }
//     return true;
// }

function validateRememberToken($token) {}

function isLoggedIn() {
    return isset($_SESSION["auth"]);
}

function ensureAuthenticated() {
    if(!isLoggedIn()) {
        errCode(401, "Pengguna Belum Terautentikasi");
    }
}

function ensureIsRole(string $role) {
    ensureAuthenticated();
    if(getAuthData()["role"] !== $role) {
        errCode(403, "Perlu akun admin");
    }
}

function ensureIsAdmin() {
    ensureIsRole("admin");
}


function getAuthData() {
    return $_SESSION["auth"] ?? null;
}

