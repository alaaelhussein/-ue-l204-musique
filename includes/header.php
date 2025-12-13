<?php
require_once __DIR__ . '/bootstrap.php';

// header commun (nav + statut utilisateur)
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin    = $isLoggedIn && (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// Permet aux pages de masquer le header (login.php)
if (!isset($hideHeader)) {
    $hideHeader = false;
}

// petit helper: chemin du dossier courant dans l'url (utile pour les liens)
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Médiathèque musique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS : depuis /pages vers /assets -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/../assets/style.css">
</head>
<body>
<div class="main-wrapper">
<?php if (!$hideHeader): ?>
    <header class="site-header">
        <div class="container site-header-inner">
            <a href="<?php echo $baseUrl; ?>/../index.php" class="brand">
                <div class="brand-logo">♫</div>
                <div class="brand-text">
                    <span class="brand-title">Médiathèque musique</span>
                    <span class="brand-subtitle">Catalogue de CD</span>
                </div>
            </a>

            <div class="user-info">
                <?php if ($isLoggedIn): ?>
                    <div class="user-info-icon">👤</div>
                    <div class="user-info-name">
                        Connecté en tant que
                        <strong><?php echo htmlspecialchars($_SESSION['user_id']); ?></strong>
                        (<?php echo $isAdmin ? 'admin' : 'user'; ?>)
                    </div>

                    <div class="user-info-actions">
                        <?php if ($isAdmin): ?>
                            <a href="<?php echo $baseUrl; ?>/gestion_utilisateurs.php" class="btn btn-secondary">
                                Gestion utilisateurs
                            </a>
                        <?php endif; ?>

                        <form action="<?php echo $baseUrl; ?>/login.php" method="post">
                            <input type="hidden" name="action" value="logout">
                            <?php echo csrf_input(); ?>
                            <button type="submit" class="btn btn-secondary">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <a href="<?php echo $baseUrl; ?>/login.php" class="btn btn-secondary">
                        Se connecter
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
<?php endif; ?>

    <main class="main-content">
        <div class="container">

