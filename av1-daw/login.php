<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

startSessionIfNeeded();
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (authenticateUser($username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    }
    $error = 'Usuário ou senha inválidos.';
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container container-narrow">
    <h2>Login</h2>
    <p class="muted">Usuário padrão: <strong>admin</strong> | Senha padrão: <strong>admin123</strong></p>
    <?php if ($error !== ''): ?><p class="alert alert-error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <form method="post">
        <input name="username" placeholder="Usuário" required>
        <input name="password" type="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <p class="muted">Não tem conta? <a href="cadastro.php">Cadastrar usuário</a></p>
</div>
</body>
</html>
