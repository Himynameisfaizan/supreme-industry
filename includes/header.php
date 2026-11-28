<?php
require_once __DIR__ . '/functions.php';
$pageUrl = basename($_SERVER['SCRIPT_NAME']);
$m = page_meta($pageUrl) ?: [];
// Dynamic pages (product/blog detail) apne page se $seo set karke override kar sakte hain
$seo = array_merge([
  'title'  => $m['meta_title'] ?? 'Supreme Industry | PUF Panels & Prefabricated Building Solutions',
  'desc'   => $m['meta_desc'] ?? '',
  'key'    => $m['meta_key'] ?? '',
  'schema' => page_schema($pageUrl),
  'path'   => $pageUrl === 'index.php' ? '' : $pageUrl,
  'image'  => null,
], $seo ?? []);
$canonical = CANONICAL_BASE . '/' . ltrim($seo['path'], '/');
$C = contact();
$logo = q1("SELECT logo_path FROM logos WHERE location='header' ORDER BY is_active DESC, id DESC LIMIT 1");
$fav  = q1("SELECT logo_path FROM logos WHERE location='favicon' ORDER BY is_active DESC, id DESC LIMIT 1");
$phone = $C['phone'] ?? '+91-8743062634';
$navOn = ($pageUrl === 'product-details.php') ? 'products.php' : $pageUrl;
$nav = ['index.php' => 'Home', 'about.php' => 'About Us', 'products.php' => 'Products', 'blogs.php' => 'blogs' ,'career.php' => 'Career', 'contact-us.php' => 'Contact Us'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="<?= e($site) ?>">
  <title><?= e($seo['title']) ?></title>
  <meta name="description" content="<?= e($seo['desc']) ?>">
  <meta name="keywords" content="<?= e($seo['key']) ?>">
  <link rel="canonical" href="<?= e($canonical) ?>">
  <meta name="robots" content="index, follow">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Supreme Industry">
  <meta property="og:title" content="<?= e($seo['title']) ?>">
  <meta property="og:description" content="<?= e($seo['desc']) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <?php if ($seo['image']): ?>
    <meta property="og:image" content="<?= e($seo['image']) ?>"><?php endif; ?>
  <?php if ($fav): ?>
    <link rel="icon" href="<?= e(aimg($site . 'admin/', $fav['logo_path'], D_LOGO)) ?>"><?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e($site) ?>assets/css/style.css?v=<?php echo time()?>">
  <?php if ($seo['schema']): ?><script type="application/ld+json">
      <?= $seo['schema'] ?>
    </script><?php endif; ?>
  <script>document.documentElement.className = 'js'</script>
</head>

<body>
  <header class="hdr" id="hdr">
    <a class="logo" href="<?= e($site) ?>" aria-label="Supreme Industry">
      <?php if ($logo): ?><img src="<?= e($site) ?>admin/<?= e(img(D_LOGO, $logo['logo_path'])) ?>" alt="Supreme Industry"><?php else: ?><span class="logo-txt">SUPREME<small>INDUSTRY</small></span><?php endif; ?>
    </a>
    <button class="burger" id="burger" aria-label="Menu" aria-expanded="false"><i></i><i></i><i></i></button>
    <nav class="nav" id="nav">
      <?php foreach ($nav as $file => $label): ?>
        <a href="<?= e($site . ($file === 'index.php' ? '' : $file)) ?>" class="<?= $navOn === $file ? 'on' : '' ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
      <a class="call" href="tel:<?= e(preg_replace('/[^+\d]/', '', $phone)) ?>"><small>Need Help? Call Us</small><b><?= e($phone) ?></b></a>
    </nav>
  </header>