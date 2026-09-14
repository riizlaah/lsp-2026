<?php
namespace App\Controllers;

use App\Models\Achievement;
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

    public function logout() {
        session_invalidate();
        redirect('/dashboard');
    }
}
