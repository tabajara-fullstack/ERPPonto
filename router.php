<?php
// router.php - roteador para o servidor embutido do PHP
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if (is_file($file)) {
        // Deixa o PHP servir arquivos reais (CSS/JS/imagens)
        return false;
    }
}
// Para qualquer outra URL, delega ao front controller
require __DIR__ . '/index.php';
