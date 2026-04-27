<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();
$questions = loadQuestions();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar Perguntas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Listar Perguntas e Respostas</h2>
    <p><a href="index.php">Voltar ao menu</a></p>
    <?php if (empty($questions)): ?>
        <p>Nenhuma pergunta cadastrada.</p>
    <?php else: ?>
        <?php foreach ($questions as $q): ?>
            <div class="card">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($q['id']); ?></p>
                <p><strong>Tipo:</strong> <?php echo $q['type'] === 'M' ? 'Múltipla escolha' : 'Texto'; ?></p>
                <p><strong>Pergunta:</strong> <?php echo htmlspecialchars($q['question']); ?></p>
                <?php if ($q['type'] === 'M'): ?>
                    <p><strong>Respostas:</strong></p>
                    <ol>
                        <?php foreach ($q['answers'] as $idx => $ans): ?>
                            <li>
                                <?php echo htmlspecialchars($ans); ?>
                                <?php if ((string) ($idx + 1) === $q['correct']): ?> (Correta)<?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php else: ?>
                    <p><strong>Resposta:</strong> <?php echo htmlspecialchars($q['answers'][0] ?? ''); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>