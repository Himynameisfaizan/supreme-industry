<?php
$C = $C ?? contact();
$flogo = q1("SELECT logo_path FROM logos WHERE location='header' ORDER BY is_active DESC, id DESC LIMIT 1");
$fcats = q("SELECT categories, slug_url FROM categories WHERE status=1 ORDER BY display_order, id LIMIT 6");
$wp = preg_replace('/\D/', '', $C['wp_number'] ?? '') ?: '918743062634';
$phone = $C['phone'] ?? '+91-8743062634';
$mail = $C['email'] ?? 'supremeindustry.in@gmail.com';
?>
<footer class="ftr">
  <div class="wrap ftr-grid">
    <div class="ftr-card">
      <?php if ($flogo): ?><img class="flogo" src="admin/<?= e(img(D_LOGO, $flogo['logo_path'])) ?>" alt="Supreme Industry"><?php else: ?><span class="logo-txt">SUPREME<small>INDUSTRY</small></span><?php endif; ?>
      <p>India's Top PUF Panel and Prefabricated Structure Manufacturer &amp; Installation Company.</p>
      <p><b><?= e($C['address'] ?? 'Unit No. 603-604 6th Floor Tower B Bhutani Alphathum, Sector 90 Noida (UP) Pin code 201305.') ?></b></p>
      <p><a href="tel:<?= e(preg_replace('/[^+\d]/', '', $phone)) ?>"><?= e($phone) ?></a></p>
      <p><a href="mailto:<?= e($mail) ?>"><?= e($mail) ?></a></p>
      <div class="soc">
        <?php if (!empty($C['facebook'])): ?><a href="<?= e($C['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook">f</a><?php endif; ?>
        <?php if (!empty($C['linkdin'])): ?><a href="<?= e($C['linkdin']) ?>" target="_blank" rel="noopener" aria-label="LinkedIn">in</a><?php endif; ?>
      </div>
    </div>
    <div><h4>Quick Link</h4><ul>
      <li><a href="<?= e($site) ?>">Home</a></li><li><a href="<?= e($site) ?>about.php">About Us</a></li>
      <li><a href="<?= e($site) ?>products.php">Products</a></li><li><a href="<?= e($site) ?>career.php">Career</a></li>
      <li><a href="<?= e($site) ?>contact-us.php">Contact Us</a></li></ul></div>
    <div><h4>Important Links</h4><ul>
      <li><a href="<?= e($site) ?>sitemap.xml">Sitemap</a></li><li><a href="<?= e($site) ?>privacy-policy.php">Privacy Policy</a></li>
      <li><a href="<?= e($site) ?>terms-and-conditions.php">Terms &amp; Conditions</a></li><li><a href="<?= e($site) ?>blogs.php">Blogs</a></li></ul></div>
    <div><h4>Products</h4><ul>
      <?php foreach ($fcats as $c): ?><li><a href="<?= e($site) ?>products.php?cat=<?= e($c['slug_url']) ?>"><?= e($c['categories']) ?></a></li><?php endforeach; ?></ul></div>
  </div>
  <p class="copy"><?= ($C['copyright_text'] ?? '') ?: 'Copyright © ' . date('Y') . ' Supreme Industry | All Rights Reserved' ?></p>
</footer>
<a class="wa" href="https://wa.me/<?= e($wp) ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
  <svg viewBox="0 0 24 24" width="28" height="28" fill="#fff"><path d="M12 2a10 10 0 0 0-8.600 15.100L2 22l5-1.300A10 10 0 1 0 12 2zm5.200 14.100c-.2.600-1.200 1.200-1.700 1.200-.4.100-1 .1-1.600-.1-1.700-.6-3.100-1.700-4.200-3.300-.8-1.100-1.200-2.200-1.200-3 0-.8.400-1.200.6-1.400.2-.2.400-.2.600-.2h.4c.2 0 .3 0 .5.400l.7 1.700c.1.200.1.300 0 .5l-.3.400-.3.300c-.1.100-.2.300-.1.500.5.900 1.200 1.600 2 2.100.3.200.5.300.7.200l.5-.6c.2-.2.300-.2.500-.1l1.600.8c.2.100.4.200.4.300.1.200.1.700-.1 1.200z"/></svg>
</a>
<script src="<?= e($site) ?>assets/js/main.js"></script>
</body>
</html>
