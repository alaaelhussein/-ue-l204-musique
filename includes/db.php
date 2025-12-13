<?php
// AH: pdo connection used by all pages (database: musique)
// AH: local xampp defaults (localhost/root/no password) + exceptions + fetch assoc
$dsn  = 'mysql:host=localhost;dbname=musique;charset=utf8mb4';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

