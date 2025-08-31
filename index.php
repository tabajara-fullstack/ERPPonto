<?php
require __DIR__ . "/vendor/autoload.php";

use Source\Core\Router;

session_start();
date_default_timezone_set("America/Recife");

$router = new Router();
$router->namespace("Source\\App");

# web
$router->get("/", "Web:home", "web.home");
$router->get("/login", "Web:login", "web.login");

# auth
$router->post("/signin", "Auth:signin", "auth.signin");
$router->get("/logout", "Auth:logout", "auth.logout");

# errors
$router->get("/ops/{errcode}", "Web:error", "ops.error");

$router->dispatch();

if ($router->error()) {
    $router->redirect("ops.error", ["errcode" => $router->error()]);
}
