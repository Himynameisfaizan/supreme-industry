<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$https_l = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
$base_l  = ($https_l ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
$loc_url = $base_l . basename($_SERVER['PHP_SELF']);

$page_meta = [
    'title' => 'Supply Locations & Trade Pages | Wholesale Spice Supplier | AMSB GLOBAL',
    'desc'  => 'Explore all Pan-India supply locations and wholesale trade information pages by AMSB GLOBAL (Wankaner, Morbi, Gujarat). Bulk Red Chilli Powder & Turmeric Powder supply with GST billing.',
    'key'   => 'AMSB Global supply locations, bulk red chilli powder supplier India, turmeric powder wholesale cities, Wankaner Morbi spice trader',
    'schema' => '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "CollectionPage",
      "@id": "' . $loc_url . '#collectionpage",
      "url": "' . $loc_url . '",
      "name": "AMSB GLOBAL Supply Locations & Wholesale Trade Pages",
      "description": "Directory of location-focused wholesale spice supply pages published by AMSB GLOBAL, Wankaner, Morbi, Gujarat.",
      "inLanguage": "en-IN",
      "isPartOf": { "@id": "' . $base_l . '#website" }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "' . $loc_url . '#breadcrumb",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "' . $base_l . '" },
        { "@type": "ListItem", "position": 2, "name": "Locations", "item": "' . $loc_url . '" }
      ]
    }
  ]
}
</script>'
];

include_once 'includes/header.php';

