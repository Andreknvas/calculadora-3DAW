<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $questions = loadQuestions();
    $before = count($questions);

    $questions = array_values(array_filter(
        $questions,
        static fn(array $q): bool => $q['id'] !== $id
    ));

    if ($id === '') {
        $error = 'Informe um ID válido.';
    } elseif (count($questions) === $before) {
        $error = 'Pergunta não encontrada.';
    } else {
        saveQuestions($questions);
        $message = 'Pergunta e respostas excluídas com sucesso.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Excluir Pergunta e Respostas</h2>
    <p><a href="index.php">Voltar ao menu</a></p>
    <?php if ($message !== ''): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <form method="post">
        <input name="id" placeholder="ID da pergunta" required>
        <button type="submit">Excluir</button>
    </form>
</div>
</body>
</html>