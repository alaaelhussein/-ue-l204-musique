<?php
require_once __DIR__ . '/includes/bootstrap.php';

$hideHeader = false; // page d'accueil: on garde le header
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin    = $isLoggedIn && (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// base url du dossier courant (liens + css)
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Médiathèque musique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS : depuis /pages vers /assets -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/style.css">
</head>
<body>
<div class="main-wrapper">
<?php if (!$hideHeader): ?>
    <header class="site-header">
        <div class="container site-header-inner">
            <a href="<?php echo $baseUrl; ?>/index.php" class="brand">
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
                            <a href="<?php echo $baseUrl; ?>/pages/gestion_utilisateurs.php" class="btn btn-secondary">
                                Gestion utilisateurs
                            </a>
                        <?php endif; ?>

                        <form action="<?php echo $baseUrl; ?>/pages/login.php" method="post">
                            <input type="hidden" name="action" value="logout">
                            <?php echo csrf_input(); ?>
                            <button type="submit" class="btn btn-secondary">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <a href="<?php echo $baseUrl; ?>/pages/login.php" class="btn btn-secondary">
                        Se connecter
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
<?php endif; ?>

    <main class="main-content">
        <div class="container">

<section class="home-hero">
    <div class="home-hero-inner">
        <div class="home-hero-text">
            <h1 class="page-title home-hero-title">
                Bienvenue dans la médiathèque musicale
            </h1>
            <p class="page-description home-hero-lead">
                Consulte le catalogue de CD, recherche par artiste, titre ou année, et gère les albums.
            </p>

            <div class="home-hero-actions">
                <?php if ($isLoggedIn): ?>
                    <a href="pages/liste_albums.php" class="btn btn-primary">
                        Accéder au catalogue
                    </a>
                <?php else: ?>
                    <a href="pages/login.php" class="btn btn-primary">
                        Se connecter
                    </a>
                <?php endif; ?>

                <a href="#features" class="btn btn-secondary">
                    Voir les fonctionnalités
                </a>
            </div>
        </div>

        <div class="home-hero-card-wrapper">
            <div class="card card--hero">
                <div class="card-hero-label">
                    Aperçu rapide
                </div>
                <h2 class="card-hero-title">
                    Gestion du catalogue de CD
                </h2>

                <ul class="card-hero-list">
                    <li>Recherche par titre, artiste ou année.</li>
                    <li>Liste des albums disponibles.</li>
                    <li>Ajout et modification pour les admins.</li>
                    <li>Interface responsive orientée desktop.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="features" class="home-features">
    <h2 class="home-features-title">Fonctionnalités principales</h2>

    <div class="home-features-grid">
        <div class="card">
            <h3 class="home-feature-title">Connexion</h3>
            <p class="home-feature-text">
                Accès via une page de connexion pour distinguer les rôles <code>admin</code> et <code>user</code>.
            </p>
        </div>
        <div class="card">
            <h3 class="home-feature-title">Liste et recherche</h3>
            <p class="home-feature-text">
                Page de liste avec recherche par titre, artiste et l'année.
            </p>
        </div>
        <div class="card">
            <h3 class="home-feature-title">Gestion des albums</h3>
            <p class="home-feature-text">
                Pour les administrateurs&nbsp;: ajout, édition et suppression des albums.
            </p>
        </div>
        <div class="card">
            <h3 class="home-feature-title">Utilisateurs</h3>
            <p class="home-feature-text">
                Page optionnelle pour gérer les comptes <code>admin</code> et <code>user</code>.
            </p>
        </div>
    </div>
</section>

<?php // fin contenu ?>
        </div> <!-- .container -->
    </main>

    <footer class="site-footer">
        <div class="container site-footer-inner">
            <div class="site-footer-title">
                Médiathèque musicale
            </div>

            <div class="site-footer-text">
                Mini projet UE 204 — Gestion d’un catalogue de CD
            </div>

            <nav class="site-footer-nav">
                <a href="index.php" class="site-footer-link">Accueil</a>
                <a href="pages/login.php" class="site-footer-link">Connexion</a>
                <a href="pages/liste_albums.php" class="site-footer-link">Catalogue</a>
            </nav>

            <div class="site-footer-copy">
                © <?= date('Y'); ?> — Groupe n°8 (S. Anistratenco, A. El Hussein, M. Ferrand, M. Shakurov) 
            </div>
        </div>
    </footer>
</div> <!-- .main-wrapper -->
</body>
</html>
