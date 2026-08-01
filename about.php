<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$currentPage = 'about';
$pageTitle = 'À propos';
$pageHeaderTitle = 'À propos de QUORION';
$about = content_block('about');
$blocks = [content_block('mission'), content_block('vision'), content_block('approach')];
$why = content_block('why');
$signature = content_block('signature');
$memberList = members();

require __DIR__ . '/partials/header.php';
?>
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
                <div class="row g-4">
                    <?php foreach ($blocks as $index => $block): ?>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="<?= e(number_format(0.1 + ($index * 0.2), 1)) ?>s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0"><i class="fa fa-check fa-2x"></i></div>
                            <h5 class="mb-3"><?= e($block['title']) ?></h5>
                            <p><?= e($block['content']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Service End -->

        <!-- Why Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-2">
                            <h6 class="position-relative text-primary ps-4"><?= e($why['eyebrow']) ?></h6>
                            <h2 class="mt-2"><?= e($why['title']) ?></h2>
                        </div>
                        <p class="mb-4"><?= e($why['content']) ?></p>
                        <p class="mb-0"><strong><?= e($signature['title']) ?></strong><br><?= e($signature['content']) ?></p>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="row g-3">
                            <?php foreach (company_values() as $value): ?>
                            <div class="col-sm-6">
                                <h6 class="mb-2"><i class="fa <?= e($value['icon']) ?> text-primary me-2"></i><?= e($value['title']) ?></h6>
                                <p class="mb-3"><?= e($value['description']) ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Why End -->
<?php require __DIR__ . '/partials/members-section.php'; ?>
<?php require __DIR__ . '/partials/footer.php'; ?>
