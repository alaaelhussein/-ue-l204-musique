<?php
require_once __DIR__ . '/../includes/bootstrap.php';

// MF: admin page to edit an album (update + delete)
// MF: responsibilities: load by id, validate input, run update/delete queries, show feedback

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

// MF: album id from query string
$albumId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$albumId) {
    header('Location: liste_albums.php');
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    csrf_require_post();
}

// MF: delete action (post)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    try {
        $stmt = $pdo->prepare('DELETE FROM albums WHERE id = :id');
        $stmt->execute([':id' => $albumId]);

        header('Location: liste_albums.php?deleted=1');
        exit;
    } catch (PDOException $e) {
        $errors['global'] = 'Impossible de supprimer cet album.';
    }
}

// MF: values displayed in the form
$titre   = '';
$artiste = '';
$annee   = '';

// MF: load album row
try {
    $stmt = $pdo->prepare('SELECT nom_cd, artiste, annee_sortie FROM albums WHERE id = :id');
    $stmt->execute([':id' => $albumId]);
    $album = $stmt->fetch();
} catch (PDOException $e) {
    $album = false;
}

if (!$album) {
    $errors['global'] = 'Album introuvable.';
} else {
    $titre   = $album['nom_cd'];
    $artiste = $album['artiste'];
    $annee   = $album['annee_sortie'];
}

// MF: save action (post)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && $album) {

    $titre   = trim($_POST['titre'] ?? '');
    $artiste = trim($_POST['artiste'] ?? '');
    $annee   = trim($_POST['annee'] ?? '');

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
                'UPDATE albums
                 SET nom_cd = :titre, artiste = :artiste, annee_sortie = :annee
                 WHERE id = :id'
            );
            $stmt->execute([
                ':titre'   => $titre,
                ':artiste' => $artiste,
                ':annee'   => $annee,
                ':id'      => $albumId,
            ]);

            $successMessage = 'Album mis à jour.';
        } catch (PDOException $e) {
            $errors['global'] = 'Erreur lors de la mise à jour de l’album.';
        }
    }
}

$hideHeader = false;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Modifier l’album</h1>
        <p class="page-description">
            Mets à jour le titre, l’artiste ou l’année de sortie de cet album.
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

<?php if ($album): ?>
<section class="page-section">
    <div class="form-layout">
        <form action="edition_album.php?id=<?= (int)$albumId; ?>" method="post">
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
                <button type="submit" name="action" value="save" class="btn btn-primary">
                    Enregistrer les modifications
                </button>

                <button type="submit"
                        name="action"
                        value="delete"
                        class="btn btn-danger"
                        onclick="return confirm('Supprimer définitivement cet album ?');">
                    Supprimer cet album
                </button>

                <a href="liste_albums.php" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
        </form>
    </div>
</section>
<?php endif; ?>

<?php
require_once __DIR__ . '/../includes/footer.php';

