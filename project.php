<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$currentPage = 'projects';
$pageTitle = 'Projets';
$pageHeaderTitle = 'Nos projets';
$projectList = projects();

require __DIR__ . '/partials/header.php';
?>
        <!-- Portfolio Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Nos projets</h6>
                    <h2 class="mt-2">Des solutions pensées pour produire des résultats concrets</h2>
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
