<?php

// petit bootstrap commun (session + csrf)
// objectif: éviter de répéter session_start partout et garder une config clean.
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

    // refuse les ids de session "inventés"
    ini_set('session.use_strict_mode', '1');

    // à faire avant session_start()
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

require_once __DIR__ . '/csrf.php';
