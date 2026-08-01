<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$currentPage = 'services';
$pageTitle = 'Services';
$pageHeaderTitle = 'Nos services';
$serviceList = services();

require __DIR__ . '/partials/header.php';
?>
        <!-- Service Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Nos expertises</h6>
                    <h2 class="mt-2">Des solutions numériques adaptées à vos réalités</h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($serviceList as $index => $service): ?>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="<?= e(number_format(0.1 + (($index % 3) * 0.2), 1)) ?>s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0"><i class="fa <?= e($service['icon']) ?> fa-2x"></i></div>
                            <h5 class="mb-3"><?= e($service['title']) ?></h5>
                            <p><?= e($service['description']) ?></p>
                            <a class="btn px-3 mt-auto mx-auto" href="contact.php">Parlons-en</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Service End -->
<?php require __DIR__ . '/partials/footer.php'; ?>
