<?php
namespace Source\App;

use Source\Models\Users;

class Auth {
    public function signin(): void {
        $email = trim($_POST["email"] ?? "");
        $pass  = trim($_POST["password"] ?? "");

        $user = (new Users())->findByEmail($email);
        if ($user && password_verify($pass, $user["password_hash"])) {
            $_SESSION["user"] = [
                "id" => $user["id"],
                "name" => $user["name"],
                "email" => $user["email"]
            ];
            header("Location: /");
        } else {
            $_SESSION["flash"] = "Credenciais inválidas.";
            header("Location: /login");
        }
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), "", time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: /login");
    }
}
