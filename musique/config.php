<?php
$host = 'localhost';
$dbname = 'musique';
$user = 'root';
$pass = ''; // si tu as mis un mot de passe MySQL, écris-le ici

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
// test modification git
