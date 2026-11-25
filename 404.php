<?php
http_response_code(404);
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'config/connect.php';

$meta_title = '404 Page Not Found | AMSB GLOBAL';
$meta_desc  = 'The page you are looking for could not be found. Browse wholesale Red Chilli Powder and Turmeric Powder at AMSB GLOBAL.';
$meta_key   = '404, AMSB Global';

include_once 'includes/header.php';
?>

<main id="main" class="error-404-page">
    <section class="page-hero err-hero">
        <div class="wrap err-box">
            <div class="err-code">4<span>0</span>4</div>
            <div class="hero-badges" style="justify-content:center;">
                <span class="pill-primary"><i class="fa-solid fa-triangle-exclamation"></i> Page Not Found</span>
                <span class="pill-secondary"><i class="fa-solid fa-compass"></i> AMSB GLOBAL Trade Desk</span>
            </div>
            <h1>Oops! Ye Page Available Nahi Hai.</h1>
            <p class="lead">The URL you entered may have been moved, renamed, or typed incorrectly. Use the quick links below to explore our wholesale Red Chilli Powder &amp; Turmeric Powder catalogue or contact Mahir Bhai directly.</p>

            <div class="err-actions">
                <a href="<?= e(url()) ?>" class="btn"><i class="fa-solid fa-house"></i> Back to Homepage</a>
                <a href="<?= e(url('products/')) ?>" class="btn d"><i class="fa-solid fa-cubes"></i> Browse All Spices</a>
                <a href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode('Hello Mahir Bhai (AMSB GLOBAL), I need bulk rates for Red Chilli Powder and Turmeric Powder.') ?>" target="_blank" rel="noopener" class="btn wa-btn"><i class="fa-brands fa-whatsapp"></i> WhatsApp Desk</a>
            </div>

            <div class="err-quick-links">
                <a href="<?= e(url('about/')) ?>"><i class="fa-solid fa-building"></i> Company Profile</a>
                <a href="<?= e(url('category/red-chilli-powder/')) ?>"><i class="fa-solid fa-pepper-hot"></i> Red Chilli Powder</a>
                <a href="<?= e(url('category/turmeric-powder/')) ?>"><i class="fa-solid fa-sun"></i> Turmeric Powder</a>
                <a href="<?= e(url('blog/')) ?>"><i class="fa-regular fa-newspaper"></i> Trade Guides</a>
                <a href="<?= e(url('location/')) ?>"><i class="fa-solid fa-map-location-dot"></i> Supply Locations</a>
                <a href="<?= e(url('contact/')) ?>"><i class="fa-solid fa-phone"></i> Contact Trade Desk</a>
            </div>
        </div>
    </section>
</main>

<style>
.err-hero { padding: 78px 0 88px; text-align: center; }
.err-box { max-width: 760px; margin-inline: auto; }
.err-code {
    font-family: var(--font-head);
    font-size: clamp(4.8rem, 11vw, 7.5rem);
    font-weight: 800;
    line-height: 1;
    color: #081225;
    letter-spacing: 4px;
    margin-bottom: 14px;
}
.err-code span { color: var(--primary); }
.err-box .lead { margin-inline: auto; }
.err-actions {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 34px;
}
.err-quick-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    padding-top: 24px;
    border-top: 1px dashed rgba(8, 18, 37, 0.18);
}
.err-quick-links a {
    background: #fff;
    border: 1px solid rgba(43, 179, 214, 0.35);
    padding: 9px 15px;
    border-radius: 10px;
    font-size: 0.86rem;
    font-weight: 600;
    color: #081225;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.2s ease;
}
.err-quick-links a i { color: var(--primary); }
.err-quick-links a:hover {
    background: #081225;
    color: var(--primary);
    border-color: #081225;
    transform: translateY(-2px);
}
</style>

<?php include 'includes/footer.php'; ?>