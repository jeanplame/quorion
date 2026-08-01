<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

session_name('quorion_session');
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function site_settings(): array
{
    static $settings = null;

    if (is_array($settings)) {
        return $settings;
    }

    $settings = [];
    foreach (db()->query('SELECT setting_key, setting_value FROM site_settings') as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    return $settings;
}

function setting(string $key, string $default = ''): string
{
    $settings = site_settings();
    return $settings[$key] ?? $default;
}

function content_block(string $key): array
{
    static $blocks = null;

    if (!is_array($blocks)) {
        $blocks = [];
        foreach (db()->query('SELECT * FROM content_blocks') as $row) {
            $blocks[$row['block_key']] = $row;
        }
    }

    return $blocks[$key] ?? [
        'eyebrow' => '',
        'title' => '',
        'content' => '',
        'image_path' => '',
        'button_text' => '',
        'button_url' => '',
    ];
}

function services(?int $limit = null): array
{
    $sql = 'SELECT * FROM services WHERE is_active = 1 ORDER BY display_order, id';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return db()->query($sql)->fetchAll();
}

function projects(?int $limit = null): array
{
    $sql = 'SELECT * FROM projects WHERE is_active = 1 ORDER BY display_order, id';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return db()->query($sql)->fetchAll();
}

function members(?int $limit = null): array
{
    $sql = 'SELECT * FROM team_members WHERE is_active = 1 ORDER BY display_order, id';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return db()->query($sql)->fetchAll();
}

function company_values(): array
{
    return db()->query('SELECT * FROM company_values WHERE is_active = 1 ORDER BY display_order, id')->fetchAll();
}

function upload_image(string $field, string $currentPath = ''): string
{
    if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $currentPath;
    }

    $file = $_FILES[$field];
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Le téléversement de l’image a échoué.');
    }

    if (($file['size'] ?? 0) > 3 * 1024 * 1024) {
        throw new RuntimeException('L’image ne doit pas dépasser 3 Mo.');
    }

    $tmpName = (string) ($file['tmp_name'] ?? '');
    $info = @getimagesize($tmpName);
    if ($info === false) {
        throw new RuntimeException('Le fichier envoyé doit être une image valide.');
    }

    $extensions = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];
    $extension = $extensions[$info[2]] ?? null;
    if ($extension === null) {
        throw new RuntimeException('Format accepté : JPG, PNG, GIF ou WebP.');
    }

    $uploadDir = ROOT_PATH . '/assets/uploads';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
        throw new RuntimeException('Impossible de préparer le dossier d’uploads.');
    }

    $filename = bin2hex(random_bytes(12)) . '.' . $extension;
    $destination = $uploadDir . '/' . $filename;
    if (!move_uploaded_file($tmpName, $destination)) {
        throw new RuntimeException('Impossible d’enregistrer l’image envoyée.');
    }

    return 'assets/uploads/' . $filename;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        http_response_code(419);
        exit('La session du formulaire a expiré. Veuillez réessayer.');
    }
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function flash(string $name, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$name] = $message;
        return null;
    }

    $message = $_SESSION['flash'][$name] ?? null;
    unset($_SESSION['flash'][$name]);
    return $message;
}

function is_admin(): bool
{
    return isset($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!is_admin()) {
        flash('error', 'Connectez-vous pour accéder à l’administration.');
        redirect('login.php');
    }
}

function admin_login(array $admin): void
{
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
}
