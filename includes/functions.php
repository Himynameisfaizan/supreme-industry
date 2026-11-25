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
    $st = $conn->prepare($sql);
    if (!$st) return [];
    if ($types) $st->bind_param($types, ...$args);
    $st->execute();
    $r = $st->get_result();
    return $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
}
function q1($sql, $types = '', $args = []) { $r = q($sql, $types, $args); return $r[0] ?? null; }

function img($dir, $file) {
    $file = trim((string)$file);
    if ($file === '') return PLACEHOLDER;
    if (strpos($file, 'uploads/') === 0) $dir = '';
    return $dir . str_replace('%2F', '/', rawurlencode($file));
}

function page_meta($url)   { return q1("SELECT meta_title, meta_desc, meta_key FROM meta WHERE page_url=? LIMIT 1", 's', [$url]); }
function page_schema($url) {
    $r = q1("SELECT schema_markup FROM page_schemas WHERE page_url=? LIMIT 1", 's', [$url]);
    return clean_schema($r['schema_markup'] ?? '');
}
// DB mein schema escaped ho to usse saaf karke valid JSON-LD hi return karta hai
function clean_schema($s) {
    $s = trim((string)$s);
    if ($s === '') return '';
    if (json_decode($s) === null) $s = stripslashes($s);
    return json_decode($s) === null ? '' : $s;
}
function contact() { return q1("SELECT * FROM contacts ORDER BY id DESC LIMIT 1") ?: []; }
function plain($html, $n = 120) { return mb_strimwidth(trim(preg_replace('/\s+/', ' ', strip_tags((string)$html))), 0, $n, '…'); }
