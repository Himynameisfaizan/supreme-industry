<?php
require_once __DIR__ . '/../config/connect.php';

// Canonical hamesha www ke sath
const CANONICAL_BASE = 'https://www.supremeindustry.in';

// Image folders (admin panel ke upload folder ke hisaab se yahin change karein)
const D_LOGO = 'uploads/', D_CAT = 'uploads/category/', D_PRO = 'uploads/products/',
      D_BLOG = 'uploads/blogs/', D_TEST = 'uploads/testimonials/', D_CERT = 'uploads/certificates/';
const PLACEHOLDER = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 3'%3E%3Crect width='4' height='3' fill='%23333'/%3E%3C/svg%3E";

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function q($sql, $types = '', $args = []) {
    global $conn;
    try {   // PHP 8.1+ mysqli exception deta hai: page crash na ho, khaali result mile
        $st = $conn->prepare($sql);
        if (!$st) return [];
        if ($types) $st->bind_param($types, ...$args);
        $st->execute();
        $r = $st->get_result();
        return $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
    } catch (Throwable $ex) { error_log('DB error: ' . $ex->getMessage()); return []; }
}
function q1($sql, $types = '', $args = []) { $r = q($sql, $types, $args); return $r[0] ?? null; }

function img($dir, $file) {
    $file = trim((string)$file);
    if ($file === '') return PLACEHOLDER;
    if (strpos($file, 'uploads/') === 0) $dir = '';
    return $dir . str_replace('%2F', '/', rawurlencode($file));
}

// Admin panel ke uploads: $prefix . $dir . $file  (image na ho to placeholder, bina 'admin/' prefix ke)
function aimg($prefix, $file, $dir = '') { $u = img($dir, $file); return $u === PLACEHOLDER ? $u : $prefix . $u; }

function page_meta($url)   { return q1("SELECT meta_title, meta_desc, meta_key FROM meta WHERE page_url=? LIMIT 1", 's', [$url]); }
function page_schema($url) {
    $r = q1("SELECT schema_markup FROM page_schemas WHERE page_url=? LIMIT 1", 's', [$url]);
    return clean_schema($r['schema_markup'] ?? '');
}
// DB mein schema escaped ho to usse saaf karke valid JSON-LD hi return karta hai
function clean_schema($s) {
    $s = trim(preg_replace('~^\s*<script[^>]*>|</script>\s*$~i', '', trim((string)$s)));   // full <script> paste ho to bhi chalega
    if ($s === '') return '';
    if (json_decode($s) === null) $s = stripslashes($s);
    return json_decode($s) === null ? '' : $s;
}
function contact() { return q1("SELECT * FROM contacts ORDER BY id DESC LIMIT 1") ?: []; }
function plain($html, $n = 120) { return mb_strimwidth(trim(preg_replace('/\s+/', ' ', strip_tags((string)$html))), 0, $n, '…'); }

// ---- Forms, flash, banner helpers ----
if (session_status() === PHP_SESSION_NONE) session_start();
function csrf() { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16)); return $_SESSION['csrf']; }
function csrf_ok() { return !empty($_POST['csrf']) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']); }
function flash($t = null, $m = null) { if ($t !== null) { $_SESSION['fl'] = [$t, $m]; return null; } $f = $_SESSION['fl'] ?? null; unset($_SESSION['fl']); return $f; }
function flash_html() { $f = flash(); return $f ? '<div class="flash ' . e($f[0]) . '" role="status">' . e($f[1]) . '</div>' : ''; }
function run($sql, $types, $args) { global $conn; try { $st = $conn->prepare($sql); if (!$st) return false; $st->bind_param($types, ...$args); return $st->execute(); } catch (Throwable $ex) { error_log('DB error: ' . $ex->getMessage()); return false; } }
function mobile10($s) { $d = preg_replace('/\D/', '', (string)$s); if (strlen($d) > 10) $d = substr($d, -10); return preg_match('/^[6-9]\d{9}$/', $d) ? $d : null; }
function rate_ok($k) { if (time() - ($_SESSION['rl'][$k] ?? 0) < 20) return false; $_SESSION['rl'][$k] = time(); return true; }
function banner($title, $crumb) {   // $crumb: 'Label' ya [['Label', url], 'Last']
    global $site;
    $trail = '<a href="' . e($site) . '">Home</a>';
    foreach ((array)$crumb as $c) $trail .= '<i>→</i>' . (is_array($c) ? '<a href="' . e($c[1]) . '">' . e($c[0]) . '</a>' : '<span>' . e($c) . '</span>');
    echo '<section class="pbanner"><h1>' . e($title) . '</h1><nav aria-label="Breadcrumb">' . $trail . '</nav></section>';
}
// Product image (admin/assets/img/uploads/<file>); pro_img comma-separated ho sakta hai -> pehli image. Na ho to ''
function pimg($pro_img) { $f = trim(explode(',', (string)$pro_img)[0]); return $f === '' ? '' : pfile($f); }
function pfile($f) { global $site; return aimg($site . 'admin/', $f, 'assets/img/uploads/'); }
// CKEditor HTML me relative image paths ko admin/ se jodta hai
function fix_rich($html) { global $site; return preg_replace('~(src=["\'])(?!https?:|//|data:|/|\.\./)([^"\']+)~i', '$1' . $site . 'admin/$2', (string)$html); }

// ---- Blogs ----
// Blog image: admin/assets/img/ + D_BLOG + file (index.php wale path ke jaisa). Na ho to ''
function bimg($f) { global $site; $f = trim((string)$f); return $f === '' ? '' : aimg($site . 'admin/assets/img/', $f, D_BLOG); }
// Blog content: CKEditor HTML ho to as-is, plain text ho to paragraphs
function blog_html($t) {
    $t = trim((string)$t);
    if ($t !== strip_tags($t)) return fix_rich($t);
    $out = '';
    foreach (preg_split('/\R{2,}/', $t) as $para) if (trim($para) !== '') $out .= '<p>' . nl2br(e(trim($para))) . '</p>';
    return $out;
}