// ---- Fetch Active Custom Pages (Dynamic from custom_pages table) ----
$customPages = q("SELECT id, page_title, breadcrumb_title, slug_url, meta_title, meta_desc
                  FROM custom_pages
                  WHERE status = 1 AND slug_url <> ''
                  ORDER BY id DESC");
?>

<main id="main" class="location-page">

    <!-- 1. SOFT LIGHT BLUE LOCATION HERO -->
    <section class="page-hero">
        <div class="wrap ph-grid">
            <div class="ph-content" data-reveal>
                <nav class="bc" aria-label="Breadcrumb">
                    <a href="./"><i class="fa-solid fa-house"></i> Home</a>
                    <span>/</span>
                    <span class="curr">Supply Locations &amp; Pages</span>
                </nav>
                <div class="hero-badges">
                    <span class="pill-primary"><i class="fa-solid fa-map-location-dot"></i> <?= count($customPages) ?> Active Trade Pages</span>
                    <span class="pill-secondary"><i class="fa-solid fa-truck-fast"></i> Pan-India Dispatch From Gujarat</span>
                </div>
                <h1>Pan-India <span class="txt-primary">Supply Locations</span> &amp; <span class="txt-secondary">Trade Pages.</span></h1>
                <p class="lead">Browse all city-specific wholesale supply pages and trade guides published by <strong>AMSB GLOBAL</strong>. From our Wankaner, Morbi processing hub, we supply pure Red Chilli Powder and Turmeric Powder in bulk across major Indian mandis.</p>

                <div class="blog-hero-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="locSearch" placeholder="Search city, state, or spice page..." aria-label="Search locations and custom pages">
                </div>
            </div>

            <!-- Right Dispatch Network Snapshot -->
            <div class="ph-card" data-reveal>
                <div class="phc-head">
                    <span>Pan-India Wholesale Logistics</span>
                    <h3>AMSB GLOBAL Dispatch Hub</h3>
                </div>
                <ul class="phc-list">
                    <li><span><i class="fa-solid fa-location-dot"></i> Dispatch Origin</span><strong>Wankaner, Morbi, Gujarat - 363621</strong></li>
                    <li><span><i class="fa-solid fa-pepper-hot"></i> Core Supply</span><strong>Red Chilli &amp; Turmeric Powder</strong></li>
                    <li><span><i class="fa-solid fa-boxes-packing"></i> Bulk Packing</span><strong>5 / 10 / 25 / 50 KG Lined PP Bags</strong></li>
                    <li><span><i class="fa-solid fa-truck"></i> Transport Mode</span><strong>Part Load &amp; Full Truck (10–25 MT)</strong></li>
                    <li><span><i class="fa-solid fa-file-invoice"></i> Tax Paperwork</span><strong>100% GST Invoice &amp; E-Way Bill</strong></li>
                    <li><span><i class="fa-solid fa-phone-volume"></i> Trade Desk</span><strong><?= e($disp_phone) ?> (<?= e($brand['founder']) ?>)</strong></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 2. DYNAMIC CUSTOM PAGES CARD GRID -->
    <section class="sec" id="locations-list">
        <div class="wrap">
            <div class="cat-list-head" data-reveal>
                <div>
                    <span class="hi">Explore Our Network</span>
                    <h2>All Published Locations &amp; Trade Pages</h2>
                </div>
                <p class="count-note">Showing <strong id="locVisibleCount"><?= count($customPages) ?></strong> page<?= count($customPages) === 1 ? '' : 's' ?></p>
            </div>

            <?php if (!empty($customPages)): ?>
            <div class="loc-grid" id="locGrid">
                <?php foreach ($customPages as $idx => $cp):
                    $cardTitle = trim((string)($cp['breadcrumb_title'] ?? ''));
                    if ($cardTitle === '') $cardTitle = trim((string)($cp['page_title'] ?? ''));
                    if ($cardTitle === '') $cardTitle = 'Wholesale Spice Supply';

                    $fullTitle = trim((string)($cp['page_title'] ?? '')) ?: $cardTitle;
                    $desc = txt($cp['meta_desc'] ?? '', 155);
                    if ($desc === '') {
                        $desc = 'Direct bulk wholesale supply of 100% pure Red Chilli Powder and Turmeric Powder from AMSB GLOBAL, Wankaner (Morbi) with GST invoice & E-Way bill.';
                    }

                    $slug = trim((string)($cp['slug_url'] ?? ''));
                    $pageUrl = 'page.php?slug=' . rawurlencode($slug);
                    $accentClass = ($idx % 2 === 0) ? 'loc-gold' : 'loc-cyan';
                ?>
                <article class="loc-card <?= $accentClass ?>" data-search="<?= e(strtolower($cardTitle . ' ' . $fullTitle . ' ' . $desc)) ?>" data-reveal>
                    <div class="loc-card-top">
                        <div class="loc-ico" aria-hidden="true">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <span class="loc-tag">Wholesale Supply</span>
                    </div>

                    <h3><a href="<?= e($pageUrl) ?>"><?= e($cardTitle) ?></a></h3>
                    <p><?= e($desc) ?></p>

                    <div class="loc-meta-pills">
                        <span><i class="fa-solid fa-check"></i> Pure Grade</span>
                        <span><i class="fa-solid fa-box"></i> 5–50 KG Bulk</span>
                    </div>

                    <div class="loc-card-foot">
                        <span class="loc-brand"><i class="fa-solid fa-shield-halved"></i> AMSB GLOBAL</span>
                        <a class="loc-btn" href="<?= e($pageUrl) ?>">
                            View Details <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <div class="empty-box" id="locNoMatch" style="display:none;margin-top:24px;">
                <i class="fa-solid fa-map-pin"></i>
                <h3>No matching location page found</h3>
                <p>Even if your city isn’t listed above, we dispatch daily via road transport across India. Message Mahir Bhai directly for rates to your city.</p>
                <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                    <button type="button" class="btn" id="resetLocBtn">Show All Pages</button>
                    <a href="contact.php" class="btn o d">Ask Rate for Your City</a>
                </div>
            </div>

            <?php else: ?>
            <div class="empty-box" data-reveal>
                <i class="fa-solid fa-map-location-dot"></i>
                <h3>Location Pages Coming Soon</h3>
                <p>Published location and trade information pages will appear here automatically. Meanwhile, contact our Wankaner trade desk for bulk spice delivery to your city.</p>
                <a href="contact.php" class="btn">Request Bulk Rate</a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- 3. BUYER TRUST BAND -->
    <section class="sec alt">
        <div class="wrap">
            <div class="sh center" data-reveal>
                <span class="hi">Reliable Interstate Wholesale Supply</span>
                <h2>Why Buyers Across India Source From Wankaner, Morbi</h2>
                <p>Consistent quality, clean paperwork, and transparent daily market rates on every lot we dispatch.</p>
            </div>
            <div class="trust-4-grid">
                <div class="t4-card" data-reveal>
                    <div class="t4-ico gold-ico"><i class="fa-solid fa-vial-circle-check"></i></div>
                    <h3>Sample Before Bulk Order</h3>
                    <p>Receive courier samples of our Red Chilli &amp; Turmeric grades in 24–48 hours before booking bulk stock.</p>
                </div>
                <div class="t4-card" data-reveal>
                    <div class="t4-ico cyan-ico"><i class="fa-solid fa-ban"></i></div>
                    <h3>100% Pure, Zero Mixing</h3>
                    <p>Strictly free from artificial dyes, Sudan colour, lead chromate, or starch fillers.</p>
                </div>
                <div class="t4-card" data-reveal>
                    <div class="t4-ico navy-ico"><i class="fa-solid fa-file-invoice"></i></div>
                    <h3>GST &amp; E-Way Bill Ready</h3>
                    <p>Smooth interstate road transport with proper GST tax invoice, E-Way bill, and LR slip.</p>
                </div>
                <div class="t4-card" data-reveal>
                    <div class="t4-ico gold-ico"><i class="fa-solid fa-user-tie"></i></div>
                    <h3>Direct Founder Desk</h3>
                    <p>Talk directly to <?= e($brand['founder']) ?> for rates, lot photos, and live loading confirmation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. DIRECT TRADE CTA -->
    <section class="sec ab-cta-sec" style="padding-top:60px;">
        <div class="wrap">
            <div class="ab-cta-box" data-reveal>
                <div>
                    <span class="cta-tag">Looking for Delivery to Your City?</span>
                    <h2>Get Today’s Bulk Rate With Transport to Your Mandi</h2>
                    <p>Share your city, required quantity (200 kg to full truck load), and spice grade. Our Wankaner trade desk will reply promptly.</p>
                </div>
                <div class="cta-btns">
                    <a href="contact.php" class="btn"><i class="fa-solid fa-paper-plane"></i> Request Bulk Quote</a>
                    <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode('Hello Mahir Bhai (AMSB GLOBAL), I want today’s bulk wholesale spice rate with transport to my city.') ?>" target="_blank" rel="noopener" class="btn wa-btn"><i class="fa-brands fa-whatsapp"></i> WhatsApp <?= e($disp_phone) ?></a>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Scroll Reveal (threshold: 0 so tall blocks never stay hidden)
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

    // 2. Live Location Search
    const searchInput = document.getElementById('locSearch');
    const cards       = document.querySelectorAll('#locGrid .loc-card');
    const countEl     = document.getElementById('locVisibleCount');
    const noMatchBox  = document.getElementById('locNoMatch');
    const resetBtn    = document.getElementById('resetLocBtn');

    function filterLocations() {
        const q = (searchInput ? searchInput.value : '').trim().toLowerCase();
        let visible = 0;
        cards.forEach(card => {
            const match = q === '' || (card.dataset.search || '').includes(q);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        if (countEl) countEl.textContent = visible;
        if (noMatchBox) noMatchBox.style.display = visible === 0 ? 'block' : 'none';
    }

    if (searchInput) searchInput.addEventListener('input', filterLocations);
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            filterLocations();
        });
    }

    // 3. Mobile Menu Toggle
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