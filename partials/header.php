<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? setting('site_name', 'QUORION');
$currentPage = $currentPage ?? 'home';
$isHome = $isHome ?? false;
$pageHeaderTitle = $pageHeaderTitle ?? $pageTitle;
$settings = site_settings();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title><?= e($pageTitle) ?> - <?= e(setting('site_name', 'QUORION')) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="solutions digitales, logiciels sur mesure, applications mobiles" name="keywords">
    <meta content="<?= e(setting('meta_description')) ?>" name="description">

    <!-- Favicon -->
    <link href="SeoMaster/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="SeoMaster/lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="SeoMaster/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="SeoMaster/css/style.css" rel="stylesheet">

    <!-- QUORION brand theme -->
    <link href="assets/quorion.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Chargement</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0" style="background:white !important;">
                <a href="index.php" class="navbar-brand p-0">
                    <img src="assets/logo 1.png" class="quorion-logo" alt="<?= e(setting('site_name', 'QUORION')) ?>">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a style="color: #0B1738 !important;" href="index.php" class="nav-item nav-link <?= $currentPage === 'home' ? 'active' : '' ?>">Accueil</a>
                        <a style="color: #0B1738 !important;" href="about.php" class="nav-item nav-link <?= $currentPage === 'about' ? 'active' : '' ?>">À propos</a>
                        <a style="color: #0B1738 !important;" href="service.php" class="nav-item nav-link <?= $currentPage === 'services' ? 'active' : '' ?>">Services</a>
                        <a style="color: #0B1738 !important;" href="project.php" class="nav-item nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">Projets</a>
                        <a style="color: #0B1738 !important;" href="contact.php" class="nav-item nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a>
                    </div>
                    <a href="contact.php" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Demander un devis</a>
                </div>
            </nav>

            <?php if ($isHome): ?>
            <div class="container-fluid py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn"><?= e(setting('hero_title')) ?></h1>
                            <p class="text-white pb-3 animated zoomIn"><?= e(setting('hero_text')) ?></p>
                            <a href="service.php" class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft"><?= e(setting('hero_primary_button', 'Nos solutions')) ?></a>
                            <a href="contact.php" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight"><?= e(setting('hero_secondary_button', 'Nous contacter')) ?></a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid" src="SeoMaster/img/hero.png" alt="Solutions digitales QUORION">
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="container-fluid py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-12 text-center">
                            <h1 class="text-white animated zoomIn"><?= e($pageHeaderTitle) ?></h1>
                            <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Accueil</a></li>
                                    <li class="breadcrumb-item text-white active" aria-current="page"><?= e($pageHeaderTitle) ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!-- Navbar & Hero End -->
