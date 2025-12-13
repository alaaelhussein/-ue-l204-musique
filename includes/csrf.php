<?php
// AH: csrf helpers for all post forms (add/edit/delete/logout)
// AH: uses one session token and validates it on post requests

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_input(): string
{
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function csrf_require_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        return;
    }

    // AH: make sure the session is available before reading the server-side token
    // AH: without this, some setups could treat every post as invalid because $_SESSION is empty
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $token = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    // AH: hash_equals avoids timing-based comparisons
    if (!is_string($token) || !is_string($sessionToken) || $sessionToken === '' || !hash_equals($sessionToken, $token)) {
        http_response_code(403);

        // AH: show a short, explicit message so users understand why a button "does nothing"
        // AH: common causes: cookies disabled, session not stored, or the page is not executed by php (opened as a static file)
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!doctype html>';
        echo '<html lang="fr">';
        echo '<head>';
        echo '<meta charset="utf-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<title>requête refusée</title>';
        echo '</head>';
        echo '<body>';
        echo '<h1>requête refusée (csrf)</h1>';
        echo '<p>la protection csrf a bloqué cette action. recharge la page puis réessaie.</p>';
        echo '<p>si ça arrive après un pull, vérifie que :</p>';
        echo '<ul>';
        echo '<li>tu ouvres le site via xampp/wamp ou <code>php -S</code> (pas en double-cliquant un fichier)</li>';
        echo '<li>les cookies sont autorisés (sinon la session ne peut pas stocker le token)</li>';
        echo '</ul>';
        echo '<p><a href="javascript:history.back()">retour</a></p>';
        echo '</body>';
        echo '</html>';
        exit;
    }
}

