<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $newQuestion = trim($_POST['pergunta'] ?? '');
    $newTextAnswer = trim($_POST['resposta_texto'] ?? '');
    $newAnswers = [
        trim($_POST['r1'] ?? ''),
        trim($_POST['r2'] ?? ''),
        trim($_POST['r3'] ?? ''),
        trim($_POST['r4'] ?? ''),
    ];
    $newCorrect = trim($_POST['correta'] ?? '');

    $questions = loadQuestions();
    $updated = false;

    foreach ($questions as &$q) {
        if ($q['id'] !== $id) {
            continue;
        }

        if ($newQuestion === '') {
            $error = 'A pergunta não pode ficar vazia.';
            break;
        }

        $q['question'] = $newQuestion;
        if ($q['type'] === 'M') {
            if (in_array('', $newAnswers, true) || !in_array($newCorrect, ['1', '2', '3', '4'], true)) {
                $error = 'Para múltipla escolha, preencha 4 respostas e informe a correta de 1 a 4.';
                break;
            }
            $q['answers'] = $newAnswers;
            $q['correct'] = $newCorrect;
        } else {
            if ($newTextAnswer === '') {
                $error = 'Para pergunta de texto, preencha a resposta.';
                break;
            }
            $q['answers'] = [$newTextAnswer];
            $q['correct'] = '';
        }

        $updated = true;
        break;
    }
    unset($q);

    if ($id === '') {
        $error = 'Informe um ID.';
    } elseif (!$updated && $error === '') {
        $error = 'Pergunta não encontrada.';
    } elseif ($error === '') {
        saveQuestions($questions);
        $message = 'Pergunta alterada com sucesso.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Alterar Pergunta e Respostas</h2>
    <p><a href="index.php">Voltar ao menu</a></p>
    <?php if ($message !== ''): ?><p class="success"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <form method="post">
        <input name="id" placeholder="ID da pergunta" required>
        <input name="pergunta" placeholder="Nova pergunta" required>
        <input name="r1" placeholder="Resposta 1 (somente múltipla)">
        <input name="r2" placeholder="Resposta 2 (somente múltipla)">
        <input name="r3" placeholder="Resposta 3 (somente múltipla)">
        <input name="r4" placeholder="Resposta 4 (somente múltipla)">
        <select name="correta">
            <option value="">Alternativa correta (somente múltipla)</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <textarea name="resposta_texto" rows="4" placeholder="Nova resposta (somente texto)"></textarea>
        <button type="submit">Alterar</button>
    </form>
</div>
</body>
</html>