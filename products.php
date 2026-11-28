<?php
require_once __DIR__ . '/includes/functions.php';

$catSlug = trim((string)($_GET['cat'] ?? ''));
$cat = $catSlug !== '' ? q1("SELECT cate_id, categories, meta_title, meta_desc, meta_key, schema_markup FROM categories WHERE slug_url=? AND status=1 LIMIT 1", 's', [$catSlug]) : null;
if ($cat) {   // category filter par us category ka apna SEO
    $seo = ['title' => trim((string)$cat['meta_title']) ?: $cat['categories'] . ' | Supreme Industry', 'desc' => (string)$cat['meta_desc'],
            'key' => (string)$cat['meta_key'], 'schema' => clean_schema($cat['schema_markup']), 'path' => 'products.php?cat=' . rawurlencode($catSlug)];
}
require_once __DIR__ . '/includes/header.php';

$prods = $cat
    ? q("SELECT pro_name, slug_url, pro_img FROM products WHERE status=1 AND pro_cate=? ORDER BY display_order, id", 'i', [(int)$cat['cate_id']])
    : q("SELECT pro_name, slug_url, pro_img FROM products WHERE status=1 ORDER BY display_order, id");
banner($cat ? $cat['categories'] : 'Products', $cat ? [['Products', $site . 'products.php'], $cat['categories']] : 'Products');
?>
<main>
<section class="wrap sec" style="padding-top:20px">
  <h2 class="ptitle"><?= $cat ? e($cat['categories']) : 'Our Products' ?></h2>
  <?php if (!$prods): ?>
    <p>No products found.</p>
  <?php else: ?>
  <div class="pgrid rv">
    <?php foreach ($prods as $p): $im = pimg($p['pro_img']); ?>
      <a class="pcard" href="<?= e($site) ?>product-details.php?slug=<?= e($p['slug_url']) ?>">
        <div class="pi"><?php if ($im): ?><img src="<?= e($im) ?>" alt="<?= e($p['pro_name']) ?>" loading="lazy"><?php endif; ?></div>
        <h3><?= e($p['pro_name']) ?></h3>
      </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
