<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$https_pl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
$base_pl  = ($https_pl ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
$curr_pl  = $base_pl . basename($_SERVER['PHP_SELF']);

$page_meta = [
    'title' => 'Terms & Conditions | AMSB GLOBAL — Wholesale Spice Trade, Morbi',
    'desc'  => 'Read the B2B wholesale trading Terms and Conditions of AMSB GLOBAL (Wankaner, Morbi, Gujarat) for Red Chilli Powder and Turmeric Powder orders.',
    'key'   => 'AMSB Global terms and conditions, wholesale spice trade terms Gujarat, B2B supply agreement Morbi',
    'schema' => '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebPage",
      "@id": "' . $curr_pl . '#webpage",
      "url": "' . $curr_pl . '",
      "name": "Terms and Conditions - AMSB GLOBAL",
      "description": "Commercial terms and conditions governing website usage and wholesale spice trade with AMSB GLOBAL.",
      "inLanguage": "en-IN",
      "isPartOf": { "@id": "' . $base_pl . '#website" }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "' . $curr_pl . '#breadcrumb",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "' . $base_pl . '" },
        { "@type": "ListItem", "position": 2, "name": "Terms & Conditions", "item": "' . $curr_pl . '" }
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
                <span class="curr">Terms &amp; Conditions</span>
            </nav>
            <div class="hero-badges">
                <span class="pill-primary"><i class="fa-solid fa-file-contract"></i> Commercial Trade Terms</span>
                <span class="pill-secondary"><i class="fa-regular fa-calendar"></i> Last Updated: <?= date('d M Y') ?></span>
            </div>
            <h1>Terms &amp; <span class="txt-primary">Conditions</span></h1>
            <p class="lead">Standard commercial terms governing website access, daily wholesale rate quotations, sample approvals, and bulk spice transactions with <strong>AMSB GLOBAL</strong>.</p>
        </div>
    </section>

    <!-- 2. POLICY CONTENT + STICKY SIDEBAR -->
    <section class="sec bd-body-sec">
        <div class="wrap bd-grid">

            <!-- Left Column: Policy Content -->
            <article class="bd-main">
                <div class="bd-content-card policy-card">
                    <div class="dyn-richtext bd-prose">
                        <h2>1. Acceptance of Terms</h2>
                        <p>Welcome to <strong>AMSB GLOBAL</strong> (Wankaner, Morbi, Gujarat - 363621). By accessing this website, submitting a bulk inquiry, or placing a wholesale purchase order for Red Chilli Powder, Turmeric Powder, or other Indian spices, you agree to comply with these Terms &amp; Conditions.</p>

                        <h2>2. Daily Market Pricing &amp; Quotations</h2>
                        <p>Agricultural spice prices fluctuate daily based on crop arrivals and mandi conditions. Written quotations shared by our trade desk are valid for the specific validity window mentioned on the quote (typically 24 to 48 hours). Final rates are locked only upon written order confirmation and agreed payment terms.</p>

                        <h2>3. Natural Variations in Agricultural Spices</h2>
                        <p>Because we supply 100% pure, unadulterated natural spices without artificial dyes or synthetic colour enhancers, minor natural variations in shade, aroma intensity, or oiliness may occur across seasonal harvest crops. However, every commercial lot supplied will remain within the agreed specification range and match the approved sample.</p>

                        <h2>4. Minimum Order Quantity (MOQ) &amp; Packaging</h2>
                        <p>All supply is strictly B2B wholesale (starting from trial bulk quantities of 200 kg–500 kg up to full truck loads). Standard bulk packaging is provided in 5 kg, 10 kg, 25 kg, or 50 kg inner-lined PP/HDPE bags, unless custom neutral or private-label packing is mutually agreed upon in writing.</p>

                        <h2>5. Taxes, Billing &amp; Payment Terms</h2>
                        <p>Applicable GST (Goods and Services Tax) is charged as per prevailing Indian government slabs on all commercial invoices. Buyers must provide accurate GSTIN and consignee details prior to billing so that GST Invoices and E-Way bills can be generated without errors. Payment terms (advance, against LR/bilty, or mutually agreed credit terms for regular buyers) are finalized per order confirmation.</p>

                        <h2>6. Culinary &amp; Informational Disclaimer</h2>
                        <p>Product descriptions, buying guides, and trade notes published on this website (including references to ASTA colour, SHU heat, or curcumin percentage) are provided for general commercial and culinary guidance. Buyers with specific laboratory certification requirements should specify them before placing a purchase order.</p>

                        <h2>7. Intellectual Property</h2>
                        <p>All content, logo assets, product specification tables, and original trade guides published on this website belong to <strong>AMSB GLOBAL</strong> and may not be copied or redistributed for commercial use without prior written permission.</p>

                        <h2>8. Governing Law &amp; Jurisdiction</h2>
                        <p>All commercial transactions, contracts, and disputes arising out of business dealings with AMSB GLOBAL shall be governed by the laws of India and subject exclusively to the jurisdiction of the competent courts in <strong>Morbi, Gujarat</strong>.</p>

                        <h2>9. Official Trade Contact</h2>
                        <div class="policy-contact-box">
                            <h4><i class="fa-solid fa-building"></i> AMSB GLOBAL</h4>
                            <p><strong>Contact Person:</strong> <?= e($brand['founder']) ?></p>
                            <p><strong>Address:</strong> Wankaner, Morbi, Gujarat - 363621, India</p>
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
                        <li><a href="shipping-return.php"><i class="fa-solid fa-truck-fast"></i> Shipping &amp; Dispatch</a></li>
                        <li><a href="terms-condition.php" class="active"><i class="fa-solid fa-file-contract"></i> Terms &amp; Conditions</a></li>
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
                        <div class="pdd-ico"><i class="fa-solid fa-handshake"></i></div>
                        <div>
                            <small>Wholesale Inquiries</small>
                            <h4><?= e($brand['founder']) ?></h4>
                            <span>AMSB GLOBAL • Wankaner, Morbi</span>
                        </div>
                    </div>
                    <p>Ready to start with a courier sample or request today’s bulk wholesale quotation?</p>
                    <div class="pdd-links">
                        <a href="contact.php"><i class="fa-solid fa-file-invoice-dollar"></i> Request Bulk Quote</a>
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