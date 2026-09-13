<?php
namespace App\Controllers;

use App\Models\User;

use function App\ensureInputFilled;
use function App\isLoggedIn;
use function App\redirect;
use function App\redirectBackWithAlert;
use function App\redirectBackWithErrors;
use function App\view;

class dashboard
{
    public function index()
    {
        if (!isLoggedIn()) {
            view("dashboard.login", ["title" => "Login to Dashboard"]);
            return;
        }
        view("dashboard.index");
    }

    public function _post()
    {
        ensureInputFilled($_POST, ["email", "password"]);
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $user = User::where('email', $email)->first();
        if(!$user) redirectBackWithErrors(["email" => ["Email atau password salah"]]);
        if(!password_verify($password, $user->password)) redirectBackWithErrors(["" => ["Email atau password salah"]]);
        $_SESSION["auth"] = $user;
        redirect("/dashboard");
    }
}
