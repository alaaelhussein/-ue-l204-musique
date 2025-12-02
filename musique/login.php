<?php
session_start();
require_once 'config.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant'] ?? '');
    $motdepasse  = $_POST['motdepasse'] ?? '';

    if ($identifiant === '' || $motdepasse === '') {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $sql = "SELECT * FROM utilisateurs WHERE identifiant = :identifiant";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':identifiant' => $identifiant]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($motdepasse, $user['motdepasse'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['identifiant'] = $user['identifiant'];
            $_SESSION['role'] = $user['role'];

            header('Location: liste_albums.php');
            exit;
        } else {
            $erreur = "Identifiant ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php if ($erreur !== ''): ?>
        <p style="color:red;"><?php echo htmlspecialchars($erreur); ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Identifiant :
            <input type="text" name="identifiant">
        </label><br>
        <label>Mot de passe :
            <input type="password" name="motdepasse">
        </label><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
