<?php
require_once __DIR__ . '/includes/functions.php';

$slug = trim((string)($_GET['slug'] ?? ''));
$p = $slug !== '' ? q1("SELECT * FROM products WHERE slug_url=? AND status=1 LIMIT 1", 's', [$slug]) : null;
if (!$p) http_response_code(404);

$imgs = [];
if ($p) {   // pro_img (comma separated) + product_images (Manage Images)
    foreach (explode(',', (string)$p['pro_img']) as $f) if (trim($f) !== '') $imgs[] = trim($f);
    foreach (q("SELECT image_path FROM product_images WHERE product_id=? ORDER BY id", 'i', [(int)$p['pro_id']]) as $r) if (trim($r['image_path']) !== '') $imgs[] = trim($r['image_path']);
    $imgs = array_values(array_unique($imgs));
}

// Enquiry form -> inquiries table
$v = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];
$err = '';
if ($p && $_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($v as $k => $_) $v[$k] = trim((string)($_POST[$k] ?? ''));
    $ph = mobile10($v['phone']);
    $self = $site . 'product-details.php?slug=' . rawurlencode($p['slug_url']);
    if (!empty($_POST['website']))                          { flash('success', 'Thank you! We will contact you shortly.'); header('Location: ' . $self); exit; } // honeypot
    elseif (!csrf_ok())                                     $err = 'Session expired. Please reload the page and try again.';
    elseif (mb_strlen($v['name']) < 2)                      $err = 'Please enter your name.';
    elseif (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) $err = 'Please enter a valid email address.';
    elseif (!$ph)                                           $err = 'Please enter a valid 10-digit mobile number.';
    elseif (!rate_ok('enq'))                                $err = 'Please wait a few seconds before sending again.';
    elseif (run("INSERT INTO inquiries (name, email, phone, subject, message, status) VALUES (?,?,?,?,?,0)", 'sssssi',
        [mb_substr($v['name'], 0, 255), mb_substr($v['email'], 0, 255), $ph, mb_substr('Product enquiry: ' . $p['pro_name'], 0, 255),
         mb_substr($v['message'] ?: 'I am interested in ' . $p['pro_name'], 0, 3000), 0])) {
        flash('success', 'Thank you! Your enquiry has been received and our team will contact you shortly.');
        header('Location: ' . $self); exit;
    } else $err = 'Something went wrong. Please try again or call us directly.';
}

$seo = $p ? [
    'title'  => trim((string)$p['meta_title']) ?: $p['pro_name'] . ' | Supreme Industry',
    'desc'   => trim((string)$p['meta_desc']) ?: plain($p['short_desc'] ?: $p['description'], 155),
    'key'    => (string)$p['meta_key'],
    'schema' => clean_schema($p['schema_markup']),
    'path'   => 'product-details.php?slug=' . rawurlencode($p['slug_url']),
    'image'  => $imgs ? CANONICAL_BASE . '/admin/assets/img/uploads/' . rawurlencode($imgs[0]) : null,
] : ['title' => 'Product not found | Supreme Industry', 'desc' => '', 'key' => '', 'schema' => '', 'path' => 'products.php'];
require_once __DIR__ . '/includes/header.php';

$name = $p['pro_name'] ?? 'Product not found';
$rel = $p ? q("SELECT pro_name, slug_url, pro_img FROM products WHERE status=1 AND pro_id<>? ORDER BY (pro_cate=?) DESC, display_order, id LIMIT 12", 'ii', [(int)$p['pro_id'], (int)$p['pro_cate']]) : [];
banner($name, [['Products', $site . 'products.php'], $name]);
$su = rawurlencode($canonical); $sn = rawurlencode($name);
?>
<main>
<?php if (!$p): ?>
<section class="wrap sec"><h2>Product not found</h2><p style="margin:10px 0 16px">The product you are looking for is not available.</p><a class="btn" href="<?= e($site) ?>products.php">VIEW ALL PRODUCTS <span>→</span></a></section>
<?php else: ?>
<section class="wrap pd">
  <article class="rv">
    <?php if ($imgs): ?>
      <img id="pdMain" class="pd-img" src="<?= e(pfile($imgs[0])) ?>" alt="<?= e($name) ?>">
      <?php if (count($imgs) > 1): ?><div class="thumbs"><?php foreach ($imgs as $i => $f): ?><img class="<?= $i ? '' : 'on' ?>" src="<?= e(pfile($f)) ?>" data-full="<?= e(pfile($f)) ?>" alt="<?= e($name) ?> image <?= $i + 1 ?>" loading="lazy"><?php endforeach; ?></div><?php endif; ?>
    <?php endif; ?>
    <div class="rich"><?= fix_rich($p['description'] ?: $p['short_desc']) ?></div>
    <div class="share"><b>Social Share:</b>
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $su ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">f</a>
      <a href="https://twitter.com/intent/tweet?url=<?= $su ?>&amp;text=<?= $sn ?>" target="_blank" rel="noopener" aria-label="Share on X">X</a>
      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $su ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn">in</a>
      <a href="https://wa.me/?text=<?= $sn . '%20' . $su ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp">wa</a>
    </div>
  </article>

  <aside class="aside rv">
    <form class="cform" method="post" action="<?= e($site) ?>product-details.php?slug=<?= e(rawurlencode($p['slug_url'])) ?>" novalidate>
      <h2>Get In Touch</h2><p>Interested in <?= e($name) ?>? Send us your requirement.</p>
      <?= flash_html() ?>
      <?php if ($err): ?><div class="flash error" role="alert"><?= e($err) ?></div><?php endif; ?>
      <input type="hidden" name="csrf" value="<?= csrf() ?>">
      <div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <div class="fgrid">
        <div><label for="en-name">Your Name*</label><input id="en-name" name="name" value="<?= e($v['name']) ?>" maxlength="255" required autocomplete="name"></div>
        <div><label for="en-email">Email*</label><input id="en-email" type="email" name="email" value="<?= e($v['email']) ?>" maxlength="255" required autocomplete="email"></div>
        <div><label for="en-phone">Mobile Number*</label><input id="en-phone" type="tel" name="phone" value="<?= e($v['phone']) ?>" maxlength="14" required autocomplete="tel"></div>
        <div><label for="en-msg">Message</label><textarea id="en-msg" name="message" maxlength="3000"><?= e($v['message']) ?></textarea></div>
      </div>
      <button class="btn" type="submit">SEND ENQUIRY <span>→</span></button>
    </form>
  </aside>
</section>

<?php if ($rel): ?>
<section class="wrap sec rv">
  <h2 class="h-c h-ico-c">Related Products</h2>
  <div class="track" data-slider data-dots>
    <?php foreach ($rel as $r): $im = pimg($r['pro_img']); ?>
      <a class="rcard" href="<?= e($site) ?>product-details.php?slug=<?= e($r['slug_url']) ?>">
        <div class="pi"><?php if ($im): ?><img src="<?= e($im) ?>" alt="<?= e($r['pro_name']) ?>" loading="lazy"><?php endif; ?></div>
        <h3><?= e($r['pro_name']) ?></h3><span class="vbtn">VIEW DETAILS</span>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="dots" data-dotbox></div>
</section>
<?php endif; ?>
<script>
document.querySelectorAll('.thumbs img').forEach(function (t) {
  t.addEventListener('click', function () {
    document.getElementById('pdMain').src = t.dataset.full;
    document.querySelectorAll('.thumbs img').forEach(function (x) { x.classList.remove('on'); });
    t.classList.add('on');
  });
});
</script>
<?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
