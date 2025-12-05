<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

/* -------------------------
   Connexion à la base
   ------------------------- */
require_once __DIR__ . '/../includes/db.php';

/* -------------------------
   Suppression d’un album (admin)
   ------------------------- */
$successMessage = null;
$errorMessage   = null;

if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];

    if ($deleteId > 0) {
        try {
            $stmt = $pdo->prepare('DELETE FROM albums WHERE id = :id');
            $stmt->execute([':id' => $deleteId]);
            $successMessage = 'Album supprimé.';
        } catch (PDOException $e) {
            $errorMessage = 'Impossible de supprimer cet album.';
        }
    }
}

/* -------------------------
   Récupération + recherche
   ------------------------- */
$searchTitleArtist = trim($_GET['q'] ?? '');
$searchYear        = trim($_GET['annee'] ?? '');

$sql = 'SELECT id, nom_cd, artiste, annee_sortie FROM albums WHERE 1';
$params = [];

if ($searchTitleArtist !== '') {
    $sql .= ' AND (LOWER(nom_cd) LIKE :q OR LOWER(artiste) LIKE :q)';
    $params[':q'] = '%' . mb_strtolower($searchTitleArtist, 'UTF-8') . '%';
}

if ($searchYear !== '') {
    $sql .= ' AND annee_sortie = :annee';
    $params[':annee'] = $searchYear;
}

$sql .= ' ORDER BY annee_sortie DESC, nom_cd ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$albums = $stmt->fetchAll();

/* -------------------------
   Affichage
   ------------------------- */
$hideHeader = false;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Catalogue des albums</h1>
        <p class="page-description">
            Recherche un album par titre, artiste ou année de sortie.
        </p>
    </div>

    <?php if ($isAdmin): ?>
        <a href="ajout_album.php" class="btn btn-primary">
            Ajouter un album
        </a>
    <?php endif; ?>
</div>

<?php if ($successMessage): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMessage); ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($errorMessage); ?>
    </div>
<?php endif; ?>

<form action="liste_albums.php" method="get" class="search-bar">
    <div class="search-with-icon">
        <label for="q" class="form-label">Titre ou artiste</label>

        <span class="search-with-icon-icon" aria-hidden="true">
            <!-- petite loupe en SVG -->
            <svg viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="6"
                        stroke="currentColor" stroke-width="1.6" fill="none" />
                <line x1="16" y1="16" x2="21" y2="21"
                      stroke="currentColor" stroke-width="1.6" />
            </svg>
        </span>

        <input
            type="text"
            id="q"
            name="q"
            class="form-control"
            placeholder="Ex : Daft Punk, Taylor Swift..."
            value="<?= htmlspecialchars($searchTitleArtist); ?>"
        >
    </div>

    <div>
        <label for="annee" class="form-label">Année de sortie</label>
        <input
            type="number"
            id="annee"
            name="annee"
            class="form-control"
            placeholder="Ex : 2013"
            value="<?= htmlspecialchars($searchYear); ?>"
        >
    </div>

    <div>
        <button type="submit" class="btn btn-primary">
            Rechercher
        </button>
    </div>
</form>

<div class="table-wrapper">
    <table class="table">
        <thead>
        <tr>
            <th>Titre de l’album</th>
            <th>Artiste</th>
            <th>Année</th>
            <?php if ($isAdmin): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($albums)): ?>
            <tr>
                <td colspan="<?= $isAdmin ? 4 : 3; ?>">
                    Aucun album trouvé.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($albums as $album): ?>
                <tr>
                    <td><?= htmlspecialchars($album['nom_cd']); ?></td>
                    <td><?= htmlspecialchars($album['artiste']); ?></td>
                    <td><?= htmlspecialchars($album['annee_sortie']); ?></td>

                    <?php if ($isAdmin): ?>
                        <td>
                            <div class="table-actions">
                                <a href="edition_album.php?id=<?= (int) $album['id']; ?>"
                                   class="btn btn-secondary">
                                    Modifier
                                </a>

                                <form action="liste_albums.php"
                                      method="post"
                                      onsubmit="return confirm('Supprimer cet album ?');">
                                    <input type="hidden" name="delete_id"
                                           value="<?= (int) $album['id']; ?>">
                                    <button type="submit" class="btn btn-danger">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require_once __DIR__ . '/../includes/footer.php'; ?>

