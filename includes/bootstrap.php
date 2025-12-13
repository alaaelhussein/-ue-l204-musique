<?php
// AH: common bootstrap (session + csrf)
// AH: avoids repeating session_start() and keeps cookie settings consistent
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

    // AH: refuse user-supplied / invented session ids
    ini_set('session.use_strict_mode', '1');

    // AH: must be set before session_start()
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

// AS: base url for links/assets (fixes missing css when project is in a subfolder)
// AS: why this exists: relative paths like "./assets/style.css" break on /pages/*.php (they become /pages/assets/...)
// AS: solution: compute the project base once, then reuse it everywhere as BASE_URL

// AS: get the current script path from the request
// AS: some setups can have SCRIPT_NAME empty; fallback to PHP_SELF then REQUEST_URI so BASE_URL still computes correctly
$scriptName = (string)($_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? ''));
if ($scriptName === '' && isset($_SERVER['REQUEST_URI'])) {
    $scriptName = (string)(parse_url((string)$_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
}

// AS: then take the directory (examples: /index.php -> /, /pages/login.php -> /pages)
$scriptDir = dirname($scriptName !== '' ? $scriptName : '/');
// AS: normalize windows backslashes (if any) to forward slashes (url-style)
$scriptDir = str_replace('\\', '/', $scriptDir);
// AS: remove trailing slash so pattern checks are predictable ("/pages/" -> "/pages")
$scriptDir = rtrim($scriptDir, '/');

// AS: if the current script lives under /pages, the project root is one level up; otherwise it is the current dir
$baseUrl = preg_match('#/pages$#', $scriptDir) ? dirname($scriptDir) : $scriptDir;
// AS: normalize edge cases to an empty base ("" makes links like "/assets/style.css" when concatenated)
$baseUrl = str_replace('\\', '/', $baseUrl);
$baseUrl = rtrim($baseUrl, '/');
$baseUrl = ($baseUrl === '/' || $baseUrl === '.' || $baseUrl === '') ? '' : $baseUrl;

// AS: guarantee a leading slash when not empty (avoid "subfolder/assets" which breaks on /pages/*)
if ($baseUrl !== '' && $baseUrl[0] !== '/') {
    $baseUrl = '/' . $baseUrl;
}

// AS: expose BASE_URL to all includes/pages (used by header/footer for links and css)
define('BASE_URL', $baseUrl);

