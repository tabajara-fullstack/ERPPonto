<?php $user = $_SESSION["user"] ?? null; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERPPonto - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="/">ERPPonto</a>
    <div class="d-flex">
      <span class="navbar-text me-3">Olá, <?= htmlspecialchars($user["name"] ?? "") ?></span>
      <a class="btn btn-outline-secondary btn-sm" href="/logout">Sair</a>
    </div>
  </div>
</nav>

<main class="container py-5">
  <div class="row">
    <div class="col-12 col-lg-8 mx-auto">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h1 class="h4 mb-3">Boas-vindas ao ERPPonto 🎉</h1>
          <p class="mb-0">Você está autenticado. Comece a programar aqui.</p>
        </div>
      </div>
    </div>
  </div>
</main>
</body>
</html>
