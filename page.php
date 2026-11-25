<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$db_ready = isset($conn) && !$conn->connect_error;
$req_slug = trim((string)($_GET['slug'] ?? ''));

$pageData = null;
if ($db_ready && $req_slug !== '') {
    $s = $conn->real_escape_string($req_slug);
    $res = @$conn->query("SELECT * FROM custom_pages WHERE slug_url = '$s' AND status = 1 LIMIT 1");
    if ($res) $pageData = $res->fetch_assoc();
}

$https_cp = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
$base_cp  = ($https_cp ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';

// Set Location Directory filename (change to 'locations.php' if your file is named locations.php)
$loc_dir_file = file_exists(__DIR__ . '/locations.php') ? 'locations.php' : 'location.php';

if ($pageData) {
    $cp_id    = (int)$pageData['id'];
    $cp_title = trim((string)($pageData['page_title'] ?? 'Wholesale Spice Supply'));
    $cp_bc    = trim((string)($pageData['breadcrumb_title'] ?? '')) ?: $cp_title;
    $cp_slug  = trim((string)($pageData['slug_url'] ?? ''));

    $canonical_url = $base_cp . 'page.php?slug=' . urlencode($cp_slug);

    $meta_title = !empty($pageData['meta_title'])
        ? trim((string)$pageData['meta_title'])
        : ($cp_title . ' | AMSB GLOBAL');

    $plain_body = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string)($pageData['content'] ?? '')))));
    $meta_desc  = !empty($pageData['meta_desc'])
        ? trim((string)$pageData['meta_desc'])
        : ($plain_body ? mb_strimwidth($plain_body, 0, 155, '...') : ($cp_title . ' — Pure bulk Red Chilli Powder & Turmeric Powder wholesale supply by AMSB GLOBAL, Wankaner, Morbi.'));

    $meta_key = !empty($pageData['meta_key'])
        ? trim((string)$pageData['meta_key'])
        : ($cp_title . ', AMSB Global, wholesale red chilli powder, turmeric powder bulk supplier Gujarat');

    // Smart Schema Logic (Supports both raw JSON & full <script> tag from Admin Panel)
    $raw_schema = trim((string)($pageData['schema_markup'] ?? ''));
    if ($raw_schema !== '' && stripos($raw_schema, 'bhagirathenterprises') === false) {
        if (stripos($raw_schema, '<script') === false) {
            $schema = "<script type=\"application/ld+json\">\n" . $raw_schema . "\n</script>";
        } else {
            $schema = $raw_schema;
        }
    } else {
        $auto_schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical_url . '#webpage',
                    'url' => $canonical_url,
                    'name' => $cp_title,
                    'description' => $meta_desc,
                    'inLanguage' => 'en-IN',
                    'isPartOf' => ['@id' => $base_cp . '#website']
                ],
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $canonical_url . '#breadcrumb',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $base_cp],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Locations', 'item' => $base_cp . $loc_dir_file],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $cp_bc, 'item' => $canonical_url]
                    ]
                ]
            ]
        ];
        $schema = '<script type="application/ld+json">' . json_encode($auto_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
} else {
    http_response_code(404);
    $meta_title    = 'Page Not Found | AMSB GLOBAL';
    $meta_desc     = 'Requested page could not be found. Explore all AMSB GLOBAL supply locations and wholesale spices.';
    $canonical_url = $base_cp . $loc_dir_file;
}

include_once 'includes/header.php';
?>

<!-- Reading Progress Bar -->
<div class="read-progress" id="readProgress" aria-hidden="true"></div>

<main id="main" class="custom-single-page">

<?php if (!$pageData): ?>
    <section class="sec">
        <div class="wrap">
            <div class="empty-box">
                <i class="fa-solid fa-map-pin"></i>
                <h2>Page Not Found</h2>
                <p>The location or information page you requested is not available. Browse all active AMSB GLOBAL supply locations or our wholesale spice catalogue.</p>
                <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:16px;">
                    <a href="<?= e($loc_dir_file) ?>" class="btn">All Supply Locations</a>
                    <a href="products.php" class="btn o d">Browse Spices</a>
                </div>
            </div>
        </div>
    </section>
