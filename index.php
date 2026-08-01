<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$isHome = true;
$currentPage = 'home';
$pageTitle = 'Accueil';
$about = content_block('about');
$serviceList = services(6);
$projectList = projects(6);
$success = flash('success');
$error = flash('error');

require __DIR__ . '/partials/header.php';
?>
        <?php if ($success || $error): ?>
        <div class="container px-lg-5 mt-4">
            <?php if ($success): ?><div class="alert alert-success mb-0" role="alert"><?= e($success) ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger mb-0" role="alert"><?= e($error) ?></div><?php endif; ?>
        </div>
        <?php endif; ?>
        <!-- About Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-2">
                            <h6 class="position-relative text-primary ps-4"><?= e($about['eyebrow']) ?></h6>
                            <h2 class="mt-2"><?= e($about['title']) ?></h2>
                        </div>
                        <p class="mb-4"><?= e($about['content']) ?></p>
                        <div class="row g-3">
                            <?php foreach (array_slice(company_values(), 0, 4) as $value): ?>
                            <div class="col-sm-6">
                                <h6 class="mb-3"><i class="fa <?= e($value['icon']) ?> text-primary me-2"></i><?= e($value['title']) ?></h6>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <a class="btn btn-primary rounded-pill px-4 me-3" href="<?= e($about['button_url']) ?>"><?= e($about['button_text']) ?></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="<?= e($about['image_path']) ?>" alt="QUORION">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Service Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Nos services</h6>
                    <h2 class="mt-2">Des solutions conçues pour votre organisation</h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($serviceList as $index => $service): ?>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="<?= e(number_format(0.1 + (($index % 3) * 0.2), 1)) ?>s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa <?= e($service['icon']) ?> fa-2x"></i>
                            </div>
                            <h5 class="mb-3"><?= e($service['title']) ?></h5>
                            <p><?= e($service['description']) ?></p>
                            <a class="btn px-3 mt-auto mx-auto" href="contact.php">En savoir plus</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Service End -->

        <!-- Portfolio Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Nos projets</h6>
                    <h2 class="mt-2">Des solutions qui créent de la valeur</h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($projectList as $index => $project): ?>
                    <div class="col-lg-4 col-md-6 portfolio-item wow zoomIn" data-wow-delay="<?= e(number_format(0.1 + (($index % 3) * 0.2), 1)) ?>s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="<?= e($project['image_path']) ?>" alt="<?= e($project['title']) ?>">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="<?= e($project['image_path']) ?>"><i class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i><?= e($project['category']) ?></small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="<?= e($project['project_url'] ?: 'contact.php') ?>"><?= e($project['title']) ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Portfolio End -->
<?php require __DIR__ . '/partials/footer.php'; ?>
