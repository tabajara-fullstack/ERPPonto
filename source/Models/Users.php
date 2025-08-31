<?php
namespace Source\Models;

class Users {
    private array $mock;

    public function __construct() {
        $this->mock = [[
            "id" => 1,
            "name" => "Admin Demo",
            "email" => "admin@demo.local",
            "password_hash" => password_hash("secret", PASSWORD_DEFAULT) // senha: secret
        ]];
    }

    public function findByEmail(string $email): ?array {
        foreach ($this->mock as $u) {
            if (strtolower($u["email"]) === strtolower($email)) return $u;
        }
        return null;
    }
}
