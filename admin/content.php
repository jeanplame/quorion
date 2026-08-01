<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';

    if ($action === 'save_settings') {
        $keys = ['site_name', 'meta_description', 'hero_title', 'hero_text', 'hero_primary_button', 'hero_secondary_button', 'address', 'phone', 'email', 'newsletter_text', 'twitter_url', 'facebook_url', 'youtube_url', 'instagram_url', 'linkedin_url'];
        $statement = db()->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
        foreach ($keys as $key) {
            $statement->execute([$key, trim($_POST[$key] ?? '')]);
        }
        flash('success', 'Les paramètres du site ont été enregistrés.');
    }

    if ($action === 'save_block') {
        $keys = ['about', 'mission', 'vision', 'approach', 'why', 'signature'];
        $key = $_POST['block_key'] ?? '';
        if (in_array($key, $keys, true)) {
            $statement = db()->prepare('UPDATE content_blocks SET eyebrow = ?, title = ?, content = ?, image_path = ?, button_text = ?, button_url = ? WHERE block_key = ?');
            $statement->execute([
                trim($_POST['eyebrow'] ?? ''), trim($_POST['title'] ?? ''), trim($_POST['content'] ?? ''),
                trim($_POST['image_path'] ?? ''), trim($_POST['button_text'] ?? ''), trim($_POST['button_url'] ?? ''), $key,
            ]);
            flash('success', 'Le bloc de contenu a été enregistré.');
        }
    }

    if ($action === 'save_value') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [trim($_POST['icon'] ?? 'fa-check'), trim($_POST['title'] ?? ''), trim($_POST['description'] ?? ''), (int) ($_POST['display_order'] ?? 0), isset($_POST['is_active']) ? 1 : 0];
        if ($data[1] !== '' && $data[2] !== '') {
            if ($id > 0) {
                $statement = db()->prepare('UPDATE company_values SET icon = ?, title = ?, description = ?, display_order = ?, is_active = ? WHERE id = ?');
                $statement->execute([...$data, $id]);
            } else {
                $statement = db()->prepare('INSERT INTO company_values (icon, title, description, display_order, is_active) VALUES (?, ?, ?, ?, ?)');
                $statement->execute($data);
            }
            flash('success', 'La valeur a été enregistrée.');
        }
    }

    if ($action === 'delete_value') {
        db()->prepare('DELETE FROM company_values WHERE id = ?')->execute([(int) ($_POST['id'] ?? 0)]);
        flash('success', 'La valeur a été supprimée.');
    }

    redirect('content.php');
}

$settings = site_settings();
$blocks = db()->query('SELECT * FROM content_blocks ORDER BY id')->fetchAll();
$values = db()->query('SELECT * FROM company_values ORDER BY display_order, id')->fetchAll();
$settingLabels = [
    'site_name' => 'Nom du site', 'meta_description' => 'Méta-description', 'hero_title' => 'Titre principal', 'hero_text' => 'Texte principal',
    'hero_primary_button' => 'Bouton principal', 'hero_secondary_button' => 'Bouton secondaire', 'address' => 'Adresse', 'phone' => 'Téléphone',
    'email' => 'E-mail', 'newsletter_text' => 'Texte newsletter', 'twitter_url' => 'URL X / Twitter', 'facebook_url' => 'URL Facebook',
    'youtube_url' => 'URL YouTube', 'instagram_url' => 'URL Instagram', 'linkedin_url' => 'URL LinkedIn',
];

