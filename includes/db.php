<?php
// AH: database connection (pdo)
// AH: defaults target common local stacks (xampp/wamp) but can be overridden via env vars
// AS: should fix xampp/wamp issues when mysql runs on a different port (3306/3308/3305)

// AH: read configuration from environment when available
// AH: getenv() returns false when a variable is not set, so we fallback to a default value
$dbHost = getenv('DB_HOST') ?: 'localhost'; // AH: mysql hostname (usually localhost)
$dbName = getenv('DB_NAME') ?: 'musique';   // AH: database name created by the sql dump
$dbUser = getenv('DB_USER') ?: 'root';      // AH: mysql username (default root on local stacks)
$dbPass = getenv('DB_PASS') ?: '';          // AH: mysql password (empty by default on many local stacks)

// AH: optional explicit port override
// AH: if DB_PORT is set, we only try that port; otherwise we try common ports
// AS: wamp often ends up on 3308 or 3305 when 3306 is already taken
$dbPort = getenv('DB_PORT');
$portsToTry = ($dbPort !== false && $dbPort !== '')
    ? [$dbPort]
    : ['3306', '3308', '3305'];

// AH: database charset used by the app
$dbCharset = 'utf8mb4';

// AH: initialize connection state
$pdo = null;        // AH: will hold the working pdo instance
$lastError = null;  // AH: keeps the last pdo exception to show a useful error message

// AH: attempt to connect using each candidate port until one succeeds
foreach ($portsToTry as $port) {
    // AH: build the pdo dsn string (this tells pdo what to connect to)
    $dsn = 'mysql:host=' . $dbHost
        . ';port=' . $port
        . ';dbname=' . $dbName
        . ';charset=' . $dbCharset;

    try {
        // AH: create the pdo instance used by all pages
        $pdo = new PDO(
            $dsn,
            $dbUser,
            $dbPass,
            [
                // AH: throw exceptions on sql errors instead of failing silently
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // AH: fetch rows as associative arrays by default
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        // AH: connection succeeded -> clear error and stop trying other ports
        $lastError = null;
        break;
    } catch (PDOException $e) {
        // AH: connection failed for this port -> store the error and try the next port
        $lastError = $e;
    }
}

// AH: if no port worked, stop the request and show the last connection error
if (!$pdo) {
    die('Erreur de connexion : ' . ($lastError ? $lastError->getMessage() : 'unknown error'));
}

