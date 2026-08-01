<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();
$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash('error', 'Veuillez saisir une adresse e-mail valide pour la newsletter.');
    redirect('index.php');
}

$statement = db()->prepare('INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)');
$statement->execute([$email]);
flash('success', 'Votre inscription à la newsletter est confirmée.');
redirect('index.php');
