<?php
namespace Source\App;

class Web {
    public function home(): void {
        $user = $_SESSION["user"] ?? null;
        if (!$user) { header("Location: /login"); return; }
        require __DIR__ . "/../../themes/web/index.php";
    }

    public function login(): void {
        if (!empty($_SESSION["user"])) { header("Location: /"); return; }
        require __DIR__ . "/../../themes/web/login.php";
    }

    public function error(): void {
        http_response_code(404);
        echo "<h1>404</h1><p>Página não encontrada.</p>";
    }
}
