<?php
// PHP warnings/notices hide karein taaki XML syntax kabhi break na ho
@ini_set('display_errors', '0');
error_reporting(0);

if (ob_get_level()) {
    ob_end_clean();
}

header('Content-Type: application/xml; charset=UTF-8');
header('X-Robots-Tag: noindex, follow');

include_once __DIR__ . '/config/connect.php';
$ok = isset($conn) && !$conn->connect_error;

// ---- Auto Base URL (Localhost & Live Hostinger dono par automatic) ----
$doc_root  = rtrim(str_replace('\\', '/', (string)(realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: ($_SERVER['DOCUMENT_ROOT'] ?? ''))), '/');
$proj_root = rtrim(str_replace('\\', '/', (string)realpath(__DIR__)), '/');
$base_path = '/';
if ($doc_root !== '' && stripos($proj_root, $doc_root) === 0) {
    $rel = trim(substr($proj_root, strlen($doc_root)), '/');
    $base_path = $rel !== '' ? '/' . $rel . '/' : '/';
}
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['SERVER_PORT'] ?? '') == 443)
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
$scheme  = $https ? 'https://' : 'http://';
$host    = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseUrl = $scheme . $host . $base_path;

// ---- Helpers ----
function xmlEsc($str) {
    return htmlspecialchars((string)$str, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

function fmtDate($raw, $fallback = '') {
    if (!empty($raw) && strtotime((string)$raw) !== false && substr((string)$raw, 0, 4) !== '0000') {
        return date('Y-m-d', strtotime((string)$raw));
    }
    return $fallback;
}

function tableExists($conn, $table) {
    $t = $conn->real_escape_string($table);
    $res = @$conn->query("SHOW TABLES LIKE '$t'");
    return ($res && $res->num_rows > 0);
}

function tableCols($conn, $table) {
    $cols = [];
    if ($res = @$conn->query("SHOW COLUMNS FROM `$table`")) {
        while ($row = $res->fetch_assoc()) {
            $cols[strtolower($row['Field'])] = $row['Field'];
        }
    }
    return $cols;
}

$addedUrls = [];
function renderUrl($loc, $lastmod = '', $changefreq = 'weekly', $priority = '0.8') {
    global $addedUrls;
    if (isset($addedUrls[$loc])) return;
    $addedUrls[$loc] = true;

    echo "  <url>\n";
    echo "    <loc>" . xmlEsc($loc) . "</loc>\n";
    if ($lastmod !== '') {
        echo "    <lastmod>" . xmlEsc($lastmod) . "</lastmod>\n";
    }
    echo "    <changefreq>" . xmlEsc($changefreq) . "</changefreq>\n";
    echo "    <priority>" . xmlEsc($priority) . "</priority>\n";
    echo "  </url>\n";
}

$today = date('Y-m-d');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// 1. Homepage
renderUrl($baseUrl, $today, 'daily', '1.0');

// 2. Static Pages (Sirf wahi files add hongi jo folder mein maujood hain -> Zero 404s)
$staticMap = [
    ['file' => 'about.php',                'path' => 'about/',                'freq' => 'monthly', 'prio' => '0.8'],
    ['file' => 'products.php',             'path' => 'products/',             'freq' => 'daily',   'prio' => '0.9'],
    ['file' => 'blog.php',                 'path' => 'blog/',                 'freq' => 'weekly',  'prio' => '0.8'],
    ['file' => 'contact.php',              'path' => 'contact/',              'freq' => 'monthly', 'prio' => '0.7'],
    ['file' => 'location.php',             'path' => 'location/',             'freq' => 'weekly',  'prio' => '0.7'],
    ['file' => 'service.php',              'path' => 'service/',              'freq' => 'monthly', 'prio' => '0.7'],
    ['file' => 'privacy-policy.php',       'path' => 'privacy-policy/',       'freq' => 'yearly',  'prio' => '0.3'],
    ['file' => 'refund-policy.php',        'path' => 'refund-policy/',        'freq' => 'yearly',  'prio' => '0.3'],
    ['file' => 'shipping-policy.php',      'path' => 'shipping-policy/',      'freq' => 'yearly',  'prio' => '0.3'],
    ['file' => 'shipping-return.php',      'path' => 'shipping-return/',      'freq' => 'yearly',  'prio' => '0.3'],
    ['file' => 'terms-and-conditions.php', 'path' => 'terms-and-conditions/', 'freq' => 'yearly',  'prio' => '0.3'],
    ['file' => 'terms-condition.php',      'path' => 'terms-condition/',      'freq' => 'yearly',  'prio' => '0.3'],
];

foreach ($staticMap as $sp) {
    $fullFile = __DIR__ . '/' . $sp['file'];
    if (is_file($fullFile)) {
        $lm = date('Y-m-d', filemtime($fullFile));
        renderUrl($baseUrl . $sp['path'], $lm, $sp['freq'], $sp['prio']);
    }
}

if ($ok) {
    // 3. Dynamic Categories -> /category/{slug}/
    if (tableExists($conn, 'categories')) {
        $ccols = tableCols($conn, 'categories');
        $cWhere = isset($ccols['status']) ? 'WHERE status = 1' : 'WHERE 1=1';
        $cDateCol = isset($ccols['updated_at']) ? ', updated_at' : (isset($ccols['created_at']) ? ', created_at' : '');
        if ($res = @$conn->query("SELECT slug_url $cDateCol FROM categories $cWhere ORDER BY id ASC")) {
            while ($row = $res->fetch_assoc()) {
                $slug = trim((string)($row['slug_url'] ?? ''));
                if ($slug === '') continue;
                $lm = fmtDate($row['updated_at'] ?? $row['created_at'] ?? '', $today);
                renderUrl($baseUrl . 'category/' . rawurlencode($slug) . '/', $lm, 'weekly', '0.8');
            }
        }
    }

    // 4. Dynamic Products -> /product/{slug} (Fixes status vs is_disabled bug)
    if (tableExists($conn, 'products')) {
        $pcols = tableCols($conn, 'products');
        $pConds = [];
        if (isset($pcols['is_disabled'])) $pConds[] = 'is_disabled = 0';
        elseif (isset($pcols['status']))  $pConds[] = 'status = 1';
        $pWhere = $pConds ? 'WHERE ' . implode(' AND ', $pConds) : '';
        $pDateCol = isset($pcols['updated_at']) ? ', updated_at' : (isset($pcols['created_at']) ? ', created_at' : '');

        if ($res = @$conn->query("SELECT slug_url $pDateCol FROM products $pWhere ORDER BY id DESC")) {
            while ($row = $res->fetch_assoc()) {
                $slug = trim((string)($row['slug_url'] ?? ''));
                if ($slug === '') continue;
                $lm = fmtDate($row['updated_at'] ?? $row['created_at'] ?? '', $today);
                renderUrl($baseUrl . 'product/' . rawurlencode($slug), $lm, 'weekly', '0.9');
            }
        }
    }

    // 5. Dynamic Blogs -> /blog/{slug}
    if (tableExists($conn, 'blogs')) {
        $bcols = tableCols($conn, 'blogs');
        $bWhere = isset($bcols['status']) ? 'WHERE status = 1' : 'WHERE 1=1';
        $bDateCol = isset($bcols['updated_at']) ? ', updated_at' : (isset($bcols['created_at']) ? ', created_at' : '');
        if ($res = @$conn->query("SELECT slug $bDateCol FROM blogs $bWhere ORDER BY blog_id DESC")) {
            while ($row = $res->fetch_assoc()) {
                $slug = trim((string)($row['slug'] ?? ''));
                if ($slug === '') continue;
                $lm = fmtDate($row['updated_at'] ?? $row['created_at'] ?? '', $today);
                renderUrl($baseUrl . 'blog/' . rawurlencode($slug), $lm, 'monthly', '0.7');
            }
        }
    }

    // 6. Dynamic Custom Pages -> /page/{slug}
    if (tableExists($conn, 'custom_pages')) {
        $cpcols = tableCols($conn, 'custom_pages');
        $cpWhere = isset($cpcols['status']) ? "WHERE status = 1 AND slug_url <> ''" : "WHERE slug_url <> ''";
        $cpDateCol = isset($cpcols['updated_at']) ? ', updated_at' : (isset($cpcols['created_at']) ? ', created_at' : '');
        if ($res = @$conn->query("SELECT slug_url $cpDateCol FROM custom_pages $cpWhere ORDER BY id DESC")) {
            while ($row = $res->fetch_assoc()) {
                $slug = trim((string)($row['slug_url'] ?? ''));
                if ($slug === '') continue;
                $lm = fmtDate($row['updated_at'] ?? $row['created_at'] ?? '', $today);
                renderUrl($baseUrl . 'page/' . rawurlencode($slug), $lm, 'monthly', '0.7');
            }
        }
    }
}

echo "</urlset>\n";