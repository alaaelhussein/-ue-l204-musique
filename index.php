<?php
require_once __DIR__ . '/includes/bootstrap.php';

// AS: homepage (hero + feature overview)
// AS: uses shared header/footer templates for a consistent ui

$hideHeader = false;
require_once __DIR__ . '/includes/header.php';
?>

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

<?php
require_once __DIR__ . '/includes/footer.php';

