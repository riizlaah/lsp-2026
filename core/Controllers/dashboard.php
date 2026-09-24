<?php
namespace App\Controllers;

use App\Config;
use App\Models\User;


class dashboard
{
    public function index()
    {
        if (!isLoggedIn()) {
            view("dashboard.login", ["title" => "Login to Dashboard"]);
            return;
        }
        view("dashboard.index", ["title" => "Dashboard"]);
    }

    public function other()
    {
        ensureIsAdmin();
        view("dashboard.other", ["title" => "Pengaturan Tambahan"]);
    }

    public function _post()
    {
        ensureInputFilled($_POST, ["email", "password"]);
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $user = User::where('email', $email)->first();
        if(!$user) redirectBackWithErrors(["email" => ["Email atau password salah"]]);
        if(!password_verify($password, $user->password)) redirectBackWithErrors(["" => ["Email atau password salah"]]);
        $_SESSION["auth"] = $user->asAssocArray();
        redirect("/dashboard");
    }

    public function change_pass_post() {
        ensureIsAdmin();
        ensureInputFilled($_POST, ["passwordBaru"]);
        $newPassword = $_POST["passwordBaru"];
        if(strlen($newPassword) < 8) redirectBackWithError('passwordBaru', ["Panjang password harus berjumlah 8 atau lebih karakter"]);
        // more validation
        $userId = getAuthData()["id"];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        User::where('id', $userId)->update([
            "password" => $hashedPassword
        ]);
        session_flash('message', "Berhasil mengganti password!");
        redirect('/dashboard');
    }

    public function update_settings_post() {
        ensureIsAdmin();
        $included = array_keys(Config::getAll());
        $conf = [];
        foreach($_POST as $key => $val) {
            if(!in_array($key, $included)) continue;
            if(!is_string($val)) redirectBack();
            $conf[$key] = htmlspecialchars($val);
        }
        Config::override($conf);
        Config::save();
        session_flash('message', "Berhasil mengubah pengaturan!");
        redirect('/dashboard/other');
    }

    public function logout() {
        session_invalidate();
        redirect('/dashboard');
    }
}
