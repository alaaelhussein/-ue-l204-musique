<?php
require_once __DIR__ . '/../includes/bootstrap.php';

// MF: admin page to add an album (create)
// MF: responsibilities: server-side validation, insert query, and success/error feedback

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!$isAdmin) {
    header('Location: liste_albums.php');
    exit;
}

// MF: db access
require_once __DIR__ . '/../includes/db.php';

$errors = [];
$successMessage = null;

$titre   = '';
$artiste = '';
$annee   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_post();
    $titre   = trim($_POST['titre'] ?? '');
    $artiste = trim($_POST['artiste'] ?? '');
    $annee   = trim($_POST['annee'] ?? '');

    // MF: simple field checks
    if ($titre === '') {
        $errors['titre'] = 'Le titre de l’album est obligatoire.';
    }

    if ($artiste === '') {
        $errors['artiste'] = 'L’artiste est obligatoire.';
    }

    if ($annee === '') {
        $errors['annee'] = 'L’année de sortie est obligatoire.';
    } elseif (!ctype_digit($annee) || (int)$annee < 1900 || (int)$annee > (int)date('Y') + 1) {
        $errors['annee'] = 'Année invalide.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO albums (nom_cd, artiste, annee_sortie) VALUES (:titre, :artiste, :annee)'
            );
            $stmt->execute([
                ':titre'   => $titre,
                ':artiste' => $artiste,
                ':annee'   => $annee,
            ]);

            $successMessage = 'Album ajouté avec succès.';
            // MF: clear the form after a successful insert
            $titre = '';
            $artiste = '';
            $annee = '';

        } catch (PDOException $e) {
            $errors['global'] = 'Erreur lors de l’enregistrement de l’album.';
        }
    }
}

$hideHeader = false;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Ajouter un album</h1>
        <p class="page-description">
            Saisis le titre, l’artiste et l’année de sortie pour ajouter un album au catalogue.
        </p>
    </div>

    <a href="liste_albums.php" class="btn btn-secondary">
        Retour à la liste
    </a>
</div>

<?php if (!empty($errors['global'])): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($errors['global']); ?>
    </div>
<?php endif; ?>

<?php if ($successMessage): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMessage); ?>
    </div>
<?php endif; ?>

<section class="page-section">
    <div class="form-layout">
        <form action="ajout_album.php" method="post">
            <?php echo csrf_input(); ?>
            <div class="form-group <?= isset($errors['titre']) ? 'error' : ''; ?>">
                <label for="titre" class="form-label">Titre de l’album</label>
                <input
                    type="text"
                    id="titre"
                    name="titre"
                    class="form-control"
                    value="<?= htmlspecialchars($titre); ?>"
                    placeholder="Ex : Random Access Memories"
                >
                <?php if (isset($errors['titre'])): ?>
                    <div class="form-error">
                        <?= htmlspecialchars($errors['titre']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group <?= isset($errors['artiste']) ? 'error' : ''; ?>">
                <label for="artiste" class="form-label">Artiste</label>
                <input
                    type="text"
                    id="artiste"
                    name="artiste"
                    class="form-control"
                    value="<?= htmlspecialchars($artiste); ?>"
                    placeholder="Ex : Daft Punk"
                >
                <?php if (isset($errors['artiste'])): ?>
                    <div class="form-error">
                        <?= htmlspecialchars($errors['artiste']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group <?= isset($errors['annee']) ? 'error' : ''; ?>">
                <label for="annee" class="form-label">Année de sortie</label>
                <input
                    type="number"
                    id="annee"
                    name="annee"
                    class="form-control"
                    value="<?= htmlspecialchars($annee); ?>"
                    placeholder="Ex : 2013"
                >
                <?php if (isset($errors['annee'])): ?>
                    <div class="form-error">
                        <?= htmlspecialchars($errors['annee']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Enregistrer l’album
                </button>
                <a href="liste_albums.php" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</section>

<?php
require_once __DIR__ . '/../includes/footer.php';

