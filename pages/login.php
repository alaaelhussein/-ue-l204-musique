<?php
session_start();

/*
    Connexion via la table `utilisateurs` :
    - identifiant
    - motdepasse (hashé)
    - role : 'admin' ou 'user'
*/

// Gestion de la déconnexion (formulaire du header et de cette page)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'logout') {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$isLoggedIn = isset($_SESSION['user_id']);

// Si déjà connecté : on n’affiche pas le formulaire, mais un message
if ($isLoggedIn) {
    $username = $_SESSION['user_id'];
    $isAdmin  = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

    // Ici, on garde le header allumé
    $hideHeader = false;
    require_once __DIR__ . '/../includes/header.php';
    ?>
    <div class="auth-layout">
        <div class="auth-inner">
            <div class="card card--auth">
                <h1 class="auth-title">
                    Vous êtes déjà connecté en tant que
                    <strong><?= htmlspecialchars($username); ?></strong>.
                </h1>

                <div class="form-actions">
                    <a href="liste_albums.php" class="btn btn-primary btn-full">
                        Accéder au catalogue
                    </a>
                </div>

                <form action="login.php" method="post" class="form-actions">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-secondary btn-full">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

/* --------- Cas non connecté : formulaire de login --------- */

require_once __DIR__ . '/../includes/db.php';

$errorMessage     = null;
$identifiantSaisi = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {

    $identifiant       = trim($_POST['identifiant'] ?? '');
    $motdepasse        = $_POST['motdepasse'] ?? '';
    $identifiantSaisi  = $identifiant;

    if ($identifiant === '' || $motdepasse === '') {
        $errorMessage = "Merci de remplir les deux champs.";
    } else {
        try {
            $stmt = $pdo->prepare(
                'SELECT id, identifiant, motdepasse, role
                 FROM utilisateurs
                 WHERE identifiant = :identifiant
                 LIMIT 1'
            );
            $stmt->execute([':identifiant' => $identifiant]);
            $user = $stmt->fetch();

            if ($user && password_verify($motdepasse, $user['motdepasse'])) {
                $_SESSION['user_id'] = $user['identifiant'];
                $_SESSION['role']    = $user['role'];

                header('Location: liste_albums.php');
                exit;
            } else {
                $errorMessage = "Identifiants incorrects.";
            }

        } catch (PDOException $e) {
            $errorMessage = "Erreur lors de la vérification des identifiants.";
        }
    }
}

// Pour la page de login non connectée, on masque le header
$hideHeader = true;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="auth-layout">
    <div class="auth-inner">
        <div class="card card--auth">
            <div class="brand">
                <div class="brand-logo">♫</div>
                <div class="brand-text">
                    <span class="brand-title">Médiathèque musique</span>
                    <span class="brand-subtitle">Connexion</span>
                </div>
            </div>

            <h1 class="auth-title">Se connecter</h1>
            <p class="auth-subtitle">
                Saisis ton identifiant et ton mot de passe pour accéder à la médiathèque.
            </p>

            <?php if ($errorMessage): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="identifiant" class="form-label">Identifiant</label>
                    <input
                        type="text"
                        id="identifiant"
                        name="identifiant"
                        class="form-control"
                        placeholder="Votre identifiant"
                        value="<?= htmlspecialchars($identifiantSaisi); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="motdepasse" class="form-label">Mot de passe</label>
                    <input
                        type="password"
                        id="motdepasse"
                        name="motdepasse"
                        class="form-control"
                        placeholder="Mot de passe"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    Se connecter
                </button>
            </form>

            <div class="auth-footer-links">
                <a href="index.php">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
