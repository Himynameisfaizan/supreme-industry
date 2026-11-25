<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$https_pl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
$base_pl  = ($https_pl ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
$curr_pl  = $base_pl . basename($_SERVER['PHP_SELF']);

$page_meta = [
    'title' => 'Shipping & Dispatch Policy | AMSB GLOBAL — Pan-India Bulk Spice Supply',
    'desc'  => 'Learn about courier sample dispatch, part-load and full-truck transport timelines, GST/E-Way bill paperwork, and packaging standards at AMSB GLOBAL, Wankaner, Morbi.',
    'key'   => 'AMSB Global shipping policy, bulk spice transport Morbi Gujarat, wholesale red chilli dispatch India',
    'schema' => '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebPage",
      "@id": "' . $curr_pl . '#webpage",
      "url": "' . $curr_pl . '",
      "name": "Shipping and Dispatch Policy - AMSB GLOBAL",
      "description": "Pan-India wholesale transport, dispatch timelines, and moisture-safe packaging standards of AMSB GLOBAL.",
      "inLanguage": "en-IN",
      "isPartOf": { "@id": "' . $base_pl . '#website" }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "' . $curr_pl . '#breadcrumb",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "' . $base_pl . '" },
        { "@type": "ListItem", "position": 2, "name": "Shipping & Dispatch Policy", "item": "' . $curr_pl . '" }
      ]
    }
  ]
}
</script>'
];

include_once 'includes/header.php';
?>

