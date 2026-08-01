<?php

declare(strict_types=1);

$memberList = $memberList ?? members();
?>
        <?php if ($memberList): ?>
        <!-- Team Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Notre équipe</h6>
                    <h2 class="mt-2">Les membres de QUORION</h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($memberList as $index => $member): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= e(number_format(0.1 + (($index % 3) * 0.2), 1)) ?>s">
                        <div class="team-item bg-light rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?= e($member['image_path']) ?>" alt="<?= e($member['name']) ?>">
                                <div class="team-social">
                                    <?php if ($member['facebook_url'] !== ''): ?><a class="btn btn-lg-square btn-primary rounded-circle mx-1" href="<?= e($member['facebook_url']) ?>"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                                    <?php if ($member['twitter_url'] !== ''): ?><a class="btn btn-lg-square btn-primary rounded-circle mx-1" href="<?= e($member['twitter_url']) ?>"><i class="fab fa-twitter"></i></a><?php endif; ?>
                                    <?php if ($member['instagram_url'] !== ''): ?><a class="btn btn-lg-square btn-primary rounded-circle mx-1" href="<?= e($member['instagram_url']) ?>"><i class="fab fa-instagram"></i></a><?php endif; ?>
                                    <?php if ($member['linkedin_url'] !== ''): ?><a class="btn btn-lg-square btn-primary rounded-circle mx-1" href="<?= e($member['linkedin_url']) ?>"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                                </div>
                            </div>
                            <div class="text-center p-4">
                                <h5><?= e($member['name']) ?></h5>
                                <span><?= e($member['position']) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Team End -->
        <?php endif; ?>
