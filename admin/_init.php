<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

function admin_header(string $title): void
{
    $name = $_SESSION['admin_name'] ?? 'Administrateur';
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= e($title) ?> - Administration QUORION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/quorion.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">QUORION - Administration</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="adminNavigation">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="index.php">Tableau de bord</a>
                    <a class="nav-link" href="content.php">Contenus</a>
                    <a class="nav-link" href="services.php">Services</a>
                    <a class="nav-link" href="projects.php">Projets</a>
                    <a class="nav-link" href="messages.php">Messages</a>
                    <a class="nav-link" href="subscribers.php">Newsletter</a>
                    <a class="nav-link" href="../index.php" target="_blank">Voir le site</a>
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0"><?= e($title) ?></h1>
            <span class="text-muted">Connecté : <?= e($name) ?></span>
        </div>
<?php
}

function admin_footer(): void
{
    ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}

function admin_flash(): void
{
    foreach (['success' => 'success', 'error' => 'danger'] as $name => $class) {
        $message = flash($name);
        if ($message) {
            echo '<div class="alert alert-' . $class . '" role="alert">' . e($message) . '</div>';
        }
    }
}
