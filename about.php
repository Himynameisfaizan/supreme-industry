<?php
require_once __DIR__ . '/includes/header.php';
$about = q1("SELECT image_url, title, content FROM about_us ORDER BY id DESC LIMIT 1");
$secs  = q("SELECT title, content, image_url FROM about_sections ORDER BY section_order, id");
$team  = array_shift($secs) ?: [   // pehli about_sections row = Our Team (founder)
    'title' => 'Mr. Vineet Vats-Founder & Director', 'image_url' => '',
    'content' => '<p>A visionary leader, Mr. Vineet Vats has steered Supreme Industry to 24 years of excellence in prefabricated solutions. With a passion for innovation and quality, he ensures every project reflects precision, durability, and client satisfaction, making Supreme Industry a trusted name in industrial, commercial, and residential construction.</p>'];
$socials = ['facebook' => 'f', 'instagram' => 'ig', 'linkdin' => 'in', 'youtube' => 'yt'];
banner('About Us', 'About Us');
?>
<main>
<section class="wrap split rv">
  <img src="<?= e(aimg($site . 'admin/', $about['image_url'] ?? '', 'uploads/')) ?>" alt="Supreme Industry prefabricated structure" loading="lazy">
  <div>
    <h2 class="h-ico"><?= e($about['title'] ?? 'Prefabricated Structure Manufacturers & Installation') ?></h2>
    <div class="rich">
    <?php if (!empty($about['content'])): ?><?= fix_rich($about['content']) ?>
    <?php else: ?>
      <p>Built on 24+ years of Industry Experience Supreme Industry was established in Jan. 2025, backed by over two decades of hands-on experience in the prefabricated building and insulated panel industry. Supreme Industry has been a pioneer in prefabricated and insulated Building solutions, offering clean rooms, cold storage, prefab buildings &amp; offices, Labour colonies, Prefab Banquet Halls, Marriage Halls, PUF panels, and more. Combining innovation, durability, and precision, we cater to industrial, commercial, and residential projects. Trusted by clients nationwide, Our approach is simple : Understand the requirement. Engineer the right solution. Execute with responsibility.</p>
    <?php endif; ?>
    </div>
  </div>
</section>

<section class="team rv"><div class="wrap">
  <div>
    <span class="lbl">Our Team</span>
    <h3><?= e($team['title']) ?></h3>
    <div class="rich"><?= fix_rich($team['content']) ?></div>
    <div class="soc2">
      <?php foreach ($socials as $k => $t): if (!empty($C[$k])): ?><a href="<?= e($C[$k]) ?>" target="_blank" rel="noopener" aria-label="<?= e(ucfirst($k)) ?>"><?= $t ?></a><?php endif; endforeach; ?>
    </div>
  </div>
  <!-- <img src="<?= e(aimg($site . 'admin/', $team['image_url'], 'uploads/')) ?>" alt="<?= e($team['title']) ?>" loading="lazy"> -->
  <img src="assets/img/our-team/1.webp" alt="<?= e($team['title']) ?>" loading="lazy">
</div></section>

<?php foreach ($secs as $i => $s): $has = trim((string)$s['image_url']) !== ''; ?>
<section class="wrap split rv <?= $has ? ($i % 2 ? '' : 'rev') : 'solo' ?>">
  <?php if ($has): ?><img src="<?= e(aimg($site . 'admin/', $s['image_url'], 'uploads/')) ?>" alt="<?= e($s['title']) ?>" loading="lazy"><?php endif; ?>
  <div><h2><?= e($s['title']) ?></h2><div class="rich"><?= fix_rich($s['content']) ?></div></div>
</section>
<?php endforeach; ?>

<?php include __DIR__ . '/includes/fssai.php'; ?>

<section class="wrap stats rv">
  <?php foreach ([['Year of Experience', 24, '', 'Delivering the Finest Products'], ['Project Completed', 3, 'K', 'under Targeted Deadlines'], ['Happy Clients', 2.5, 'K', 'Throughout the Globe'], ['Team Members', 50, '', 'Working 24/7 for Clients']] as $s): ?>
    <div><span><?= e($s[0]) ?></span><strong data-count="<?= $s[1] ?>" data-suffix="<?= $s[2] ?>">0</strong><small><?= e($s[3]) ?></small></div>
  <?php endforeach; ?>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