admin_header('Contenus et paramètres');
admin_flash();
?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white"><strong>Paramètres généraux</strong></div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save_settings">
                    <div class="row g-3">
                    <?php foreach ($settingLabels as $key => $label): ?>
                        <div class="col-md-<?= in_array($key, ['meta_description', 'hero_title', 'hero_text', 'newsletter_text'], true) ? '12' : '6' ?>">
                            <label class="form-label" for="<?= e($key) ?>"><?= e($label) ?></label>
                            <?php if (in_array($key, ['meta_description', 'hero_title', 'hero_text', 'newsletter_text'], true)): ?>
                            <textarea class="form-control" id="<?= e($key) ?>" name="<?= e($key) ?>" rows="<?= $key === 'hero_text' ? '3' : '2' ?>"><?= e($settings[$key] ?? '') ?></textarea>
                            <?php else: ?>
                            <input class="form-control" id="<?= e($key) ?>" name="<?= e($key) ?>" value="<?= e($settings[$key] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <button class="btn btn-primary mt-4" type="submit">Enregistrer les paramètres</button>
                </form>
            </div>
        </div>

        <h2 class="h4 mb-3">Blocs de contenu</h2>
        <?php foreach ($blocks as $block): ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white"><strong><?= e(ucfirst($block['block_key'])) ?></strong></div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save_block"><input type="hidden" name="block_key" value="<?= e($block['block_key']) ?>">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Surtitre</label><input class="form-control" name="eyebrow" value="<?= e($block['eyebrow']) ?>"></div>
                        <div class="col-md-8"><label class="form-label">Titre</label><input class="form-control" name="title" value="<?= e($block['title']) ?>"></div>
                        <div class="col-12"><label class="form-label">Texte</label><textarea class="form-control" name="content" rows="4"><?= e($block['content']) ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Chemin image</label><input class="form-control" name="image_path" value="<?= e($block['image_path']) ?>"></div>
                        <div class="col-md-3"><label class="form-label">Texte bouton</label><input class="form-control" name="button_text" value="<?= e($block['button_text']) ?>"></div>
                        <div class="col-md-3"><label class="form-label">Lien bouton</label><input class="form-control" name="button_url" value="<?= e($block['button_url']) ?>"></div>
                    </div>
                    <button class="btn btn-outline-primary mt-3" type="submit">Enregistrer ce bloc</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>

        <h2 class="h4 mb-3">Valeurs</h2>
        <?php foreach ($values as $value): ?>
        <div class="card shadow-sm border-0 mb-3"><div class="card-body">
            <form method="post" class="row g-3 align-items-end">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save_value"><input type="hidden" name="id" value="<?= e((string) $value['id']) ?>">
                <div class="col-md-2"><label class="form-label">Icône Font Awesome</label><input class="form-control" name="icon" value="<?= e($value['icon']) ?>"></div>
                <div class="col-md-3"><label class="form-label">Nom</label><input class="form-control" name="title" value="<?= e($value['title']) ?>" required></div>
                <div class="col-md-4"><label class="form-label">Description</label><input class="form-control" name="description" value="<?= e($value['description']) ?>" required></div>
                <div class="col-md-1"><label class="form-label">Ordre</label><input class="form-control" name="display_order" type="number" value="<?= e((string) $value['display_order']) ?>"></div>
                <div class="col-md-1"><div class="form-check"><input class="form-check-input" id="value-<?= e((string) $value['id']) ?>" name="is_active" type="checkbox" <?= $value['is_active'] ? 'checked' : '' ?>><label class="form-check-label" for="value-<?= e((string) $value['id']) ?>">Actif</label></div></div>
                <div class="col-md-1"><button class="btn btn-outline-primary w-100" type="submit">Sauver</button></div>
            </form>
            <form method="post" class="mt-2"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete_value"><input type="hidden" name="id" value="<?= e((string) $value['id']) ?>"><button class="btn btn-sm btn-link text-danger p-0" type="submit" onclick="return confirm('Supprimer cette valeur ?')">Supprimer</button></form>
        </div></div>
        <?php endforeach; ?>
        <div class="card shadow-sm border-0"><div class="card-body">
            <h3 class="h5">Ajouter une valeur</h3>
            <form method="post" class="row g-3 align-items-end">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save_value">
                <div class="col-md-2"><label class="form-label">Icône</label><input class="form-control" name="icon" value="fa-check"></div><div class="col-md-3"><label class="form-label">Nom</label><input class="form-control" name="title" required></div><div class="col-md-4"><label class="form-label">Description</label><input class="form-control" name="description" required></div><div class="col-md-1"><label class="form-label">Ordre</label><input class="form-control" name="display_order" type="number" value="10"></div><div class="col-md-1"><div class="form-check"><input class="form-check-input" id="new-active" name="is_active" type="checkbox" checked><label class="form-check-label" for="new-active">Actif</label></div></div><div class="col-md-1"><button class="btn btn-primary w-100" type="submit">Ajouter</button></div>
            </form>
        </div></div>
<?php admin_footer(); ?>
