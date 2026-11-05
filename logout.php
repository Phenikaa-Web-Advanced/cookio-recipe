<?php

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
    session_start();
}

$_SESSION = [];

if (ini_get('session.use_cookies') && !headers_sent()) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'] ?? '',
        $params['secure'] ?? false,
        $params['httponly'] ?? true
    );
}

if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

$target = (defined('BASE_URL') && BASE_URL !== '') ? rtrim(BASE_URL, '/') . '/index.php' : '/index.php';
header('Location: ' . $target);
exit;