<?php else:
    // Fetch Other Custom Pages (Dynamic)
    $otherPages = q("SELECT id, page_title, breadcrumb_title, slug_url, meta_desc
                     FROM custom_pages
                     WHERE status = 1 AND slug_url <> '' AND id != $cp_id
                     ORDER BY id DESC
                     LIMIT 6");

    // Fetch Recent Blogs for Sidebar (Dynamic)
    $recentBlogs = q("SELECT blog_id, title, slug, image, created_at
                      FROM blogs
                      WHERE status = 1
                      ORDER BY created_at DESC, blog_id DESC
                      LIMIT 3");
?>

    <!-- 1. SOFT LIGHT BLUE CUSTOM PAGE HERO -->
    <section class="bd-hero">
        <div class="wrap bd-hero-inner">
            <nav class="bc" aria-label="Breadcrumb">
                <a href="./"><i class="fa-solid fa-house"></i> Home</a>
                <span>/</span>
                <a href="<?= e($loc_dir_file) ?>">Locations</a>
                <span>/</span>
                <span class="curr"><?= e(mb_strimwidth($cp_bc, 0, 55, '...')) ?></span>
            </nav>

            <div class="hero-badges">
                <span class="pill-primary"><i class="fa-solid fa-location-dot"></i> Wholesale Supply Page</span>
                <span class="pill-secondary"><i class="fa-solid fa-file-invoice"></i> GST &amp; E-Way Bill Dispatch</span>
            </div>

            <h1><?= e($cp_title) ?></h1>

            <div class="bd-meta-bar">
                <div class="bd-meta-items">
                    <span><i class="fa-solid fa-building"></i> <strong>AMSB GLOBAL</strong> — Wankaner, Morbi (Gujarat)</span>
                    <span><i class="fa-solid fa-phone"></i> <a href="tel:+<?= e($tel) ?>"><?= e($disp_phone) ?> (<?= e($brand['founder']) ?>)</a></span>
                </div>
                <div class="bd-share">
                    <span>Share:</span>
                    <a href="https://wa.me/?text=<?= urlencode($cp_title . ' - ' . $canonical_url) ?>" target="_blank" rel="noopener" title="Share on WhatsApp" class="sh-wa"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($canonical_url) ?>" target="_blank" rel="noopener" title="Share on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($canonical_url) ?>" target="_blank" rel="noopener" title="Share on Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <button type="button" id="copyLinkBtn" title="Copy Page Link"><i class="fa-solid fa-link"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. QUICK TRADE ASSURANCE STRIP -->
    <section class="pd-trust-strip">
        <div class="wrap pd-ts-grid">
            <div class="pd-ts-item"><i class="fa-solid fa-pepper-hot"></i> <span>Pure Red Chilli &amp; Turmeric Powder</span></div>
            <div class="pd-ts-item"><i class="fa-solid fa-vial-circle-check"></i> <span>Courier Sample Before Bulk Order</span></div>
            <div class="pd-ts-item"><i class="fa-solid fa-boxes-packing"></i> <span>5 / 10 / 25 / 50 KG Lined Bags</span></div>
            <div class="pd-ts-item"><i class="fa-solid fa-truck-fast"></i> <span>Direct Transport From Wankaner</span></div>
        </div>
    </section>

    <!-- 3. MAIN 2-COLUMN CONTENT + STICKY TRADE SIDEBAR -->
    <section class="sec bd-body-sec">
        <div class="wrap bd-grid">

            <!-- Left Main Column (Always visible, no reveal opacity trap) -->
            <article class="bd-main">
                <div class="bd-content-card cp-content-card">
                    <div class="dyn-richtext bd-prose" id="pageContent">
                        <?= $pageData['content'] ?>
                    </div>
                </div>

                <!-- Direct Wholesale Trade Desk Trust Card -->
                <div class="bd-author-box" data-reveal>
                    <div class="bda-ico"><i class="fa-solid fa-handshake"></i></div>
                    <div class="bda-info">
                        <span class="bda-tag">Direct Mill &amp; Trade Pricing • Zero Middlemen</span>
                        <h3>Source Pure Bulk Spices Directly From AMSB GLOBAL</h3>
                        <p>Connect directly with <strong><?= e($brand['founder']) ?></strong> in Wankaner, Morbi (Gujarat - 363621) for daily wholesale rates, courier sample verification, and Pan-India GST + E-Way bill dispatch.</p>
                        <div class="bda-links">
                            <a href="contact.php?product=<?= urlencode($cp_bc) ?>" class="btn"><i class="fa-solid fa-file-invoice-dollar"></i> Request Bulk Quotation</a>
                            <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode('Hello Mahir Bhai (AMSB GLOBAL), I checked your page "' . $cp_title . '" and want today’s bulk spice rates.') ?>" target="_blank" rel="noopener" class="btn wa-btn"><i class="fa-brands fa-whatsapp"></i> WhatsApp <?= e($disp_phone) ?></a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Right Sticky Sidebar -->
            <aside class="bd-sidebar">
                <!-- Auto Table of Contents (JS populates if H2 headings exist) -->
                <div class="sb-card toc-card" id="tocCard" style="display:none;">
                    <h4><i class="fa-solid fa-list-ul"></i> Quick Page Sections</h4>
                    <ul class="toc-list" id="tocList"></ul>
                </div>

                <!-- Direct Bulk Rate Inquiry Form -->
                <div class="sb-card sb-rfq-card">
                    <span class="sb-pill">Fast Written Quote</span>
                    <h4>Get Today’s Bulk Rate</h4>
                    <p>Share your required spice grade, bag weight &amp; city for direct pricing from Wankaner.</p>
                    <form class="sb-form" action="contact.php" method="POST">
                        <input type="hidden" name="subject" value="<?= e($cp_bc) ?>">
                        <input name="name" placeholder="Your Name *" required>
                        <input name="company" placeholder="Firm / Shop Name *" required>
                        <input type="tel" name="phone" placeholder="Mobile / WhatsApp *" required>
                        <input type="email" name="email" placeholder="Business Email *" required>
                        <select name="quantity">
                            <option>Trial Bulk (200 kg – 500 kg)</option>
                            <option>1 MT – 5 MT</option>
                            <option>Part / Full Truck Load (5–25 MT)</option>
                            <option>Monthly Supply Contract</option>
                        </select>
                        <textarea name="message" rows="2" placeholder="Required spice, bag size & delivery city *" required></textarea>
                        <button type="submit" class="btn full-btn"><i class="fa-solid fa-paper-plane"></i> Request Bulk Rate</button>
                    </form>
                </div>

                <!-- Dynamic Wholesale Categories -->
                <?php if (!empty($nav_cats)): ?>
                <div class="sb-card">
                    <h4><i class="fa-solid fa-layer-group"></i> Wholesale Categories</h4>
                    <ul class="sb-cat-list">
                        <?php foreach ($nav_cats as $cslug => $cd): ?>
                        <li>
                            <a href="category.php?slug=<?= urlencode($cslug) ?>">
                                <span><?= e($cd['name']) ?></span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Recent Trade Guides (Dynamic from blogs) -->
                <?php if ($recentBlogs): ?>
                <div class="sb-card">
                    <h4><i class="fa-regular fa-newspaper"></i> Recent Trade Guides</h4>
                    <div class="sb-recent-list">
                        <?php foreach ($recentBlogs as $rb):
                            $rbu = !empty($rb['slug']) ? 'blog-details.php?slug=' . urlencode($rb['slug']) : 'blog-details.php?id=' . (int)$rb['blog_id'];
                            $rbi = img($rb['image'] ?? '', 'blogs', un('photo-1596040033229-a9821ebd058d', 300));
                        ?>
                        <a class="sb-rec-item" href="<?= e($rbu) ?>">
                            <img src="<?= e($rbi) ?>" alt="<?= e($rb['title']) ?>" loading="lazy">
                            <div>
                                <strong><?= e(mb_strimwidth(txt($rb['title']), 0, 60, '...')) ?></strong>
                                <small><?= e(date('d M Y', strtotime($rb['created_at'] ?: 'now'))) ?></small>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Direct Founder Contact Card -->
                <div class="pd-desk-card">
                    <div class="pdd-top">
                        <div class="pdd-ico"><i class="fa-solid fa-user-tie"></i></div>
                        <div>
                            <small>Direct Trade Support</small>
                            <h4><?= e($brand['founder']) ?></h4>
                            <span>AMSB GLOBAL • Wankaner, Morbi</span>
                        </div>
                    </div>
                    <p>Call or WhatsApp for today’s wholesale rate sheet, courier samples, or live stock inspection.</p>
                    <div class="pdd-links">
                        <a href="tel:+<?= e($tel) ?>"><i class="fa-solid fa-phone"></i> <?= e($disp_phone) ?></a>
                        <a href="mailto:<?= e($mail) ?>"><i class="fa-regular fa-envelope"></i> <?= e($mail) ?></a>
                    </div>
                </div>
            </aside>

        </div>
    </section>

    <!-- 4. OTHER SUPPLY LOCATIONS / CUSTOM PAGES (DYNAMIC) -->
    <?php if ($otherPages): ?>
    <section class="sec alt">
        <div class="wrap">
            <div class="bh" data-reveal>
                <div class="sh">
                    <span class="hi">Explore More Trade Pages</span>
                    <h2>Other Supply Locations &amp; Information Pages</h2>
                </div>
                <a href="<?= e($loc_dir_file) ?>" class="btn o d">View All Locations</a>
            </div>

            <div class="loc-grid">
                <?php foreach (array_slice($otherPages, 0, 3) as $idx => $op):
                    $otitle = trim((string)($op['breadcrumb_title'] ?? '')) ?: trim((string)($op['page_title'] ?? 'Explore Page'));
                    $odesc  = txt($op['meta_desc'] ?? '', 130) ?: 'Direct wholesale bulk supply of pure Red Chilli Powder and Turmeric Powder from AMSB GLOBAL.';
                    $ourl   = 'page.php?slug=' . rawurlencode((string)$op['slug_url']);
                ?>
                <article class="loc-card <?= $idx % 2 === 0 ? 'loc-gold' : 'loc-cyan' ?>" data-reveal>
                    <div class="loc-card-top">
                        <div class="loc-ico"><i class="fa-solid fa-location-dot"></i></div>
                        <span class="loc-tag">Supply Location</span>
                    </div>
                    <h3><a href="<?= e($ourl) ?>"><?= e($otitle) ?></a></h3>
                    <p><?= e($odesc) ?></p>
                    <div class="loc-card-foot">
                        <span class="loc-brand"><i class="fa-solid fa-shield-halved"></i> AMSB GLOBAL</span>
                        <a class="loc-btn" href="<?= e($ourl) ?>">View Details <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php endif; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Scroll Reveal (safe threshold: 0)
    const revealEls = document.querySelectorAll('[data-reveal]');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach(en => {
                if (en.isIntersecting) { en.target.classList.add('is-visible'); obs.unobserve(en.target); }
            });
        }, { threshold: 0, rootMargin: '0px 0px -10px 0px' });
        revealEls.forEach(el => io.observe(el));
    } else {
        revealEls.forEach(el => el.classList.add('is-visible'));
    }

    // 2. Reading Progress Bar
    const bar = document.getElementById('readProgress');
    if (bar) {
        window.addEventListener('scroll', () => {
            const h = document.documentElement;
            const max = h.scrollHeight - h.clientHeight;
            bar.style.width = (max > 0 ? Math.min(100, (h.scrollTop / max) * 100) : 0) + '%';
        }, { passive: true });
    }

    // 3. Auto Table of Contents & Responsive Tables inside Custom Page Content
    const prose   = document.getElementById('pageContent');
    const tocCard = document.getElementById('tocCard');
    const tocList = document.getElementById('tocList');
    if (prose) {
        prose.querySelectorAll('table').forEach(tbl => {
            const wrap = document.createElement('div');
            wrap.className = 'prose-table-wrap';
            tbl.parentNode.insertBefore(wrap, tbl);
            wrap.appendChild(tbl);
        });

        const h2s = prose.querySelectorAll('h2');
        if (h2s.length >= 2 && tocCard && tocList) {
            h2s.forEach((h, i) => {
                const text = h.textContent.trim();
                if (!text) return;
                const id = 'cp-sec-' + (i + 1);
                h.id = id;
                const li = document.createElement('li');
                const a  = document.createElement('a');
                a.href = '#' + id;
                a.textContent = text;
                li.appendChild(a);
                tocList.appendChild(li);
            });
            if (tocList.children.length > 0) tocCard.style.display = 'block';
        }
    }

    // 4. Copy Link Button
    const copyBtn = document.getElementById('copyLinkBtn');
    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            navigator.clipboard && navigator.clipboard.writeText(window.location.href).then(() => {
                copyBtn.innerHTML = '<i class="fa-solid fa-check"></i>';
                setTimeout(() => { copyBtn.innerHTML = '<i class="fa-solid fa-link"></i>'; }, 1800);
            });
        });
    }

    // 5. Mobile Menu Toggle
    const tg = document.querySelector('.tg');
    const nav = document.getElementById('nav');
    if (tg && nav && !tg.dataset.bound) {
        tg.dataset.bound = '1';
        tg.addEventListener('click', () => {
            const exp = tg.getAttribute('aria-expanded') === 'true';
            tg.setAttribute('aria-expanded', String(!exp));
            nav.classList.toggle('open');
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>