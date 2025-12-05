<?php
// includes/db.php

$dsn  = 'mysql:host=localhost;dbname=musique;charset=utf8mb4';
$user = 'root';   // XAMPP par défaut
$pass = '';       // mot de passe vide par défaut

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
