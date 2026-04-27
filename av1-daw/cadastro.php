<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

startSessionIfNeeded();
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $error = 'As senhas não conferem.';
    } else {
        [$ok, $feedback] = registerUser($username, $password);
        if ($ok) {
            $message = $feedback;
        } else {
            $error = $feedback;
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container container-narrow">
    <h2>Cadastrar usuário</h2>
    <p>Crie um usuário para acessar o sistema.</p>
    <?php if ($error !== ''): ?><p class="alert alert-error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <?php if ($message !== ''): ?><p class="alert alert-success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <form method="post">
        <input name="username" placeholder="Usuário" required>
        <input name="password" type="password" placeholder="Senha" required>
        <input name="confirm_password" type="password" placeholder="Confirmar senha" required>
        <button type="submit">Cadastrar</button>
    </form>
    <p class="muted">Já tem conta? <a href="login.php">Fazer login</a></p>
</div>
</body>
</html>