<main id="main" class="policy-page">

    <!-- 1. SOFT LIGHT BLUE POLICY HERO -->
    <section class="bd-hero">
        <div class="wrap bd-hero-inner">
            <nav class="bc" aria-label="Breadcrumb">
                <a href="./"><i class="fa-solid fa-house"></i> Home</a>
                <span>/</span>
                <span class="curr">Shipping &amp; Dispatch Policy</span>
            </nav>
            <div class="hero-badges">
                <span class="pill-primary"><i class="fa-solid fa-truck-fast"></i> Pan-India Road Transport</span>
                <span class="pill-secondary"><i class="fa-regular fa-calendar"></i> Last Updated: <?= date('d M Y') ?></span>
            </div>
            <h1>Shipping &amp; <span class="txt-primary">Dispatch Policy</span></h1>
            <p class="lead">Everything wholesale buyers need to know about sample couriers, bulk dispatch schedules, transport LR sharing, and moisture-proof packaging from <strong>Wankaner, Morbi (Gujarat)</strong>.</p>
        </div>
    </section>

    <!-- 2. POLICY CONTENT + STICKY SIDEBAR -->
    <section class="sec bd-body-sec">
        <div class="wrap bd-grid">

            <!-- Left Column: Policy Content -->
            <article class="bd-main">
                <div class="bd-content-card policy-card">
                    <div class="dyn-richtext bd-prose">
                        <p><strong>AMSB GLOBAL</strong> operates from <strong>Wankaner, Morbi, Gujarat (363621)</strong>—strategically connected to major national highway networks for reliable, cost-effective Pan-India road transport of bulk <strong>Red Chilli Powder</strong> and <strong>Turmeric Powder</strong>.</p>

                        <h2>1. Courier Sample Dispatch</h2>
                        <p>Physical evaluation samples requested by genuine B2B buyers are packed hygienically and dispatched via leading courier services within <strong>24 to 48 business hours</strong>. Tracking details are shared directly on WhatsApp.</p>

                        <h2>2. Bulk Order Processing &amp; Loading Time</h2>
                        <ul>
                            <li><strong>Ready-Stock Standard Grades:</strong> Dispatched within <strong>1 to 3 business days</strong> after order and payment confirmation.</li>
                            <li><strong>Fresh Custom Grinding / Large Truck Loads (10–25 MT):</strong> Dispatched within <strong>3 to 5 business days</strong> depending on required mesh fineness, blending, and custom bag printing.</li>
                        </ul>

                        <h2>3. Pan-India Road Transport &amp; Delivery Timelines</h2>
                        <p>We arrange both <strong>Part Truck Loads (PTL / 200 kg to 5 MT)</strong> and <strong>Full Truck Loads (FTL / 10 MT to 25 MT)</strong> through reputed interstate transport carriers, or we can load directly onto the buyer’s nominated transport vehicle.</p>
                        <ul>
                            <li><strong>Within Gujarat (Rajkot, Ahmedabad, Surat, Vadodara, etc.):</strong> Typically <strong>1 to 2 business days</strong> after dispatch.</li>
                            <li><strong>Neighbouring &amp; Major Trade States (Maharashtra, Rajasthan, MP, Delhi NCR):</strong> Typically <strong>3 to 5 business days</strong>.</li>
                            <li><strong>Rest of India (South, East &amp; North-East Mandis):</strong> Typically <strong>5 to 8 business days</strong> depending on route and transport hub.</li>
                        </ul>

                        <h2>4. Trade Paperwork &amp; Live Loading Transparency</h2>
                        <p>Every commercial shipment dispatched from our Wankaner hub includes complete, compliant documentation:</p>
                        <ul>
                            <li>Valid <strong>GST Tax Invoice</strong> with accurate HSN codes (09042211 / 09103030).</li>
                            <li>Generated <strong>E-Way Bill</strong> for smooth interstate transit.</li>
                            <li><strong>Transport Lorry Receipt (LR / Bilty)</strong> and weighbridge slip (for full-truck orders), shared immediately via WhatsApp and email.</li>
                            <li>Pre-loading bag photos or a quick WhatsApp video verification available on request.</li>
                        </ul>

                        <h2>5. Freight Charges &amp; Transit Responsibility</h2>
                        <p>Unless a delivered (FOR) rate is explicitly agreed upon in the written quotation, wholesale rates are quoted on an <strong>Ex-Wankaner (Morbi)</strong> basis and road transport freight is payable by the buyer on a “To-Pay” or pre-agreed basis. Transit insurance can be arranged at buyer request.</p>

                        <h2>6. Moisture-Safe Bulk Packaging</h2>
                        <p>To protect ground spices from humidity, dust, and transit handling, all wholesale orders are packed in <strong>5 kg, 10 kg, 25 kg, or 50 kg heavy-duty PP/HDPE bags with food-grade inner poly liners</strong>.</p>

                        <h2>7. Delivery Inspection &amp; Reporting Transit Issues</h2>
                        <p>Buyers are requested to inspect bag count, net weight, and outer condition at the time of unloading from the transport carrier. Any visible transit damage or bag shortage should be noted on the transport LR copy and reported to our trade desk within <strong>48 hours of delivery</strong> with photo/video proof.</p>

                        <div class="policy-contact-box">
                            <h4><i class="fa-solid fa-truck-ramp-box"></i> Dispatch &amp; Transport Coordination Desk</h4>
                            <p><strong>Contact Person:</strong> <?= e($brand['founder']) ?> — AMSB GLOBAL</p>
                            <p><strong>Dispatch Hub:</strong> Wankaner, Morbi, Gujarat - 363621</p>
                            <p><strong>Phone / WhatsApp:</strong> <a href="tel:+<?= e($tel) ?>"><?= e($disp_phone) ?></a></p>
                            <p><strong>Email:</strong> <a href="mailto:<?= e($mail) ?>"><?= e($mail) ?></a></p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Right Sticky Sidebar -->
            <aside class="bd-sidebar">
                <div class="sb-card">
                    <h4><i class="fa-solid fa-scale-balanced"></i> Legal &amp; Trade Policies</h4>
                    <ul class="policy-nav">
                        <li><a href="privacy-policy.php"><i class="fa-solid fa-shield-halved"></i> Privacy Policy</a></li>
                        <li><a href="refund-policy.php"><i class="fa-solid fa-rotate-left"></i> Refund &amp; Cancellation</a></li>
                        <li><a href="shipping-return.php" class="active"><i class="fa-solid fa-truck-fast"></i> Shipping &amp; Dispatch</a></li>
                        <li><a href="terms-condition.php"><i class="fa-solid fa-file-contract"></i> Terms &amp; Conditions</a></li>
                    </ul>
                </div>

                <div class="sb-card">
                    <h4><i class="fa-solid fa-magnifying-glass"></i> Search Spices</h4>
                    <form action="products.php" method="GET" class="sb-search-form">
                        <input type="search" name="q" placeholder="Search chilli, turmeric..." required>
                        <button type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

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

                <div class="pd-desk-card">
                    <div class="pdd-top">
                        <div class="pdd-ico"><i class="fa-solid fa-truck-fast"></i></div>
                        <div>
                            <small>Transport Rate Check</small>
                            <h4><?= e($brand['founder']) ?></h4>
                            <span>AMSB GLOBAL • Wankaner, Morbi</span>
                        </div>
                    </div>
                    <p>Want to check road transport cost and delivery days to your city or mandi?</p>
                    <div class="pdd-links">
                        <a href="contact.php"><i class="fa-solid fa-file-invoice-dollar"></i> Request Delivered Rate</a>
                        <a href="tel:+<?= e($tel) ?>"><i class="fa-solid fa-phone"></i> <?= e($disp_phone) ?></a>
                    </div>
                </div>
            </aside>

        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
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