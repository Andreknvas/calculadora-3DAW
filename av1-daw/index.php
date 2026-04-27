<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();
startSessionIfNeeded();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel do Jogo Corporativo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Painel do Jogo Corporativo</h1>
    <p>Usuário logado: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    <div class="menu">
        <a href="criar_multipla.php">Criar pergunta múltipla escolha</a>
        <a href="criar_texto.php">Criar pergunta texto</a>
        <a href="alterar.php">Alterar pergunta</a>
        <a href="listar.php">Listar perguntas</a>
        <a href="listar_um.php">Listar uma pergunta</a>
        <a href="excluir.php">Excluir pergunta</a>
        <a href="logout.php">Sair</a>
    </div>
</div>
</body>
</html>