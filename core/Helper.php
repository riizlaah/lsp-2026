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

function isLoggedIn()
{
    return isset($_SESSION["auth"]);
}

function ensureAuthenticated()
{
    if (!isLoggedIn()) {
        errCode(401, "Pengguna Belum Terautentikasi");
    }
}

function ensureIsRole(string $role)
{
    ensureAuthenticated();
    if (getAuthData()["role"] !== $role) {
        errCode(403, "Perlu akun admin");
    }
}

function ensureIsAdmin()
{
    ensureIsRole("admin");
}


function getAuthData()
{
    return $_SESSION["auth"] ?? null;
}

function getIDNMonthName(int $n)
{
    $opts = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    return $opts[$n - 1] ?? "?";
}


function getTextFromElement(string $str, $len = 100) {
    $str = strip_tags($str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return mb_substr($str, 0, $len, 'UTF-8') . (strlen($str) > $len ? "..." : "");
}

function safeUnlink(string $filename) {
    if(file_exists($filename)) unlink($filename);
}
