<?php

declare(strict_types=1);

$footerProjects = projects(6);
?>
        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <img src="assets/logo 1.png" class="footer-logo" alt="<?= e(setting('site_name', 'QUORION')) ?>">
                        <h5 class="text-white mb-4">Nous contacter</h5>
                        <p><i class="fa fa-map-marker-alt me-3"></i><?= e(setting('address')) ?></p>
                        <p><i class="fa fa-phone-alt me-3"></i><?= e(setting('phone')) ?></p>
                        <p><i class="fa fa-envelope me-3"></i><?= e(setting('email')) ?></p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href="<?= e(setting('twitter_url', '#')) ?>"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?= e(setting('facebook_url', '#')) ?>"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?= e(setting('youtube_url', '#')) ?>"><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?= e(setting('instagram_url', '#')) ?>"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href="<?= e(setting('linkedin_url', '#')) ?>"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Liens rapides</h5>
                        <a class="btn btn-link" href="about.php">À propos</a>
                        <a class="btn btn-link" href="service.php">Nos services</a>
                        <a class="btn btn-link" href="project.php">Nos projets</a>
                        <a class="btn btn-link" href="contact.php">Nous contacter</a>
                        <a class="btn btn-link" href="admin/login.php">Administration</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Galerie de projets</h5>
                        <div class="row g-2">
                            <?php foreach ($footerProjects as $project): ?>
                            <div class="col-4">
                                <img class="img-fluid" src="<?= e($project['image_path']) ?>" alt="<?= e($project['title']) ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p><?= e(setting('newsletter_text')) ?></p>
                        <form action="subscribe.php" method="post" class="position-relative w-100 mt-3">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" name="email" type="email" placeholder="Votre e-mail" aria-label="Votre e-mail" required style="height: 48px;">
                            <button type="submit" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="index.php"><?= e(setting('site_name', 'QUORION')) ?></a>, tous droits réservés.
                            Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="index.php">Accueil</a>
                                <a href="contact.php">Contact</a>
                                <a href="admin/login.php">Admin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="SeoMaster/lib/wow/wow.min.js"></script>
    <script src="SeoMaster/lib/easing/easing.min.js"></script>
    <script src="SeoMaster/lib/waypoints/waypoints.min.js"></script>

    <!-- Template Javascript -->
    <script src="SeoMaster/js/main.js"></script>
</body>

</html>
