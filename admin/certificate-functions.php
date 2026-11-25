<?php
// Certificates CRUD - shared helpers (admin folder mein rakhein, db-conn.php ke bagal mein)
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/db-conn.php';          // $conn (mysqli)

// Upload folder: website ka  uploads/certificates/  (admin site root ke andar /admin/ mein ho to ye sahi hai)
define('CERT_DIR', dirname(__DIR__) . '/admin/uploads/certificates/');   // server path
define('CERT_URL', '../admin/uploads/certificates/');                    // admin mein preview ke liye

function cert_h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function cert_csrf() { if (empty($_SESSION['cert_csrf'])) $_SESSION['cert_csrf'] = bin2hex(random_bytes(16)); return $_SESSION['cert_csrf']; }
function cert_csrf_ok() { return !empty($_POST['csrf']) && !empty($_SESSION['cert_csrf']) && hash_equals($_SESSION['cert_csrf'], $_POST['csrf']); }

function cert_flash($type, $msg) { $_SESSION['cert_flash'] = [$type, $msg]; }
function cert_flash_html() {
    if (empty($_SESSION['cert_flash'])) return '';
    [$t, $m] = $_SESSION['cert_flash']; unset($_SESSION['cert_flash']);
    return '<div class="alert alert-' . cert_h($t) . ' alert-dismissible fade show" role="alert">' . cert_h($m)
         . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}

// Image validate + save. Success par filename return karta hai, warna null aur $err set.
function cert_save_image(array $f, &$err) {
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) { $err = 'Image upload failed. Please try again.'; return null; }
    if ($f['size'] > 5 * 1024 * 1024) { $err = 'Image must be smaller than 5 MB.'; return null; }
    $info = @getimagesize($f['tmp_name']);
    $ext  = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'][$info[2] ?? 0] ?? null;
    if (!$ext) { $err = 'Only JPG, PNG or WEBP images are allowed.'; return null; }
    if (!is_dir(CERT_DIR) && !mkdir(CERT_DIR, 0755, true)) { $err = 'Upload folder could not be created: ' . CERT_DIR; return null; }
    $name = 'cert_' . time() . '_' . random_int(1000, 9999) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], CERT_DIR . $name)) { $err = 'Could not save the image. Check folder permissions.'; return null; }
    return $name;
}
function cert_remove_image($name) { $p = CERT_DIR . basename((string)$name); if ($name !== '' && is_file($p)) @unlink($p); }
