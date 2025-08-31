<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERPPonto - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mx-auto">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h1 class="h4 text-center mb-3">Acessar</h1>
            <?php session_start(); if (!empty($_SESSION["flash"])): ?>
              <div class="alert alert-danger py-2"><?= htmlspecialchars($_SESSION["flash"]); unset($_SESSION["flash"]); ?></div>
            <?php endif; ?>
            <form method="post" action="/signin">
              <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="mt-3 small text-muted">Usuário demo: admin@demo.local / senha: secret</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
