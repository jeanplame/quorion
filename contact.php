<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') {
        flash('error', 'Merci de compléter tous les champs avec une adresse e-mail valide.');
    } else {
        $statement = db()->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
        $statement->execute([$name, $email, $subject, $message]);
        flash('success', 'Votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }

    redirect('contact.php');
}

$currentPage = 'contact';
$pageTitle = 'Contact';
$pageHeaderTitle = 'Nous contacter';
$success = flash('success');
$error = flash('error');

require __DIR__ . '/partials/header.php';
?>
        <!-- Contact Start -->
        <div class="container-fluid py-5">
            <div class="container px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                            <h6 class="position-relative d-inline text-primary ps-4">Contact</h6>
                            <h2 class="mt-2">Parlons de votre projet</h2>
                        </div>
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <?php if ($success): ?><div class="alert alert-success" role="alert"><?= e($success) ?></div><?php endif; ?>
                            <?php if ($error): ?><div class="alert alert-danger" role="alert"><?= e($error) ?></div><?php endif; ?>
                            <h4 class="text-center mb-4">Expliquez-nous votre défi : nous vous aiderons à le transformer en opportunité.</h4>
                            <form method="post" action="contact.php">
                                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Votre nom" maxlength="160" required>
                                            <label for="name">Votre nom</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Votre e-mail" maxlength="190" required>
                                            <label for="email">Votre e-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Objet" maxlength="255" required>
                                            <label for="subject">Objet</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="message" placeholder="Votre message" id="message" style="height: 150px" required></textarea>
                                            <label for="message">Votre message</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Envoyer le message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
<?php require __DIR__ . '/partials/footer.php'; ?>
