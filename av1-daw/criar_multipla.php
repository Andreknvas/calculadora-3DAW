<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['pergunta'] ?? '');
    $answers = [
        trim($_POST['r1'] ?? ''),
        trim($_POST['r2'] ?? ''),
        trim($_POST['r3'] ?? ''),
        trim($_POST['r4'] ?? ''),
    ];
    $correct = trim($_POST['correta'] ?? '');

    if ($question === '' || in_array('', $answers, true)) {
        $error = 'Preencha a pergunta e as 4 respostas.';
    } elseif (!in_array($correct, ['1', '2', '3', '4'], true)) {
        $error = 'Informe a alternativa correta entre 1 e 4.';
    } else {
        $questions = loadQuestions();
        $questions[] = [
            'id' => getNewQuestionId(),
            'type' => 'M',
            'question' => $question,
            'answers' => $answers,
            'correct' => $correct,
        ];
        saveQuestions($questions);
        $message = 'Pergunta de múltipla escolha salva com sucesso.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Pergunta Múltipla</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Criar Pergunta e Respostas de Múltipla Escolha</h2>
    <p><a href="index.php">Voltar ao menu</a></p>
    <?php if ($message !== ''): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <form method="post">
        <input name="pergunta" placeholder="Pergunta" required>
        <input name="r1" placeholder="Resposta 1" required>
        <input name="r2" placeholder="Resposta 2" required>
        <input name="r3" placeholder="Resposta 3" required>
        <input name="r4" placeholder="Resposta 4" required>
        <select name="correta" required>
            <option value="">Alternativa correta</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <button type="submit">Salvar</button>
    </form>
</div>
</body>
</html>