<?php

declare(strict_types=1);

require_once __DIR__ . '/_init.php';
require_admin();

$counts = [
    'Services' => (int) db()->query('SELECT COUNT(*) FROM services')->fetchColumn(),
    'Projets' => (int) db()->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
    'Messages non lus' => (int) db()->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn(),
    'Abonnés newsletter' => (int) db()->query('SELECT COUNT(*) FROM newsletter_subscribers')->fetchColumn(),
];
$messages = db()->query('SELECT id, name, email, subject, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 5')->fetchAll();

admin_header('Tableau de bord');
admin_flash();
?>
        <div class="row g-4 mb-4">
            <?php foreach ($counts as $label => $count): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100"><div class="card-body"><div class="text-muted small"><?= e($label) ?></div><div class="display-6 fw-bold"><?= e((string) $count) ?></div></div></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white"><strong>Derniers messages</strong></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Nom</th><th>E-mail</th><th>Objet</th><th>Reçu le</th></tr></thead>
                    <tbody>
                    <?php foreach ($messages as $message): ?>
                    <tr><td><?= e($message['name']) ?></td><td><?= e($message['email']) ?></td><td><?= e($message['subject']) ?></td><td><?= e($message['created_at']) ?></td></tr>
                    <?php endforeach; ?>
                    <?php if (!$messages): ?><tr><td colspan="4" class="text-center text-muted py-4">Aucun message pour le moment.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php admin_footer(); ?>
