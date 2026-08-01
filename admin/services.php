<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'save') {
        $data = [trim($_POST['icon'] ?? 'fa-laptop-code'), trim($_POST['title'] ?? ''), trim($_POST['description'] ?? ''), (int) ($_POST['display_order'] ?? 0), isset($_POST['is_active']) ? 1 : 0];
        if ($data[1] !== '' && $data[2] !== '') {
            if ($id > 0) {
                db()->prepare('UPDATE services SET icon = ?, title = ?, description = ?, display_order = ?, is_active = ? WHERE id = ?')->execute([...$data, $id]);
            } else {
                db()->prepare('INSERT INTO services (icon, title, description, display_order, is_active) VALUES (?, ?, ?, ?, ?)')->execute($data);
            }
            flash('success', 'Le service a été enregistré.');
        } else {
            flash('error', 'Le titre et la description sont obligatoires.');
        }
    }

    if ($action === 'delete' && $id > 0) {
        db()->prepare('DELETE FROM services WHERE id = ?')->execute([$id]);
        flash('success', 'Le service a été supprimé.');
    }
    redirect('services.php');
}

$edit = ['id' => '', 'icon' => 'fa-laptop-code', 'title' => '', 'description' => '', 'display_order' => 10, 'is_active' => 1];
if (isset($_GET['edit'])) {
    $statement = db()->prepare('SELECT * FROM services WHERE id = ?');
    $statement->execute([(int) $_GET['edit']]);
    $edit = $statement->fetch() ?: $edit;
}
$items = db()->query('SELECT * FROM services ORDER BY display_order, id')->fetchAll();

admin_header('Services');
admin_flash();
?>
        <div class="card shadow-sm border-0 mb-4"><div class="card-body">
            <h2 class="h5 mb-3"><?= $edit['id'] ? 'Modifier le service' : 'Ajouter un service' ?></h2>
            <form method="post" class="row g-3">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= e((string) $edit['id']) ?>">
                <div class="col-md-3"><label class="form-label">Icône Font Awesome</label><input class="form-control" name="icon" value="<?= e($edit['icon']) ?>" required></div>
                <div class="col-md-6"><label class="form-label">Titre</label><input class="form-control" name="title" value="<?= e($edit['title']) ?>" maxlength="160" required></div>
                <div class="col-md-2"><label class="form-label">Ordre</label><input class="form-control" name="display_order" type="number" value="<?= e((string) $edit['display_order']) ?>" required></div>
                <div class="col-md-1 d-flex align-items-end"><div class="form-check mb-2"><input class="form-check-input" id="active" name="is_active" type="checkbox" <?= $edit['is_active'] ? 'checked' : '' ?>><label class="form-check-label" for="active">Actif</label></div></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3" required><?= e($edit['description']) ?></textarea></div>
                <div class="col-12"><button class="btn btn-primary" type="submit">Enregistrer</button><?php if ($edit['id']): ?> <a class="btn btn-link" href="services.php">Annuler</a><?php endif; ?></div>
            </form>
        </div></div>
        <div class="card shadow-sm border-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Icône</th><th>Titre</th><th>Description</th><th>Ordre</th><th>Statut</th><th></th></tr></thead><tbody>
            <?php foreach ($items as $item): ?>
            <tr><td><i class="fa <?= e($item['icon']) ?>"></i></td><td><?= e($item['title']) ?></td><td><?= e($item['description']) ?></td><td><?= e((string) $item['display_order']) ?></td><td><?= $item['is_active'] ? 'Actif' : 'Masqué' ?></td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="services.php?edit=<?= e((string) $item['id']) ?>">Modifier</a> <form method="post" class="d-inline"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e((string) $item['id']) ?>"><button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Supprimer ce service ?')">Supprimer</button></form></td></tr>
            <?php endforeach; ?>
        </tbody></table></div></div>
<?php admin_footer(); ?>
