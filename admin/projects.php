<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'save') {
        $data = [trim($_POST['category'] ?? ''), trim($_POST['title'] ?? ''), trim($_POST['image_path'] ?? ''), trim($_POST['project_url'] ?? ''), (int) ($_POST['display_order'] ?? 0), isset($_POST['is_active']) ? 1 : 0];
        if ($data[0] !== '' && $data[1] !== '' && $data[2] !== '') {
            if ($id > 0) {
                db()->prepare('UPDATE projects SET category = ?, title = ?, image_path = ?, project_url = ?, display_order = ?, is_active = ? WHERE id = ?')->execute([...$data, $id]);
            } else {
                db()->prepare('INSERT INTO projects (category, title, image_path, project_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?)')->execute($data);
            }
            flash('success', 'Le projet a été enregistré.');
        } else {
            flash('error', 'La catégorie, le titre et le chemin de l’image sont obligatoires.');
        }
    }

    if ($action === 'delete' && $id > 0) {
        db()->prepare('DELETE FROM projects WHERE id = ?')->execute([$id]);
        flash('success', 'Le projet a été supprimé.');
    }
    redirect('projects.php');
}

$edit = ['id' => '', 'category' => '', 'title' => '', 'image_path' => 'SeoMaster/img/portfolio-1.jpg', 'project_url' => '', 'display_order' => 10, 'is_active' => 1];
if (isset($_GET['edit'])) {
    $statement = db()->prepare('SELECT * FROM projects WHERE id = ?');
    $statement->execute([(int) $_GET['edit']]);
    $edit = $statement->fetch() ?: $edit;
}
$items = db()->query('SELECT * FROM projects ORDER BY display_order, id')->fetchAll();

admin_header('Projets');
admin_flash();
?>
        <div class="card shadow-sm border-0 mb-4"><div class="card-body">
            <h2 class="h5 mb-3"><?= $edit['id'] ? 'Modifier le projet' : 'Ajouter un projet' ?></h2>
            <form method="post" class="row g-3">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= e((string) $edit['id']) ?>">
                <div class="col-md-4"><label class="form-label">Catégorie</label><input class="form-control" name="category" value="<?= e($edit['category']) ?>" maxlength="160" required></div>
                <div class="col-md-5"><label class="form-label">Titre</label><input class="form-control" name="title" value="<?= e($edit['title']) ?>" maxlength="160" required></div>
                <div class="col-md-2"><label class="form-label">Ordre</label><input class="form-control" name="display_order" type="number" value="<?= e((string) $edit['display_order']) ?>" required></div>
                <div class="col-md-1 d-flex align-items-end"><div class="form-check mb-2"><input class="form-check-input" id="active" name="is_active" type="checkbox" <?= $edit['is_active'] ? 'checked' : '' ?>><label class="form-check-label" for="active">Actif</label></div></div>
                <div class="col-md-6"><label class="form-label">Chemin de l’image</label><input class="form-control" name="image_path" value="<?= e($edit['image_path']) ?>" required></div>
                <div class="col-md-6"><label class="form-label">Lien du projet (facultatif)</label><input class="form-control" name="project_url" value="<?= e($edit['project_url']) ?>"></div>
                <div class="col-12"><button class="btn btn-primary" type="submit">Enregistrer</button><?php if ($edit['id']): ?> <a class="btn btn-link" href="projects.php">Annuler</a><?php endif; ?></div>
            </form>
        </div></div>
        <div class="card shadow-sm border-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Aperçu</th><th>Catégorie</th><th>Titre</th><th>Ordre</th><th>Statut</th><th></th></tr></thead><tbody>
            <?php foreach ($items as $item): ?>
            <tr><td><img src="../<?= e($item['image_path']) ?>" alt="" width="70" height="45" class="object-fit-cover"></td><td><?= e($item['category']) ?></td><td><?= e($item['title']) ?></td><td><?= e((string) $item['display_order']) ?></td><td><?= $item['is_active'] ? 'Actif' : 'Masqué' ?></td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="projects.php?edit=<?= e((string) $item['id']) ?>">Modifier</a> <form method="post" class="d-inline"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e((string) $item['id']) ?>"><button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Supprimer ce projet ?')">Supprimer</button></form></td></tr>
            <?php endforeach; ?>
        </tbody></table></div></div>
<?php admin_footer(); ?>
