<?php
require_once 'config.php';

// Choisis ici le mot de passe de l'administrateur
$plainPassword = 'MonSuperMotDePasse';

// Générer le hash sécurisé
$hash = password_hash($plainPassword, PASSWORD_DEFAULT);

// Mettre à jour la ligne de l'administrateur
$sql = "UPDATE utilisateurs 
        SET motdepasse = :hash, role = 'admin' 
        WHERE identifiant = 'Administrateur'";
$stmt = $pdo->prepare($sql);
$stmt->execute([':hash' => $hash]);

echo "Mot de passe de l'administrateur mis à jour avec succès.";
