<?php
require_once 'config.php';

// Identifiant et mot de passe du nouvel utilisateur
$identifiant = 'Utilisateur1';
$plainPassword = 'MotDePasseUser1';

// Générer le hash
$hash = password_hash($plainPassword, PASSWORD_DEFAULT);

// Vérifier si l'identifiant existe déjà
$sqlCheck = "SELECT id FROM utilisateurs WHERE identifiant = :identifiant";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':identifiant' => $identifiant]);
$exists = $stmtCheck->fetch();

if ($exists) {
    echo "L'utilisateur '$identifiant' existe déjà, aucun changement effectué.";
} else {
    // Insérer le nouvel utilisateur
    $sql = "INSERT INTO utilisateurs (identifiant, motdepasse, role)
            VALUES (:identifiant, :motdepasse, 'user')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':identifiant' => $identifiant,
        ':motdepasse'  => $hash
    ]);

    echo "Utilisateur '$identifiant' créé avec succès.";
}
