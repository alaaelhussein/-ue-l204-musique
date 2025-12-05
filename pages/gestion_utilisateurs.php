<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
if (!$isAdmin) {
    header('Location: liste_albums.php');
    exit;
}

/* Connexion BDD commune */
require_once __DIR__ . '/../includes/db.php';

$errors = [];
$successMessage = null;

// Valeurs pour le formulaire d'ajout
$identifiant = '';
$role        = 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    /* ---------- Création d'un utilisateur ---------- */
    if ($action === 'create') {
        $identifiant = trim($_POST['identifiant'] ?? '');
        $motdepasse  = $_POST['motdepasse'] ?? '';
        $role        = $_POST['role'] ?? 'user';

        if ($identifiant === '') {
            $errors['identifiant'] = 'L’identifiant est obligatoire.';
        }

        if ($motdepasse === '') {
            $errors['motdepasse'] = 'Le mot de passe est obligatoire.';
        } elseif (strlen($motdepasse) < 4) {
            $errors['motdepasse'] = 'Le mot de passe doit contenir au moins 4 caractères.';
        }

        if ($role !== 'admin' && $role !== 'user') {
            $role = 'user';
        }

        // Vérifier si l'identifiant existe déjà
        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare('SELECT id FROM utilisateurs WHERE identifiant = :identifiant');
                $stmt->execute([':identifiant' => $identifiant]);
                if ($stmt->fetch()) {
                    $errors['identifiant'] = 'Cet identifiant existe déjà.';
                }
            } catch (PDOException $e) {
                $errors['global'] = 'Erreur lors de la vérification de l’identifiant.';
            }
        }

        if (empty($errors)) {
            try {
                $hash = password_hash($motdepasse, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    'INSERT INTO utilisateurs (identifiant, motdepasse, role)
                     VALUES (:identifiant, :motdepasse, :role)'
                );
                $stmt->execute([
                    ':identifiant' => $identifiant,
                    ':motdepasse'  => $hash,
                    ':role'        => $role,
                ]);

                $successMessage = 'Utilisateur créé.';
                $identifiant    = '';
                $role           = 'user';
            } catch (PDOException $e) {
                $errors['global'] = 'Erreur lors de la création de l’utilisateur.';
            }
        }

    /* ---------- Suppression d'un utilisateur ---------- */
    } elseif ($action === 'delete') {
        $deleteId = (int)($_POST['user_id'] ?? 0);

        if ($deleteId > 0) {
            try {
                $stmt = $pdo->prepare('DELETE FROM utilisateurs WHERE id = :id');
                $stmt->execute([':id' => $deleteId]);
                $successMessage = 'Utilisateur supprimé.';
            } catch (PDOException $e) {
                $errors['global'] = 'Impossible de supprimer cet utilisateur.';
            }
        }
    }
}

// Récupération de la liste des utilisateurs
try {
    $stmt = $pdo->query('SELECT id, identifiant, role FROM utilisateurs ORDER BY identifiant ASC');
    $utilisateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    $utilisateurs = [];
    $errors['global'] = 'Erreur lors de la récupération des utilisateurs.';
}

$hideHeader = false;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Gestion des utilisateurs</h1>
        <p class="page-description">
            Ajoute des comptes et attribue un rôle <code>admin</code> ou <code>user</code>.
        </p>
    </div>

    <a href="liste_albums.php" class="btn btn-secondary">
        Retour aux albums
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

<!-- Section : création d'utilisateur -->
<section class="page-section">
    <div class="form-layout">
        <h2 class="section-title">Ajouter un utilisateur</h2>

        <form action="gestion_utilisateurs.php" method="post">
            <input type="hidden" name="action" value="create">

            <div class="form-group <?= isset($errors['identifiant']) ? 'error' : ''; ?>">
                <label for="identifiant" class="form-label">Identifiant</label>
                <input
                    type="text"
                    id="identifiant"
                    name="identifiant"
                    class="form-control"
                    value="<?= htmlspecialchars($identifiant); ?>"
                    placeholder="Ex : Utilisateur2"
                >
                <?php if (isset($errors['identifiant'])): ?>
                    <div class="form-error">
                        <?= htmlspecialchars($errors['identifiant']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group <?= isset($errors['motdepasse']) ? 'error' : ''; ?>">
                <label for="motdepasse" class="form-label">Mot de passe</label>
                <input
                    type="password"
                    id="motdepasse"
                    name="motdepasse"
                    class="form-control"
                    placeholder="Mot de passe"
                >
                <?php if (isset($errors['motdepasse'])): ?>
                    <div class="form-error">
                        <?= htmlspecialchars($errors['motdepasse']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Rôle</label>
                <select id="role" name="role" class="form-control">
                    <option value="user" <?= $role === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                    <option value="admin" <?= $role === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Créer l’utilisateur
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Section : liste des utilisateurs -->
<section class="page-section">
    <h2 class="section-title">Liste des utilisateurs</h2>

    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>Identifiant</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($utilisateurs)): ?>
                <tr>
                    <td colspan="3">Aucun utilisateur.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($utilisateurs as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['identifiant']); ?></td>
                        <td>
                            <span class="role-badge <?= $u['role'] === 'admin' ? 'role-badge--admin' : 'role-badge--user'; ?>">
                                <?= htmlspecialchars($u['role']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <form action="gestion_utilisateurs.php" method="post"
                                      onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="<?= (int)$u['id']; ?>">
                                    <button type="submit" class="btn btn-danger">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
require_once __DIR__ . '/../includes/footer.php';
