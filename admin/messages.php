<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if (($_POST['action'] ?? '') === 'read') {
        db()->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?')->execute([$id]);
        flash('success', 'Le message est marqué comme lu.');
    }
    if (($_POST['action'] ?? '') === 'delete') {
        db()->prepare('DELETE FROM contact_messages WHERE id = ?')->execute([$id]);
        flash('success', 'Le message a été supprimé.');
    }
    redirect('messages.php');
}

$messages = db()->query('SELECT * FROM contact_messages ORDER BY is_read, created_at DESC')->fetchAll();

admin_header('Messages reçus');
admin_flash();
?>
        <div class="card shadow-sm border-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Reçu le</th><th>Expéditeur</th><th>Objet et message</th><th>Statut</th><th></th></tr></thead><tbody>
            <?php foreach ($messages as $message): ?>
            <tr>
                <td><?= e($message['created_at']) ?></td>
                <td><strong><?= e($message['name']) ?></strong><br><a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></td>
                <td><strong><?= e($message['subject']) ?></strong><br><span class="text-muted"><?= nl2br(e($message['message'])) ?></span></td>
                <td><?= $message['is_read'] ? '<span class="badge bg-secondary">Lu</span>' : '<span class="badge bg-primary">Nouveau</span>' ?></td>
                <td class="text-end">
                    <?php if (!$message['is_read']): ?><form method="post" class="d-inline"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="read"><input type="hidden" name="id" value="<?= e((string) $message['id']) ?>"><button class="btn btn-sm btn-outline-primary" type="submit">Marquer lu</button></form><?php endif; ?>
                    <form method="post" class="d-inline"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e((string) $message['id']) ?>"><button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Supprimer ce message ?')">Supprimer</button></form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (!$messages): ?><tr><td colspan="5" class="text-center text-muted py-4">Aucun message reçu.</td></tr><?php endif; ?>
        </tbody></table></div></div>
<?php admin_footer(); ?>
