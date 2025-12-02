<?php
session_start();
require_once 'config.php';

// Protection : accès réservé aux utilisateurs connectés
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des albums</title>
</head>
<body>
    <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['identifiant']); ?></h1>
    <p>Vous êtes connecté avec le rôle : <?php echo htmlspecialchars($_SESSION['role']); ?></p>

    <p>Ici on affichera bientôt la liste des albums.</p>

    <p><a href="logout.php">Se déconnecter</a></p>
</body>
</html>
