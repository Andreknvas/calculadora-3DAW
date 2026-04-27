<?php
declare(strict_types=1);

const QUESTIONS_FILE = __DIR__ . '/dados.txt';
const USERS_FILE = __DIR__ . '/usuarios.txt';

function startSessionIfNeeded(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function ensureUsersFile(): void
{
    if (file_exists(USERS_FILE)) {
        return;
    }

    $defaultUser = 'admin';
    $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
    file_put_contents(USERS_FILE, $defaultUser . '|' . $defaultPassword . PHP_EOL);
}

function getUsers(): array
{
    ensureUsersFile();
    $lines = file(USERS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    $users = [];

    foreach ($lines as $line) {
        $parts = explode('|', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $users[$parts[0]] = $parts[1];
    }

    return $users;
}

function authenticateUser(string $username, string $password): bool
{
    $users = getUsers();
    if (!isset($users[$username])) {
        return false;
    }

    return password_verify($password, $users[$username]);
}

function registerUser(string $username, string $password): array
{
    $username = trim($username);
    if ($username === '' || strlen($username) < 3) {
        return [false, 'Usuário deve ter ao menos 3 caracteres.'];
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return [false, 'Usuário deve conter apenas letras, números ou _.'];
    }

    if (strlen($password) < 4) {
        return [false, 'Senha deve ter ao menos 4 caracteres.'];
    }

    $users = getUsers();
    if (isset($users[$username])) {
        return [false, 'Este usuário já existe.'];
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    file_put_contents(USERS_FILE, $username . '|' . $hashed . PHP_EOL, FILE_APPEND);

    return [true, 'Cadastro realizado com sucesso.'];
}

function requireLogin(): void
{
    startSessionIfNeeded();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }
}

function ensureQuestionsFile(): void
{
    if (!file_exists(QUESTIONS_FILE)) {
        file_put_contents(QUESTIONS_FILE, '');
    }
}

function parseQuestionLine(string $line): ?array
{
    $parts = explode('|', trim($line));
    if (count($parts) < 4) {
        return null;
    }

    $id = $parts[0];
    $type = $parts[1];
    $question = $parts[2];
    $answersRaw = $parts[3] ?? '';
    $correct = $parts[4] ?? '';

    if ($id === '' || $question === '' || ($type !== 'M' && $type !== 'T')) {
        return null;
    }

    $answers = [];
    if ($type === 'M') {
        $answers = array_map('trim', explode(';', $answersRaw));
    } else {
        $answers = [$answersRaw];
    }

    return [
        'id' => $id,
        'type' => $type,
        'question' => $question,
        'answers' => $answers,
        'correct' => $correct,
    ];
}

function loadQuestions(): array
{
    ensureQuestionsFile();
    $lines = file(QUESTIONS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    $questions = [];

    foreach ($lines as $line) {
        $parsed = parseQuestionLine($line);
        if ($parsed !== null) {
            $questions[] = $parsed;
        }
    }

    return $questions;
}

function formatQuestion(array $question): string
{
    $answersRaw = $question['type'] === 'M'
        ? implode(';', $question['answers'])
        : ($question['answers'][0] ?? '');

    return implode('|', [
        $question['id'],
        $question['type'],
        $question['question'],
        $answersRaw,
        $question['correct'] ?? '',
    ]);
}

function saveQuestions(array $questions): void
{
    $lines = array_map(static fn(array $question): string => formatQuestion($question), $questions);
    $content = empty($lines) ? '' : implode(PHP_EOL, $lines) . PHP_EOL;
    file_put_contents(QUESTIONS_FILE, $content);
}

function findQuestionById(string $id): ?array
{
    foreach (loadQuestions() as $question) {
        if ($question['id'] === $id) {
            return $question;
        }
    }

    return null;
}

function getNewQuestionId(): string
{
    return uniqid('q_', true);
}
?>
