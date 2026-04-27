<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['pergunta'] ?? '');
    $answer = trim($_POST['resposta'] ?? '');

    if ($question === '' || $answer === '') {
        $error = 'Preencha a pergunta e a resposta.';
    } else {
        $questions = loadQuestions();
        $questions[] = [
            'id' => getNewQuestionId(),
            'type' => 'T',
            'question' => $question,
            'answers' => [$answer],
            'correct' => '',
        ];
        saveQuestions($questions);
        $message = 'Pergunta de texto salva com sucesso.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Pergunta Texto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Criar Pergunta e Resposta de Texto</h2>
    <p><a href="index.php">Voltar ao menu</a></p>
    <?php if ($message !== ''): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <form method="post">
        <input name="pergunta" placeholder="Pergunta" required>
        <textarea name="resposta" placeholder="Resposta esperada" rows="4" required></textarea>
        <button type="submit">Salvar</button>
    </form>
</div>
</body>
</html>