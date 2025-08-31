# ERPPonto – Esqueleto PHP com Login

## Como usar
1. Extraia este ZIP para sua pasta do projeto.
2. Rode `composer dump-autoload` (requer Composer instalado).
3. Inicie o servidor local: `php -S 0.0.0.0:8000 -t .`
4. Acesse `http://localhost:8000/login`

## Login de demonstração
- E-mail: `admin@demo.local`
- Senha: `secret`

## Estrutura
- `index.php`: ponto de entrada e rotas
- `source/Core/Router.php`: roteador simples
- `source/App/Web.php`: páginas web (home/login)
- `source/App/Auth.php`: autenticação (signin/logout)
- `source/Models/Users.php`: modelo de usuários (mock com hash de senha)
- `themes/web`: views (Bootstrap 5)
- `.htaccess`: URL amigável

## Integração com GitHub (opcional)
Use os scripts que forneci:
- **Bash:** `./commit_chatgpt.sh "feat: ERPPonto - estrutura inicial"`
- **PowerShell:** `powershell -ExecutionPolicy Bypass -File .\commit_chatgpt.ps1 "feat: ERPPonto - estrutura inicial"`

> Se não houver upstream configurado, faça uma vez: `git push -u origin main` (ou sua branch).
