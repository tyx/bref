<?php declare(strict_types=1);

if ($_GET['extensions'] ?? false) {
    header('Content-Type: application/json');
    echo json_encode(get_loaded_extensions(), JSON_PRETTY_PRINT);
    return;
}

if ($_GET['php-config'] ?? false) {
    header('Content-Type: application/json');
    echo json_encode(ini_get_all(null, false), JSON_PRETTY_PRINT);
    return;
}

if ($_GET['env'] ?? false) {
    header('Content-Type: application/json');
    echo json_encode([
        '$_ENV' => $_ENV['FOO'] ?? null,
        '$_SERVER' => $_SERVER['FOO'] ?? null,
        'getenv' => getenv('FOO'),
    ], JSON_PRETTY_PRINT);
    return;
}

if ($_GET['stderr'] ?? false) {
    $stderr = fopen('php://stderr', 'a');
    fwrite($stderr, 'This is a test log into stderr');
    fclose($stderr);
}

if ($_GET['error_log'] ?? false) {
    error_log('This is a test log from error_log');
}

if ($_GET['exception'] ?? false) {
    throw new Exception('This is an uncaught exception');
}

if ($_GET['error'] ?? false) {
    strlen();
}

if ($_GET['fatal_error'] ?? false) {
    require 'foo';
}

if ($_GET['warning'] ?? false) {
    trigger_error('This is a test warning', E_USER_WARNING);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = file_get_contents('php://input');
    $bodySize = round(strlen($body) / 1024 / 1024);
    echo "Received {$bodySize}Mb";
    return;
}

echo 'Hello ' . ($_GET['name'] ?? 'world!');
