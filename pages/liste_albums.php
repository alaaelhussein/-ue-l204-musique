<?php
require_once __DIR__ . '/../includes/bootstrap.php';

// MS: album catalogue page (list + search)
// MS: responsibilities: multicriteria search (title/artist/year) and admin-only delete

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// MS: db access
require_once __DIR__ . '/../includes/db.php';

// MS: admin-only delete (post)
$successMessage = null;
$errorMessage   = null;

if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    csrf_require_post();
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

// MS: filters (get)
$searchTitleArtist = trim($_GET['q'] ?? '');
$searchYear        = trim($_GET['annee'] ?? '');

// MS: lightweight server-side validation
// MS: portability note: some php installs (often wamp) may not have mbstring enabled
// MS: fallback to core string functions so the page still works everywhere
if ($searchTitleArtist !== '') {
    $queryLength = function_exists('mb_strlen')
        ? mb_strlen($searchTitleArtist, 'UTF-8')
        : strlen($searchTitleArtist);

    if ($queryLength > 100) {
        $searchTitleArtist = function_exists('mb_substr')
            ? mb_substr($searchTitleArtist, 0, 100, 'UTF-8')
            : substr($searchTitleArtist, 0, 100);

        $errorMessage = $errorMessage ?? 'La recherche est trop longue (max 100 caractères).';
    }
}

if ($searchYear !== '') {
    $currentYear = (int)date('Y') + 1;
    if (!ctype_digit($searchYear) || strlen($searchYear) !== 4 || (int)$searchYear < 1900 || (int)$searchYear > $currentYear) {
        $searchYear = '';
        $errorMessage = $errorMessage ?? 'Année de sortie invalide.';
    }
}

// MS: build sql with optional conditions
$sql = 'SELECT id, nom_cd, artiste, annee_sortie FROM albums';
$where = [];
$params = [];

if ($searchTitleArtist !== '') {
    $where[] = '(LOWER(nom_cd) LIKE :q OR LOWER(artiste) LIKE :q)';
    $qLower = function_exists('mb_strtolower')
        ? mb_strtolower($searchTitleArtist, 'UTF-8')
        : strtolower($searchTitleArtist);

    $params[':q'] = '%' . $qLower . '%';
}

if ($searchYear !== '') {
    $where[] = 'annee_sortie = :annee';
    $params[':annee'] = $searchYear;
}

if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY annee_sortie DESC, nom_cd ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$albums = $stmt->fetchAll();

// MS: render
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
            <!-- MS: small svg icon for the search field -->
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
                                    <?php echo csrf_input(); ?>
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


