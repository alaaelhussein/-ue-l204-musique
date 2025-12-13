<?php
require_once __DIR__ . '/../includes/bootstrap.php';

// AH: authentication page (login + logout)
// AH: responsibilities: sessions (login/logout), password_verify, and csrf protection on post

// AH: logout (post)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'logout') {
    csrf_require_post();
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$isLoggedIn = isset($_SESSION['user_id']);
require_once __DIR__ . '/../includes/db.php';

// AH: already logged in -> no need to show the login form
if ($isLoggedIn) {
    $username = $_SESSION['user_id'];
    $isAdmin  = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

    // AH: keep header visible when logged in
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
                    <?php echo csrf_input(); ?>
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

// AH: not logged in -> show login form

$errorMessage = null;
$submittedUsername = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {

    $identifiant = trim($_POST['identifiant'] ?? '');
    $motdepasse  = $_POST['motdepasse'] ?? '';
    $submittedUsername = $identifiant;

    // AH: csrf check + field validation
    csrf_require_post();

    if ($identifiant !== '' && !preg_match('/^[A-Za-z0-9_-]{3,30}$/', $identifiant)) {
        $errorMessage = "Identifiant invalide (3-30 caractères : lettres, chiffres, _ ou -).";
    }

    if ($errorMessage === null && ($identifiant === '' || $motdepasse === '')) {
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
                // AH: mitigate session fixation on successful login
                session_regenerate_id(true);
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

// AH: hide the main header on the public login page
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
                <?php echo csrf_input(); ?>
                <div class="form-group">
                    <label for="identifiant" class="form-label">Identifiant</label>
                    <input
                        type="text"
                        id="identifiant"
                        name="identifiant"
                        class="form-control"
                        placeholder="Votre identifiant"
                        value="<?= htmlspecialchars($submittedUsername); ?>"
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
                <a href="<?php echo BASE_URL; ?>/index.php">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

