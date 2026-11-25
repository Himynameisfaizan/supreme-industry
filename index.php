<?php
require_once __DIR__ . '/includes/header.php';

$banners = q("SELECT banner_path, title FROM banners ORDER BY display_order, id DESC LIMIT 9");
$about   = q1("SELECT image_url, title, content FROM about_us ORDER BY id DESC LIMIT 1");
$cats    = q("SELECT categories, slug_url, image FROM categories WHERE status=1 ORDER BY display_order, id");
$gal     = q("SELECT image_name, image_path FROM gallery ORDER BY ID DESC LIMIT 3");
$certs   = q("SELECT title, image FROM certificates WHERE status=1 ORDER BY cert_id DESC LIMIT 12");
$tests   = q("SELECT name, designation, client_company, message, project_name FROM testimonials WHERE status=1 ORDER BY display_order, test_id DESC LIMIT 9");
$blogs   = q("SELECT title, slug, image, description, created_at FROM blogs WHERE status=1 ORDER BY blog_id DESC LIMIT 3");
$g = fn($i) => isset($gal[$i]) ? img('', $gal[$i]['image_path']) : 'assets/images/1.webp';
?>
<main>
  <!-- HERO -->
  <section class="hero">
    <div class="hero-txt">
      <h1>Prefabricated &amp; Insulated Building Solutions.</h1>
      <p>Supreme Industry provides PUF/PIR insulated Panels, prefabricated building solutions, from Industrial sheds, Marriage Halls, labour colonies, clean rooms, cold storage to portable offices and allied building structures. Specializing in industrial, commercial, and residential structures, we combine innovation, durability, and precision to create spaces that last. Transform your vision into reality with Supreme Industry.</p>
      <p>Established in Jan 2025, backed by 24+ years of Industry Experience.</p>
    </div>
    <div class="hero-img" id="heroSlider">
      <?php foreach ($banners ?: [['banner_path' => '', 'title' => 'Prefab building']] as $i => $b): ?>
        <img class="<?= $i === 0 ? 'on' : '' ?>" src="admin/<?= e(img('', $b['banner_path'])) ?>" alt="<?= e($b['title']) ?>" <?= $i ? 'loading="lazy"' : '' ?>>
      <?php endforeach; ?>
      <div class="count"><b id="hsNow">1</b>/<span id="hsAll"><?= max(1, count($banners)) ?></span></div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="wrap about rv">
    <img src="admin/uploads/<?= e(img('', $about['image_url'] ?? '')) ?>" alt="Supreme Industry prefabricated structure" loading="lazy">
    <div>
      <h2 class="h-ico"><?= e($about['title'] ?? "India's Top PUF Panels Company!") ?></h2>
      <?php if (!empty($about['content'])): ?>
        <p><?= e(plain($about['content'], 520)) ?></p>
      <?php else: ?>
        <p>We deliver top-quality prefabricated solutions, from cold storage, Mushroom Rooms, Industrial Sheds, Industrial Floorings, clean rooms, Banana Ripening to portable offices and PUF-insulated panels. Specializing in industrial, commercial, and residential structures, we combine practical engineering, quality materials and experienced project execution to deliver solutions designed around each client's requirements.</p>
        <p>Backed by 24+ years of industry experience, our approach is built on technical understanding, dependable execution and long term client relationships.</p>
      <?php endif; ?>
      <a class="btn" href="<?= e($site) ?>about.php">KNOW MORE <span>→</span></a>
    </div>
  </section>

  <!-- CATEGORIES -->
  <?php if ($cats): ?>
    <section class="wrap sec rv">
      <h2 class="h-c h-ico-c">Prefabricated Structures Solutions</h2>
      <div class="track" data-slider>
        <?php foreach ($cats as $c): ?>
          <a class="cat" href="<?= e($site) ?>products.php?cat=<?= e($c['slug_url']) ?>">
            <img src="admin/<?= e(img(D_CAT, $c['image'])) ?>" alt="<?= e($c['categories']) ?>" loading="lazy">
            <h3><?= e($c['categories']) ?></h3><span class="km">→ <u>KNOW MORE</u></span>
          </a>
        <?php endforeach; ?>
      </div>
      <div class="arrows"><button data-prev aria-label="Previous">←</button><button data-next aria-label="Next">→</button></div>
    </section>
  <?php endif; ?>

  <!-- STATS -->
  <section class="wrap stats rv">
    <?php foreach ([['Year of Experience', 24, '', 'Delivering the Finest Products'], ['Project Completed', 3, 'K', 'under Targeted Deadlines'], ['Happy Clients', 2.5, 'K', 'Throughout the Globe'], ['Team Members', 50, '', 'Working 24/7 for Clients']] as $s): ?>
      <div><span><?= e($s[0]) ?></span><strong data-count="<?= $s[1] ?>" data-suffix="<?= $s[2] ?>">0</strong><small><?= e($s[3]) ?></small></div>
    <?php endforeach; ?>
  </section>

  <!-- WHY CHOOSE -->
  <section class="why">
    <!-- <img class="why-big" src="<?= e($g(0)) ?>" alt="Prefab house by Supreme Industry" loading="lazy"> -->
    <img class="why-big" src="assets/images/1.webp" alt="Prefab house by Supreme Industry" loading="lazy">
    <div class="why-r rv">
      <h2 class="h-ico">Why Choose Supreme Industry</h2>
      <p class="lead">Catering our Clients only with the best Solutions</p>
      <div class="why-imgs"><img src="<?= e($g(1)) ?>" alt="" loading="lazy"><img src="<?= e($g(2)) ?>" alt="" loading="lazy"></div>
      <div class="why-pts">
        <div>
          <h3>Unmatched Quality</h3>
          <p>Premium materials ensure durable, long-lasting, and reliable structures.</p>
        </div>
        <div>
          <h3>Customized Solutions</h3>
          <p>Custom prefab designs for industrial, commercial, and residential needs.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- TRUST 1: certificates + assurances -->
  <section class="wrap sec trust rv">
    <h2 class="h-c h-ico-c">Why Clients Trust Us</h2>
    <div class="assure">
      <div><b>24+ Years</b>
        <p>of hands-on industry experience behind every project.</p>
      </div>
      <div><b>On-Time Handover</b>
        <p>Fixed schedules and site teams that stay accountable.</p>
      </div>
      <div><b>Pan-India Installation</b>
        <p>Our own crew manufactures, delivers and installs.</p>
      </div>
    </div>
    <?php if ($certs): ?>
      <div class="certs"><?php foreach ($certs as $c): ?><figure><img src="<?= e(img(D_CERT, $c['image'])) ?>" alt="<?= e($c['title']) ?>" loading="lazy">
            <figcaption><?= e($c['title']) ?></figcaption>
          </figure><?php endforeach; ?></div>
    <?php endif; ?>
  </section>

  <!-- TRUST 2: process -->
  <section class="proc rv">
    <div class="wrap">
      <h2 class="h-c">How We Deliver Your Project</h2>
      <ol>
        <li><b>Site visit &amp; requirement</b>
          <p>We study your space, load and use before suggesting anything.</p>
        </li>
        <li><b>Design &amp; quotation</b>
          <p>Panel type, layout and a clear itemised price.</p>
        </li>
        <li><b>Manufacturing</b>
          <p>Panels are made in-house with quality checks at each stage.</p>
        </li>
        <li><b>Installation &amp; handover</b>
          <p>Our team installs, tests and hands over on the agreed date.</p>
        </li>
      </ol>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <?php if ($tests): ?>
    <section class="wrap sec rv">
      <h2 class="h-c h-ico-c">Words From Loyal Customers</h2>
      <div class="track t-track" data-slider data-dots>
        <?php foreach ($tests as $t): ?>
          <article class="tcard"><span class="q">”</span>
            <h3><?= e($t['project_name'] ?: 'Happy Client') ?></h3>
            <p><?= e($t['message']) ?></p>
            <div class="who"><b><?= e($t['name']) ?></b><small><?= e(trim($t['designation'] . ($t['client_company'] ? ' - ' . $t['client_company'] : ''))) ?></small></div>
          </article>
        <?php endforeach; ?>
      </div>
      <div class="dots" data-dotbox></div>
    </section>
  <?php endif; ?>

  <!-- BLOG -->
  <?php if ($blogs): ?>
    <section class="wrap sec rv">
      <h2 class="h-c h-ico-c">Read Latest From Blog</h2>
      <div class="blogs">
        <?php foreach ($blogs as $b): ?>
          <a class="blog" href="<?= e($site) ?>blog.php?slug=<?= e($b['slug']) ?>">
            <img src="admin/assets/img/<?= e(img(D_BLOG, $b['image'])) ?>" alt="<?= e($b['title']) ?>" loading="lazy">
            <h3><?= e($b['title']) ?></h3>
            <p><?= e(plain($b['description'], 110)) ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>