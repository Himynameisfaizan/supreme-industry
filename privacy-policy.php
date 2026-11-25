<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$https_pl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
$base_pl  = ($https_pl ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
$curr_pl  = $base_pl . basename($_SERVER['PHP_SELF']);

$page_meta = [
    'title' => 'Privacy Policy | AMSB GLOBAL — Wholesale Spice Trader, Morbi',
    'desc'  => 'Read the Privacy Policy of AMSB GLOBAL (Wankaner, Morbi, Gujarat) detailing how we handle and protect buyer inquiry, GST billing, and wholesale trade data.',
    'key'   => 'AMSB Global privacy policy, B2B spice trader data protection, Wankaner Morbi wholesale spices',
    'schema' => '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebPage",
      "@id": "' . $curr_pl . '#webpage",
      "url": "' . $curr_pl . '",
      "name": "Privacy Policy - AMSB GLOBAL",
      "description": "Privacy Policy for B2B wholesale buyers and visitors of AMSB GLOBAL, Wankaner, Morbi, Gujarat.",
      "inLanguage": "en-IN",
      "isPartOf": { "@id": "' . $base_pl . '#website" }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "' . $curr_pl . '#breadcrumb",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "' . $base_pl . '" },
        { "@type": "ListItem", "position": 2, "name": "Privacy Policy", "item": "' . $curr_pl . '" }
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
                <span class="curr">Privacy Policy</span>
            </nav>
            <div class="hero-badges">
                <span class="pill-primary"><i class="fa-solid fa-shield-halved"></i> Buyer Data Protection</span>
                <span class="pill-secondary"><i class="fa-regular fa-calendar"></i> Last Updated: <?= date('d M Y') ?></span>
            </div>
            <h1>Privacy <span class="txt-primary">Policy</span></h1>
            <p class="lead">How <strong>AMSB GLOBAL</strong> collects, uses, and safeguards your business and contact information when you enquire about or purchase bulk Red Chilli Powder and Turmeric Powder.</p>
        </div>
    </section>

    <!-- 2. POLICY CONTENT + STICKY SIDEBAR -->
    <section class="sec bd-body-sec">
        <div class="wrap bd-grid">

            <!-- Left Column: Policy Content -->
            <article class="bd-main">
                <div class="bd-content-card policy-card">
                    <div class="dyn-richtext bd-prose">
                        <p>Welcome to <strong>AMSB GLOBAL</strong>, headquartered in Wankaner, Morbi, Gujarat (363621). We respect your privacy and are committed to safeguarding the personal and commercial information shared by wholesalers, distributors, food manufacturers, retailers, and visitors browsing our website or contacting our trade desk.</p>

                        <h2>1. Information We Collect</h2>
                        <p>When you submit a bulk rate inquiry, request courier samples, or confirm a wholesale purchase order with AMSB GLOBAL, we may collect:</p>
                        <ul>
                            <li><strong>Contact &amp; Identity Details:</strong> Your name, firm/company name, phone or WhatsApp number, and business email address.</li>
                            <li><strong>Billing &amp; Dispatch Details:</strong> Registered business address, delivery city/godown address, transport preferences, and GSTIN for generating valid GST Tax Invoices and E-Way bills.</li>
                            <li><strong>Trade Order Preferences:</strong> Required spice varieties (Red Chilli Powder / Turmeric Powder), grade specifications, bag sizes (5 kg to 50 kg), and order quantities.</li>
                            <li><strong>Basic Technical Data:</strong> Standard browser type, IP address, and page visit metrics collected automatically to keep our website fast, secure, and functional.</li>
                        </ul>

                        <h2>2. How We Use Your Information</h2>
                        <p>Your information is strictly used for genuine B2B trading and order execution:</p>
                        <ul>
                            <li>To prepare and send accurate daily wholesale rate quotations and dispatch physical courier samples.</li>
                            <li>To process, pack, weigh, and dispatch bulk spice orders along with GST invoices, E-Way bills, and transport LR copies.</li>
                            <li>To coordinate lot verification, pre-loading photos/videos, and delivery updates via phone, WhatsApp, or email.</li>
                            <li>To comply with Indian tax laws (GST), FSSAI food safety norms, and statutory accounting requirements.</li>
                        </ul>

                        <h2>3. Payment &amp; Banking Confidentiality</h2>
                        <p>Most wholesale trade orders at AMSB GLOBAL are settled via standard bank transfers (NEFT, RTGS, IMPS, or UPI). We do not store your net-banking credentials, debit/credit card details, or UPI PINs on our website servers. Only standard banking reference/UTR details required for GST accounting and payment reconciliation are maintained securely.</p>

                        <h2>4. Information Sharing &amp; Third Parties</h2>
                        <p>We <strong>never sell, rent, or trade</strong> your business contact list or pricing inquiries to third-party marketers or brokers. Information is shared strictly on a need-to-know basis with:</p>
                        <ul>
                            <li><strong>Courier &amp; Road Transport Partners:</strong> Only recipient name, phone number, and delivery address needed to deliver samples or bulk shipments safely.</li>
                            <li><strong>Statutory &amp; Tax Authorities:</strong> Where legally required under GST, E-Way bill portals, or Indian law.</li>
                        </ul>

                        <h2>5. Cookies &amp; Website Analytics</h2>
                        <p>Our website may use basic cookies to remember session settings and understand overall site performance. You can disable cookies anytime through your browser settings without losing access to our product catalogue or trade desk contact details.</p>

                        <h2>6. Data Security &amp; Retention</h2>
                        <p>We use SSL encryption, secure server hosting, and restricted administrative access to protect all inquiry records from unauthorized access or misuse. Commercial billing records are retained only for the duration required under Indian GST and business accounting regulations.</p>

                        <h2>7. Contact Our Trade Desk</h2>
                        <p>If you have any questions about this Privacy Policy or wish to update or remove your inquiry details from our records, please reach us directly:</p>

                        <div class="policy-contact-box">
                            <h4><i class="fa-solid fa-building"></i> AMSB GLOBAL</h4>
                            <p><strong>Contact Person:</strong> <?= e($brand['founder']) ?></p>
                            <p><strong>Products:</strong> Wholesale Red Chilli Powder &amp; Turmeric Powder</p>
                            <p><strong>Address:</strong> Wankaner, Morbi, Gujarat - 363621, India</p>
                            <p><strong>Phone / WhatsApp:</strong> <a href="tel:+<?= e($tel) ?>"><?= e($disp_phone) ?></a></p>
                            <p><strong>Email:</strong> <a href="mailto:<?= e($mail) ?>"><?= e($mail) ?></a></p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Right Sticky Sidebar -->
            <aside class="bd-sidebar">
                <!-- Policy Switcher -->
                <div class="sb-card">
                    <h4><i class="fa-solid fa-scale-balanced"></i> Legal &amp; Trade Policies</h4>
                    <ul class="policy-nav">
                        <li><a href="privacy-policy.php" class="active"><i class="fa-solid fa-shield-halved"></i> Privacy Policy</a></li>
                        <li><a href="refund-policy.php"><i class="fa-solid fa-rotate-left"></i> Refund &amp; Cancellation</a></li>
                        <li><a href="shipping-return.php"><i class="fa-solid fa-truck-fast"></i> Shipping &amp; Dispatch</a></li>
                        <li><a href="terms-condition.php"><i class="fa-solid fa-file-contract"></i> Terms &amp; Conditions</a></li>
                    </ul>
                </div>

                <!-- Search Products -->
                <div class="sb-card">
                    <h4><i class="fa-solid fa-magnifying-glass"></i> Search Spices</h4>
                    <form action="products.php" method="GET" class="sb-search-form">
                        <input type="search" name="q" placeholder="Search chilli, turmeric..." required>
                        <button type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <!-- Dynamic Categories -->
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

                <!-- Direct Trade Desk Card -->
                <div class="pd-desk-card">
                    <div class="pdd-top">
                        <div class="pdd-ico"><i class="fa-solid fa-headset"></i></div>
                        <div>
                            <small>Direct Trade Support</small>
                            <h4><?= e($brand['founder']) ?></h4>
                            <span>AMSB GLOBAL • Wankaner, Morbi</span>
                        </div>
                    </div>
                    <p>Need today’s bulk wholesale rate or courier samples for Red Chilli Powder &amp; Turmeric Powder?</p>
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