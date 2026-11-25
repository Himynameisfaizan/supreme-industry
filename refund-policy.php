<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$https_pl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
$base_pl  = ($https_pl ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
$curr_pl  = $base_pl . basename($_SERVER['PHP_SELF']);

$page_meta = [
    'title' => 'Refund & Cancellation Policy | AMSB GLOBAL — Wholesale Spice Trade',
    'desc'  => 'Read the Refund and Cancellation Policy of AMSB GLOBAL (Wankaner, Morbi, Gujarat) for bulk wholesale orders of Red Chilli Powder and Turmeric Powder.',
    'key'   => 'AMSB Global refund policy, cancellation policy bulk spices, wholesale spice trade terms Morbi',
    'schema' => '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebPage",
      "@id": "' . $curr_pl . '#webpage",
      "url": "' . $curr_pl . '",
      "name": "Refund and Cancellation Policy - AMSB GLOBAL",
      "description": "Refund, replacement, and cancellation terms for B2B wholesale spice orders placed with AMSB GLOBAL.",
      "inLanguage": "en-IN",
      "isPartOf": { "@id": "' . $base_pl . '#website" }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "' . $curr_pl . '#breadcrumb",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "' . $base_pl . '" },
        { "@type": "ListItem", "position": 2, "name": "Refund & Cancellation Policy", "item": "' . $curr_pl . '" }
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
                <span class="curr">Refund &amp; Cancellation Policy</span>
            </nav>
            <div class="hero-badges">
                <span class="pill-primary"><i class="fa-solid fa-rotate-left"></i> Fair B2B Trade Terms</span>
                <span class="pill-secondary"><i class="fa-regular fa-calendar"></i> Last Updated: <?= date('d M Y') ?></span>
            </div>
            <h1>Refund &amp; <span class="txt-primary">Cancellation Policy</span></h1>
            <p class="lead">Clear, transparent rules governing order cancellations, sample verification, transit damage claims, and refunds for wholesale spice orders at <strong>AMSB GLOBAL</strong>.</p>
        </div>
    </section>

    <!-- 2. POLICY CONTENT + STICKY SIDEBAR -->
    <section class="sec bd-body-sec">
        <div class="wrap bd-grid">

            <!-- Left Column: Policy Content -->
            <article class="bd-main">
                <div class="bd-content-card policy-card">
                    <div class="dyn-richtext bd-prose">
                        <p>At <strong>AMSB GLOBAL</strong> (Wankaner, Morbi, Gujarat), we supply 100% pure, unadulterated <strong>Red Chilli Powder</strong> and <strong>Turmeric Powder</strong> in bulk commercial quantities. Because ground spices are consumable food commodities subject to strict food safety and hygiene standards, our cancellation and refund terms are designed to be fair and transparent for every wholesale buyer.</p>

                        <div class="policy-callout">
                            <strong><i class="fa-solid fa-vial-circle-check"></i> Sample-First Assurance:</strong> We strongly recommend reviewing our physical courier sample before confirming a bulk purchase order so you are 100% confident about colour, pungency, curcumin level, and mesh fineness upfront.
                        </div>

                        <h2>Part A — Order Cancellation Policy</h2>

                        <h3>1. Cancellation Before Grinding or Packing</h3>
                        <p>Wholesale orders may be cancelled within <strong>24 hours</strong> of order confirmation, provided fresh grinding, custom blending, or bag packing has not yet started at our Wankaner facility. Valid cancellation requests must be confirmed in writing via email (<strong><?= e($mail) ?></strong>) or official WhatsApp.</p>

                        <h3>2. Cancellation After Processing or Dispatch</h3>
                        <p>Once bulk spice lots are freshly ground to your specified mesh/grade, packed in bags, billed with GST/E-Way bill, or handed over to the road transport carrier, orders <strong>cannot be cancelled</strong>.</p>

                        <h3>3. Custom Blends &amp; Private-Label Orders</h3>
                        <p>For custom-blended lots, custom mesh grinding, or private-label / buyer-branded packaging orders, cancellations are not permitted once raw material procurement or custom grinding has commenced. Any advance deposit paid against custom-processed bulk orders is adjusted against actual procurement/processing costs.</p>

                        <h2>Part B — Return, Replacement &amp; Refund Policy</h2>

                        <h3>1. Non-Returnable Food Commodities</h3>
                        <p>In line with FSSAI food hygiene standards, we <strong>do not accept general returns</strong> on opened or delivered ground spices due to change of mind or local mandi price fluctuations after booking.</p>

                        <h3>2. Eligible Claims (Shortage, Wrong Grade, or Severe Transit Damage)</h3>
                        <p>We stand firmly behind every lot we dispatch. Replacement, credit note, or refund adjustments are applicable in the following verified cases:</p>
                        <ul>
                            <li>The delivered product grade or bag weight differs materially from the confirmed Purchase Order and approved sample.</li>
                            <li>Bags arrive severely torn, water-damaged, or compromised due to faulty packing prior to loading.</li>
                            <li>A verified quantity shortage occurs compared to the GST Tax Invoice and Transport LR slip.</li>
                        </ul>

                        <h3>3. Claim Reporting Window &amp; Proof</h3>
                        <p>To ensure quick and fair resolution, buyers must notify our Wankaner trade desk within <strong>48 hours of delivery</strong> along with clear photographs/unboxing videos of the bags, batch markings, and a copy of the signed transport LR receipt.</p>

                        <h3>4. Refund &amp; Settlement Timeline</h3>
                        <p>Once a claim is verified and approved by our trade desk, refunds or GST credit notes are processed directly to the buyer’s registered bank account via NEFT/RTGS/UPI within <strong>5 to 7 business days</strong>.</p>

                        <div class="policy-contact-box">
                            <h4><i class="fa-solid fa-headset"></i> Order Assistance &amp; Claims Desk</h4>
                            <p><strong>Contact Person:</strong> <?= e($brand['founder']) ?> — AMSB GLOBAL</p>
                            <p><strong>Phone / WhatsApp:</strong> <a href="tel:+<?= e($tel) ?>"><?= e($disp_phone) ?></a></p>
                            <p><strong>Email:</strong> <a href="mailto:<?= e($mail) ?>"><?= e($mail) ?></a></p>
                            <p><strong>Address:</strong> Wankaner, Morbi, Gujarat - 363621</p>
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
                        <li><a href="refund-policy.php" class="active"><i class="fa-solid fa-rotate-left"></i> Refund &amp; Cancellation</a></li>
                        <li><a href="shipping-return.php"><i class="fa-solid fa-truck-fast"></i> Shipping &amp; Dispatch</a></li>
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
                        <div class="pdd-ico"><i class="fa-solid fa-user-tie"></i></div>
                        <div>
                            <small>Direct Founder Desk</small>
                            <h4><?= e($brand['founder']) ?></h4>
                            <span>AMSB GLOBAL • Wankaner, Morbi</span>
                        </div>
                    </div>
                    <p>Have a question regarding a running order or want to request a courier sample before ordering?</p>
                    <div class="pdd-links">
                        <a href="contact.php"><i class="fa-solid fa-paper-plane"></i> Contact Trade Desk</a>
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