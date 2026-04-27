<?php
declare(strict_types=1);
require_once __DIR__ . '/storage.php';

requireLogin();

$found = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    if ($id === '') {
        $error = 'Informe um ID.';
    } else {
        $found = findQuestionById($id);
        if ($found === null) {
            $error = 'Pergunta não encontrada.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Listar Uma Pergunta</h2>
    <p><a href="index.php">Voltar ao menu</a></p>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <form method="post">
        <input name="id" placeholder="ID da pergunta" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($found !== null): ?>
        <div class="card">
            <p><strong>ID:</strong> <?php echo htmlspecialchars($found['id']); ?></p>
            <p><strong>Pergunta:</strong> <?php echo htmlspecialchars($found['question']); ?></p>
            <p><strong>Tipo:</strong> <?php echo $found['type'] === 'M' ? 'Múltipla escolha' : 'Texto'; ?></p>
            <?php if ($found['type'] === 'M'): ?>
                <ol>
                    <?php foreach ($found['answers'] as $i => $a): ?>
                        <li>
                            <?php echo htmlspecialchars($a); ?>
                            <?php if ((string) ($i + 1) === $found['correct']): ?> (Correta)<?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php else: ?>
                <p><strong>Resposta:</strong> <?php echo htmlspecialchars($found['answers'][0] ?? ''); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>