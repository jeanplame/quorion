<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    db()->prepare('DELETE FROM newsletter_subscribers WHERE id = ?')->execute([$id]);
    flash('success', 'L’abonné a été retiré.');
    redirect('subscribers.php');
}

$subscribers = db()->query('SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC')->fetchAll();

admin_header('Abonnés newsletter');
admin_flash();
?>
        <div class="card shadow-sm border-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>E-mail</th><th>Inscrit le</th><th></th></tr></thead><tbody>
            <?php foreach ($subscribers as $subscriber): ?>
            <tr><td><?= e($subscriber['email']) ?></td><td><?= e($subscriber['subscribed_at']) ?></td><td class="text-end"><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= e((string) $subscriber['id']) ?>"><button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Retirer cet abonné ?')">Retirer</button></form></td></tr>
            <?php endforeach; ?>
            <?php if (!$subscribers): ?><tr><td colspan="3" class="text-center text-muted py-4">Aucun abonné pour le moment.</td></tr><?php endif; ?>
        </tbody></table></div></div>
<?php admin_footer(); ?>
