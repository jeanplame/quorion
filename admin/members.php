<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'save') {
        try {
            $imagePath = upload_image('image_file', trim($_POST['current_image_path'] ?? ''));
            $data = [
                trim($_POST['name'] ?? ''),
                trim($_POST['position'] ?? ''),
                trim($_POST['bio'] ?? ''),
                $imagePath,
                trim($_POST['facebook_url'] ?? ''),
                trim($_POST['twitter_url'] ?? ''),
                trim($_POST['instagram_url'] ?? ''),
                trim($_POST['linkedin_url'] ?? ''),
                (int) ($_POST['display_order'] ?? 0),
                isset($_POST['is_active']) ? 1 : 0,
            ];

            if ($data[0] !== '' && $data[1] !== '' && $data[3] !== '') {
                if ($id > 0) {
                    db()->prepare('UPDATE team_members SET name = ?, position = ?, bio = ?, image_path = ?, facebook_url = ?, twitter_url = ?, instagram_url = ?, linkedin_url = ?, display_order = ?, is_active = ? WHERE id = ?')->execute([...$data, $id]);
                } else {
                    db()->prepare('INSERT INTO team_members (name, position, bio, image_path, facebook_url, twitter_url, instagram_url, linkedin_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')->execute($data);
                }
                flash('success', 'Le membre a été enregistré.');
            } else {
                flash('error', 'Le nom, la fonction et la photo sont obligatoires.');
            }
        } catch (RuntimeException $exception) {
            flash('error', $exception->getMessage());
        }
    }

    if ($action === 'delete' && $id > 0) {
        db()->prepare('DELETE FROM team_members WHERE id = ?')->execute([$id]);
        flash('success', 'Le membre a été supprimé.');
    }
    redirect('members.php');
}

$edit = ['id' => '', 'name' => '', 'position' => '', 'bio' => '', 'image_path' => '', 'facebook_url' => '', 'twitter_url' => '', 'instagram_url' => '', 'linkedin_url' => '', 'display_order' => 10, 'is_active' => 1];
if (isset($_GET['edit'])) {
    $statement = db()->prepare('SELECT * FROM team_members WHERE id = ?');
    $statement->execute([(int) $_GET['edit']]);
    $edit = $statement->fetch() ?: $edit;
}
$items = db()->query('SELECT * FROM team_members ORDER BY display_order, id')->fetchAll();

admin_header('Membres');
admin_flash();
?>
        <div class="card shadow-sm border-0 mb-4"><div class="card-body">
            <h2 class="h5 mb-3"><?= $edit['id'] ? 'Modifier le membre' : 'Ajouter un membre' ?></h2>
            <form method="post" enctype="multipart/form-data" class="row g-3">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= e((string) $edit['id']) ?>"><input type="hidden" name="current_image_path" value="<?= e($edit['image_path']) ?>">
                <div class="col-md-4"><label class="form-label">Nom</label><input class="form-control" name="name" value="<?= e($edit['name']) ?>" maxlength="160" required></div>
                <div class="col-md-4"><label class="form-label">Fonction</label><input class="form-control" name="position" value="<?= e($edit['position']) ?>" maxlength="160" required></div>
                <div class="col-md-2"><label class="form-label">Ordre</label><input class="form-control" name="display_order" type="number" value="<?= e((string) $edit['display_order']) ?>" required></div>
                <div class="col-md-2 d-flex align-items-end"><div class="form-check mb-2"><input class="form-check-input" id="active" name="is_active" type="checkbox" <?= $edit['is_active'] ? 'checked' : '' ?>><label class="form-check-label" for="active">Actif</label></div></div>
                <div class="col-md-6"><label class="form-label">Photo</label><input class="form-control" name="image_file" type="file" accept="image/*" <?= $edit['image_path'] ? '' : 'required' ?>><?php if ($edit['image_path']): ?><div class="form-text">Photo actuelle conservée si aucun nouveau fichier n’est choisi.</div><?php endif; ?></div>
                <div class="col-md-3"><label class="form-label">Facebook</label><input class="form-control" name="facebook_url" value="<?= e($edit['facebook_url']) ?>"></div>
                <div class="col-md-3"><label class="form-label">Twitter / X</label><input class="form-control" name="twitter_url" value="<?= e($edit['twitter_url']) ?>"></div>
                <div class="col-md-3"><label class="form-label">Instagram</label><input class="form-control" name="instagram_url" value="<?= e($edit['instagram_url']) ?>"></div>
                <div class="col-md-3"><label class="form-label">LinkedIn</label><input class="form-control" name="linkedin_url" value="<?= e($edit['linkedin_url']) ?>"></div>
                <div class="col-12"><label class="form-label">Présentation courte</label><textarea class="form-control" name="bio" rows="3"><?= e($edit['bio']) ?></textarea></div>
                <div class="col-12"><button class="btn btn-primary" type="submit">Enregistrer</button><?php if ($edit['id']): ?> <a class="btn btn-link" href="members.php">Annuler</a><?php endif; ?></div>
            </form>
        </div></div>
        <div class="card shadow-sm border-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Photo</th><th>Nom</th><th>Fonction</th><th>Ordre</th><th>Statut</th><th></th></tr></thead><tbody>
            <?php foreach ($items as $item): ?>
            <tr><td><img src="../<?= e($item['image_path']) ?>" alt="" width="70" height="45" class="object-fit-cover"></td><td><?= e($item['name']) ?></td><td><?= e($item['position']) ?></td><td><?= e((string) $item['display_order']) ?></td><td><?= $item['is_active'] ? 'Actif' : 'Masqué' ?></td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="members.php?edit=<?= e((string) $item['id']) ?>">Modifier</a> <form method="post" class="d-inline"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e((string) $item['id']) ?>"><button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Supprimer ce membre ?')">Supprimer</button></form></td></tr>
            <?php endforeach; ?>
            <?php if (!$items): ?><tr><td colspan="6" class="text-center text-muted py-4">Aucun membre pour le moment.</td></tr><?php endif; ?>
        </tbody></table></div></div>
<?php admin_footer(); ?>
